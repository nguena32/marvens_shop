<?php
declare(strict_types=1);

namespace App\Application\Services\Theme;

use App\Domain\Themes\Theme;
use PDO;
use RuntimeException;
use InvalidArgumentException;

/**
 * Service Applicatif de gestion, inventaire, sécurisation et activation des Thèmes
 */
class ThemeService
{
    private PDO $pdo;
    private string $themesDir;

    public const DEFAULT_THEME = 'fashion';
    public const ALLOWED_THEMES = ['fashion', 'bello', 'luxe', 'naya', 'shop'];

    public function __construct(PDO $pdo, ?string $themesDir = null)
    {
        $this->pdo = $pdo;
        $this->themesDir = $themesDir ?? dirname(__DIR__, 4) . '/themes';
    }

    /**
     * Retourne la liste exhaustive des métadonnées des thèmes disponibles
     * @return Theme[]
     */
    public function getAvailableThemes(): array
    {
        $catalog = [
            'fashion' => new Theme(
                id: 'fashion',
                name: 'Theme Fashion',
                description: 'Style prêt-à-porter raffiné, tons ambrés et élégance éditoriale moderne conçue pour la mode et les accessoires.',
                previewImage: '/assets/themes/fashion.png',
                primaryColors: ['#8d4b00', '#dae2fd', '#fff8f5', '#231a13'],
                features: [
                    'Hero avec badge exclusif et double CTA',
                    'Bandeau d\'annonce supérieure',
                    'Grille éditoriale aérée et cartes douces',
                    'Filtres par catégories réactifs',
                    'Optimisé smartphone et WhatsApp'
                ],
                catalogStyle: 'Grille fluide moderne (2 col mobile, 4 col desktop)',
                productCardStyle: 'Cartes épurées avec ratio 4:5 et badge prix ambre',
                navigationStyle: 'Header sticky blanc cassé avec recherche et panier direct',
                productPageStyle: 'Fiche éditoriale avec sélecteur de quantité et réassurance',
                cartStyle: 'Panier récapitulatif avec total en temps réel et checkout express',
                homeStyle: 'Vitrine immersive avec collections phares et avis clients',
                tailwindColors: [
                    'primary' => '#8d4b00',
                    'primary-container' => '#b15f00',
                    'on-primary' => '#ffffff',
                    'surface' => '#fff8f5',
                    'surface-container' => '#fdeade',
                    'surface-container-high' => '#f7e5d9',
                    'surface-container-highest' => '#f2dfd3',
                    'background' => '#F8FAFC',
                    'on-surface' => '#231a13',
                    'border' => '#E2E8F0',
                    'secondary' => '#565e74',
                ],
                typography: ['headline' => 'Space Grotesk', 'body' => 'Inter'],
                buttonStyle: 'rounded-xl font-semibold',
                cardStyle: 'rounded-2xl border border-border bg-surface',
                layoutStyle: 'editorial-amber'
            ),
            'bello' => new Theme(
                id: 'bello',
                name: 'Theme Bello',
                description: 'Design chaleureux, contrastes doux et lisibilité commerciale pour épiceries fines, cosmétiques et bien-être.',
                previewImage: '/assets/themes/bello.png',
                primaryColors: ['#c2410c', '#fdfaf6', '#431407', '#fed7aa'],
                features: [
                    'Palette chaleureuse terracotta et tons terre',
                    'Typographies organiques et confort de lecture',
                    'Mise en valeur artisanale des ingrédients ou composants',
                    'Expérience d\'achat rassurante',
                    'Boutons aux courbures douces'
                ],
                catalogStyle: 'Disposition aérée avec focus sur l\'authenticité',
                productCardStyle: 'Cartes douces avec ombres subtiles et bordures feutrées',
                navigationStyle: 'Barre de navigation claire avec logo centré',
                productPageStyle: 'Fiche produit détaillée axée bienfaits et authenticité',
                cartStyle: 'Panier épuré avec incitation au palier de livraison',
                homeStyle: 'Accueil narratif mettant en valeur l\'histoire des produits',
                tailwindColors: [
                    'primary' => '#c2410c',
                    'primary-container' => '#ea580c',
                    'on-primary' => '#ffffff',
                    'surface' => '#fdfaf6',
                    'surface-container' => '#ffedd5',
                    'surface-container-high' => '#fed7aa',
                    'surface-container-highest' => '#fdba74',
                    'background' => '#FFFBEB',
                    'on-surface' => '#431407',
                    'border' => '#FED7AA',
                    'secondary' => '#78350f',
                ],
                typography: ['headline' => 'Space Grotesk', 'body' => 'Inter'],
                buttonStyle: 'rounded-2xl font-medium',
                cardStyle: 'rounded-3xl border border-[#fed7aa] bg-[#fdfaf6]',
                layoutStyle: 'warm-terracotta'
            ),
            'luxe' => new Theme(
                id: 'luxe',
                name: 'Theme Luxe',
                description: 'Ambiance neo-brutaliste et haute précision inspirée de Bauhaus. Éléments graphiques tranchés, fort contraste et impact visuel.',
                previewImage: '/assets/themes/luxe.png',
                primaryColors: ['#1a1a1a', '#ffcc00', '#f5f0e8', '#e63b2e'],
                features: [
                    'Identité graphique neo-brutaliste et Bauhaus',
                    'Bordures solides marquées (2-3px) et ombres décalées',
                    'Typographie oversized Space Grotesk percutante',
                    'Accents vifs jaune primaire et rouge affirmé',
                    'Impact visuel premium mémorable'
                ],
                catalogStyle: 'Grille structurée à cadres noirs épais et contraste maximal',
                productCardStyle: 'Cartes géométriques angulaires à ombres franches décalées',
                navigationStyle: 'Header tranché à contours francs et navigation typographique',
                productPageStyle: 'Fiche produit percutante aux blocs techniques affirmés',
                cartStyle: 'Panier brutaliste ultra lisible et CTA haute visibilité',
                homeStyle: 'Hero architectural grandiose avec motifs géométriques',
                tailwindColors: [
                    'primary' => '#1a1a1a',
                    'primary-container' => '#ffcc00',
                    'on-primary' => '#ffffff',
                    'surface' => '#f5f0e8',
                    'surface-container' => '#eee9e0',
                    'surface-container-high' => '#e8e3da',
                    'surface-container-highest' => '#e2ddd4',
                    'background' => '#F5F0E8',
                    'on-surface' => '#1a1a1a',
                    'border' => '#1a1a1a',
                    'secondary' => '#e63b2e',
                ],
                typography: ['headline' => 'Space Grotesk', 'body' => 'Inter'],
                buttonStyle: 'rounded-none border-2 border-[#1a1a1a] shadow-[4px_4px_0px_#1a1a1a] font-bold uppercase',
                cardStyle: 'rounded-none border-2 border-[#1a1a1a] bg-[#f5f0e8] shadow-[4px_4px_0px_#1a1a1a]',
                layoutStyle: 'neo-brutalist'
            ),
            'naya' => new Theme(
                id: 'naya',
                name: 'Theme Naya',
                description: 'Style épuré, teintes naturelles et pastel conçu pour la beauté, la joaillerie discrète et les soins personnels.',
                previewImage: '/assets/themes/naya.png',
                primaryColors: ['#047857', '#ecfdf5', '#064e3b', '#a7f3d0'],
                features: [
                    'Palette vert émeraude et fraîcheur végétale',
                    'Lignes délicates et transitions soyeuses',
                    'Focus sur la pureté et la clarté des visuels',
                    'Parcours intuitif zen et épuré',
                    'Idéal produits naturels et bien-être'
                ],
                catalogStyle: 'Catalogue fluide avec filtres doux et mise en avant visuelle',
                productCardStyle: 'Cartes légères aux teintes mentholées et angles doux',
                navigationStyle: 'Menu minimaliste discret et élégant',
                productPageStyle: 'Fiche produit claire, aérée et apaisante',
                cartStyle: 'Tunnel de commande transparent et direct',
                homeStyle: 'Vitrine fraîcheur avec carrousels épurés',
                tailwindColors: [
                    'primary' => '#047857',
                    'primary-container' => '#059669',
                    'on-primary' => '#ffffff',
                    'surface' => '#f0fdf4',
                    'surface-container' => '#dcfce7',
                    'surface-container-high' => '#bbf7d0',
                    'surface-container-highest' => '#86efac',
                    'background' => '#F0FDF4',
                    'on-surface' => '#064e3b',
                    'border' => '#BBF7D0',
                    'secondary' => '#0f766e',
                ],
                typography: ['headline' => 'Space Grotesk', 'body' => 'Inter'],
                buttonStyle: 'rounded-full font-medium',
                cardStyle: 'rounded-2xl border border-[#bbf7d0] bg-[#ffffff]',
                layoutStyle: 'natural-emerald'
            ),
            'shop' => new Theme(
                id: 'shop',
                name: 'Theme Shop (Swiss Editorial)',
                description: 'Design Swiss Editorial rigoureux, structure noir et blanc contrastée avec accents ambrés pour un commerce polyvalent haute performance.',
                previewImage: '/assets/themes/shop.png',
                primaryColors: ['#000000', '#fe932c', '#ffffff', '#1b1b1d'],
                features: [
                    'Grille éditoriale suisse typographique',
                    'Contraste noir/blanc intemporel avec bouton ambré punchy',
                    'Mise en page polyvalente pour tout type de catalogue',
                    'Header intégrant bandeau livraison et WhatsApp direct',
                    'Idéal électronique, multi-produits et équipement'
                ],
                catalogStyle: 'Grille commerciale dense avec filtres précis et badges de disponibilité',
                productCardStyle: 'Cartes rationnelles avec titre gras, prix lisible et bouton direct',
                navigationStyle: 'Header moderne avec recherche proéminente et accès rapide au panier',
                productPageStyle: 'Présentation technique structurée et points forts explicites',
                cartStyle: 'Panier latéral dynamique et récapitulatif détaillé',
                homeStyle: 'Page d\'accueil percutante avec bannières promo et collections phares',
                tailwindColors: [
                    'primary' => '#000000',
                    'primary-container' => '#131b2e',
                    'on-primary' => '#ffffff',
                    'surface' => '#FFFFFF',
                    'surface-container' => '#f0edef',
                    'surface-container-high' => '#eae7e9',
                    'surface-container-highest' => '#e4e2e4',
                    'background' => '#F8FAFC',
                    'on-surface' => '#1b1b1d',
                    'border' => '#E2E8F0',
                    'secondary' => '#904d00',
                    'secondary-container' => '#fe932c',
                ],
                typography: ['headline' => 'Inter', 'body' => 'Inter'],
                buttonStyle: 'rounded-lg font-semibold bg-[#fe932c] text-white',
                cardStyle: 'rounded-xl border border-border bg-white',
                layoutStyle: 'swiss-editorial'
            )
        ];

        return $catalog;
    }

    /**
     * Récupère un thème par son identifiant
     */
    public function getTheme(string $themeId): ?Theme
    {
        $themes = $this->getAvailableThemes();
        return $themes[$themeId] ?? null;
    }

    /**
     * Récupère l'identifiant du thème actif
     */
    public function getActiveThemeId(): string
    {
        $stmt = $this->pdo->prepare("SELECT setting_value FROM shop_settings WHERE setting_key = 'active_theme' LIMIT 1");
        $stmt->execute();
        $val = $stmt->fetchColumn();

        if ($val && in_array((string)$val, self::ALLOWED_THEMES, true)) {
            return (string)$val;
        }

        return self::DEFAULT_THEME;
    }

    /**
     * Récupère l'objet Thème actif
     */
    public function getActiveTheme(): Theme
    {
        $id = $this->getActiveThemeId();
        return $this->getTheme($id) ?? $this->getTheme(self::DEFAULT_THEME);
    }

    /**
     * Récupère l'identifiant du thème précédent
     */
    public function getPreviousThemeId(): ?string
    {
        $stmt = $this->pdo->prepare("SELECT setting_value FROM shop_settings WHERE setting_key = 'previous_theme' LIMIT 1");
        $stmt->execute();
        $val = $stmt->fetchColumn();

        if ($val && in_array((string)$val, self::ALLOWED_THEMES, true)) {
            return (string)$val;
        }

        return null;
    }

    /**
     * Active un thème de manière sécurisée (sauvegarde de l'ancien pour rollback)
     */
    public function activateTheme(string $themeId): bool
    {
        if (!in_array($themeId, self::ALLOWED_THEMES, true)) {
            throw new InvalidArgumentException("Thème '{$themeId}' non autorisé.");
        }

        $currentTheme = $this->getActiveThemeId();

        if ($currentTheme === $themeId) {
            return true; // Déjà actif
        }

        // Sauvegarder le thème précédent
        $this->saveSetting('previous_theme', $currentTheme);
        // Enregistrer le nouveau thème actif
        $this->saveSetting('active_theme', $themeId);

        return true;
    }

    /**
     * Revenir au thème précédent
     */
    public function rollbackToPreviousTheme(): bool
    {
        $previousTheme = $this->getPreviousThemeId();
        if (!$previousTheme) {
            throw new RuntimeException("Aucun thème précédent enregistré pour le retour arrière.");
        }

        return $this->activateTheme($previousTheme);
    }

    /**
     * Réinitialiser le thème aux paramètres par défaut (Fashion)
     */
    public function resetToDefaultTheme(): bool
    {
        return $this->activateTheme(self::DEFAULT_THEME);
    }

    /**
     * Vérification de sécurité : garantit que le changement de thème ne touche aucune donnée commerciale
     */
    public function verifyDataIntegrityBeforeAndAfter(callable $action): array
    {
        $before = [
            'products_count' => (int) $this->pdo->query("SELECT COUNT(*) FROM products")->fetchColumn(),
            'categories_count' => (int) $this->pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn(),
            'orders_count' => (int) $this->pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn(),
        ];

        $action();

        $after = [
            'products_count' => (int) $this->pdo->query("SELECT COUNT(*) FROM products")->fetchColumn(),
            'categories_count' => (int) $this->pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn(),
            'orders_count' => (int) $this->pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn(),
        ];

        if ($before !== $after) {
            throw new RuntimeException("Violation d'intégrité : les données commerciales ont été altérées !");
        }

        return ['success' => true, 'counts' => $after];
    }

    private function saveSetting(string $key, string $value): void
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO shop_settings (setting_key, setting_value) VALUES (:k, :v)
                                          ON DUPLICATE KEY UPDATE setting_value = :v");
            $stmt->execute(['k' => $key, 'v' => $value]);
        } catch (\Exception $e) {
            // Fallback SQLite / standard
            $this->pdo->exec(sprintf(
                "REPLACE INTO shop_settings (setting_key, setting_value) VALUES (%s, %s)",
                $this->pdo->quote($key),
                $this->pdo->quote($value)
            ));
        }
    }
}
