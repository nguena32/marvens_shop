<?php
declare(strict_types=1);

namespace App\Application\Services;

use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use RuntimeException;

/**
 * Service d'importation de catalogue via fichier CSV ou Excel / XLSX / XML
 * Règle MS-BIZ-09 : Validation stricte ligne par ligne et déduplication intelligente
 */
class CsvImportService
{
    private ProductRepository $productRepo;
    private CategoryRepository $categoryRepo;

    public function __construct(ProductRepository $productRepo, CategoryRepository $categoryRepo)
    {
        $this->productRepo = $productRepo;
        $this->categoryRepo = $categoryRepo;
    }

    /**
     * Importe un fichier CSV ou Excel (XLSX décompressé / XML spreadsheet)
     */
    public function import(string $filePath): array
    {
        if (!file_exists($filePath)) {
            throw new RuntimeException("Le fichier est introuvable à l'emplacement : {$filePath}");
        }

        // Détection de l'extension ou contenu
        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        if ($ext === 'xlsx') {
            return $this->importXlsx($filePath);
        }

        $content = file_get_contents($filePath);
        if ($content === false || trim($content) === '') {
            throw new RuntimeException("Le fichier est vide ou illisible.");
        }

        return $this->importString($content);
    }

    /**
     * Parseur natif pour XLSX (archive ZIP contenant xl/sharedStrings.xml et xl/worksheets/sheet1.xml)
     * Sans aucune bibliothèque externe lourde (conforme hébergement cPanel)
     */
    public function importXlsx(string $filePath): array
    {
        if (!class_exists('\ZipArchive')) {
            throw new RuntimeException("L'extension PHP ZipArchive n'est pas disponible pour lire le fichier Excel (.xlsx). Veuillez utiliser l'import CSV standard.");
        }

        $zip = new \ZipArchive();
        if ($zip->open($filePath) !== true) {
            throw new RuntimeException("Impossible d'ouvrir le fichier .xlsx (archive corrompue ou invalide).");
        }

        $sharedStrings = [];
        $sharedStringsXml = $zip->getFromName('xl/sharedStrings.xml');
        if ($sharedStringsXml !== false) {
            $xml = @simplexml_load_string($sharedStringsXml);
            if ($xml) {
                foreach ($xml->si as $val) {
                    $sharedStrings[] = isset($val->t) ? (string)$val->t : (string)($val->r->t ?? '');
                }
            }
        }

        $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
        $zip->close();

        if ($sheetXml === false) {
            throw new RuntimeException("Feuille de calcul principale introuvable dans le fichier .xlsx.");
        }

        $xml = @simplexml_load_string($sheetXml);
        if (!$xml || !isset($xml->sheetData->row)) {
            throw new RuntimeException("Données de feuille de calcul introuvables ou format invalide.");
        }

        $rows = [];
        foreach ($xml->sheetData->row as $row) {
            $rowData = [];
            foreach ($row->c as $cell) {
                $type = (string)$cell['t'];
                $val = (string)$cell->v;
                if ($type === 's' && isset($sharedStrings[(int)$val])) {
                    $rowData[] = $sharedStrings[(int)$val];
                } else {
                    $rowData[] = $val;
                }
            }
            if (!empty(array_filter($rowData, fn($v) => trim((string)$v) !== ''))) {
                $rows[] = $rowData;
            }
        }

        if (count($rows) < 2) {
            throw new RuntimeException("Le fichier Excel doit comporter au moins une ligne d'en-tête et une ligne de produit.");
        }

        // Convertir en format lignes tabulaires
        return $this->processStructuredRows($rows);
    }

    public function importString(string $csvContent): array
    {
        $lines = array_filter(array_map('trim', explode("\n", $csvContent)));
        if (count($lines) < 2) {
            throw new RuntimeException("Le fichier CSV doit comporter un en-tête et au moins une ligne de données.");
        }

        $firstLine = array_shift($lines);
        $delimiter = str_contains($firstLine, ';') ? ';' : (str_contains($firstLine, "\t") ? "\t" : ',');

        $header = str_getcsv($firstLine, $delimiter);
        $rows = [$header];
        foreach ($lines as $line) {
            if (trim($line) === '') continue;
            $rows[] = str_getcsv($line, $delimiter);
        }

        return $this->processStructuredRows($rows);
    }

    private function processStructuredRows(array $rows): array
    {
        $firstRow = array_shift($rows);
        $header = array_map(fn($col) => strtolower(trim((string)$col)), $firstRow);

        $expected = ['name', 'price'];
        foreach ($expected as $exp) {
            if (!in_array($exp, $header, true)) {
                throw new RuntimeException("Le fichier doit au minimum comporter les colonnes 'name' et 'price'.");
            }
        }

        $colIndices = array_flip($header);
        $created = 0;
        $updated = 0;
        $errors = [];
        $lineNum = 1;

        // Charger le cache des catégories
        $categories = $this->categoryRepo->findAll();
        $catMap = [];
        foreach ($categories as $cat) {
            $catMap[strtolower($cat['name'])] = (int)$cat['id'];
        }

        foreach ($rows as $row) {
            $lineNum++;
            $name = trim((string)($row[$colIndices['name']] ?? ''));
            $priceStr = trim((string)($row[$colIndices['price']] ?? ''));

            if ($name === '' || !is_numeric($priceStr)) {
                $errors[] = "Ligne {$lineNum} : Nom vide ou prix invalide ('{$name}', '{$priceStr}').";
                continue;
            }

            $price = (int) $priceStr;
            $sku = isset($colIndices['sku']) ? trim((string)($row[$colIndices['sku']] ?? '')) : null;
            $desc = isset($colIndices['description']) ? trim((string)($row[$colIndices['description']] ?? '')) : null;
            $promoPrice = isset($colIndices['promotional_price']) && is_numeric($row[$colIndices['promotional_price']])
                ? (int) $row[$colIndices['promotional_price']]
                : null;
            $categoryName = isset($colIndices['category']) ? trim((string)($row[$colIndices['category']] ?? '')) : null;
            $imageUrl = isset($colIndices['image_url']) ? trim((string)($row[$colIndices['image_url']] ?? '')) : null;

            // Résolution ou création automatique de la catégorie
            $categoryId = null;
            if ($categoryName !== null && $categoryName !== '') {
                $catLower = strtolower($categoryName);
                if (isset($catMap[$catLower])) {
                    $categoryId = $catMap[$catLower];
                } else {
                    $catSlug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $categoryName), '-'));
                    $categoryId = $this->categoryRepo->create([
                        'name' => $categoryName,
                        'slug' => $catSlug !== '' ? $catSlug : 'cat-' . random_int(100, 999),
                        'sort_order' => 10,
                        'is_active' => 1,
                    ]);
                    $catMap[$catLower] = $categoryId;
                }
            }

            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-'));
            if ($slug === '') {
                $slug = 'produit-' . random_int(1000, 9999);
            }

            // Détection de produit existant par SKU d'abord, puis par slug
            $existing = null;
            if ($sku !== null && $sku !== '') {
                $all = $this->productRepo->findAllAdmin(null, $sku);
                foreach ($all as $item) {
                    if (strcasecmp((string)($item['sku'] ?? ''), $sku) === 0) {
                        $existing = $item;
                        break;
                    }
                }
            }
            if (!$existing) {
                $existing = $this->productRepo->findBySlug($slug);
            }

            if ($existing) {
                $this->productRepo->update((int) $existing['id'], [
                    'category_id' => $categoryId ?? $existing['category_id'],
                    'name' => $name,
                    'slug' => $existing['slug'],
                    'sku' => $sku ?: $existing['sku'],
                    'description' => $desc ?: $existing['description'],
                    'price' => $price,
                    'promotional_price' => $promoPrice,
                    'main_image_url' => $imageUrl ?: $existing['main_image_url'],
                    'is_active' => $existing['is_active'],
                    'is_featured' => $existing['is_featured'],
                ]);
                $updated++;
            } else {
                $this->productRepo->create([
                    'category_id' => $categoryId,
                    'name' => $name,
                    'slug' => $slug . '-' . random_int(100, 999),
                    'sku' => $sku,
                    'description' => $desc,
                    'price' => $price,
                    'promotional_price' => $promoPrice,
                    'main_image_url' => $imageUrl,
                    'is_active' => 1,
                    'is_featured' => 0,
                ]);
                $created++;
            }
        }

        return [
            'created' => $created,
            'updated' => $updated,
            'errors' => $errors,
            'total_processed' => $created + $updated + count($errors),
        ];
    }

    /**
     * Génère le contenu d'un fichier CSV exemple prêt à l'emploi
     */
    public function generateTemplateCsv(): string
    {
        $headers = ['name', 'price', 'promotional_price', 'sku', 'category', 'description', 'image_url'];
        $rows = [
            $headers,
            ['Robe Longue Sahara', '18500', '15000', 'ROBE-SAH-01', 'Mode & Vêtements', 'Coton léger et respirant avec broderies artisanales', 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600'],
            ['Montre Chronographe Acier', '45000', '', 'MONTRE-AC-02', 'Accessoires', 'Mouvement quartz haute précision, étanche 50m', 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600'],
            ['Sac à Main Cuir Marron', '25000', '22500', 'SAC-CUIR-03', 'Maroquinerie', 'Cuir véritable teinté à la main', 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=600']
        ];

        $output = fopen('php://temp', 'r+');
        foreach ($rows as $row) {
            fputcsv($output, $row, ';');
        }
        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);

        return $csv !== false ? $csv : '';
    }
}
