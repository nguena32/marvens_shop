<?php
declare(strict_types=1);

namespace App\Application\Services;

use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use RuntimeException;

/**
 * Service d'importation de catalogue via fichier CSV ou chaîne CSV directe
 * Règle MS-BIZ-09 : Validation stricte ligne par ligne et déduplication
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

    public function import(string $filePath): array
    {
        if (!file_exists($filePath)) {
            throw new RuntimeException("Le fichier CSV est introuvable à l'emplacement : {$filePath}");
        }

        $content = file_get_contents($filePath);
        if ($content === false || trim($content) === '') {
            throw new RuntimeException("Le fichier CSV est vide ou illisible.");
        }

        return $this->importString($content);
    }

    public function importString(string $csvContent): array
    {
        $lines = array_filter(array_map('trim', explode("\n", $csvContent)));
        if (count($lines) < 2) {
            throw new RuntimeException("Le fichier CSV doit comporter un en-tête et au moins une ligne de données.");
        }

        $firstLine = array_shift($lines);
        $delimiter = str_contains($firstLine, ';') ? ';' : ',';

        $header = str_getcsv($firstLine, $delimiter);
        $header = array_map(fn($col) => strtolower(trim((string)$col)), $header);

        $expected = ['name', 'price'];
        foreach ($expected as $exp) {
            if (!in_array($exp, $header, true)) {
                throw new RuntimeException("Le fichier CSV doit au minimum comporter les colonnes 'name' et 'price'.");
            }
        }

        $colIndices = array_flip($header);
        $created = 0;
        $updated = 0;
        $errors = [];
        $lineNum = 1;

        foreach ($lines as $lineStr) {
            $lineNum++;
            if (trim($lineStr) === '') {
                continue;
            }

            $row = str_getcsv($lineStr, $delimiter);
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

            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-'));
            if ($slug === '') {
                $slug = 'produit-' . random_int(1000, 9999);
            }

            $existing = $this->productRepo->findBySlug($slug);
            if ($existing) {
                $this->productRepo->update((int) $existing['id'], [
                    'category_id' => $existing['category_id'],
                    'name' => $name,
                    'slug' => $slug,
                    'sku' => $sku ?: $existing['sku'],
                    'description' => $desc ?: $existing['description'],
                    'price' => $price,
                    'promotional_price' => $promoPrice,
                    'main_image_url' => $existing['main_image_url'],
                    'is_active' => $existing['is_active'],
                    'is_featured' => $existing['is_featured'],
                ]);
                $updated++;
            } else {
                $this->productRepo->create([
                    'category_id' => null,
                    'name' => $name,
                    'slug' => $slug . '-' . random_int(100, 999),
                    'sku' => $sku,
                    'description' => $desc,
                    'price' => $price,
                    'promotional_price' => $promoPrice,
                    'main_image_url' => null,
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
}
