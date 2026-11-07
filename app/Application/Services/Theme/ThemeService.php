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

    /**
     * Dictionnaire de mapping des palettes par défaut pour chaque thème
     */
    public function getDefaultCustomization(string $themeId): array
    {
        $theme = $this->getTheme($themeId) ?? $this->getTheme(self::DEFAULT_THEME);
        $tw = $theme->getTailwindColors();

        $defaults = [
            'fashion' => [
                // 3.1 Palette générale
                'primary_color' => '#8d4b00',
                'secondary_color' => '#565e74',
                'accent_color' => '#b15f00',
                'bg_primary' => '#F8FAFC',
                'bg_secondary' => '#fff8f5',
                'surface_color' => '#ffffff',
                'border_color' => '#E2E8F0',
                'text_color' => '#231a13',
                'title_color' => '#231a13',
                'link_color' => '#8d4b00',
                'btn_color' => '#8d4b00',
                'btn_hover_color' => '#703c00',
                'price_color' => '#8d4b00',
                'promo_color' => '#ba1a1a',
                'badge_color' => '#8d4b00',
                'nav_color' => '#231a13',

                // 3.2 Personnalisation des boutons
                'btn_primary_bg' => '#8d4b00',
                'btn_secondary_bg' => '#565e74',
                'btn_text_color' => '#ffffff',
                'btn_hover_bg' => '#703c00',
                'btn_style' => 'filled', // filled, outline, soft
                'btn_radius' => 'rounded-xl', // rounded-none, rounded-md, rounded-xl, rounded-full

                // 3.3 Personnalisation des cartes produits
                'card_bg' => '#ffffff',
                'card_border' => '#E2E8F0',
                'card_style' => 'bordered', // bordered, elevated, flat
                'card_radius' => 'rounded-2xl', // rounded-none, rounded-md, rounded-xl, rounded-2xl
                'card_spacing' => 'normal', // compact, normal, spacious
                'card_price_style' => 'badge', // standard, bold, badge
                'card_promo_style' => 'ribbon', // badge, ribbon, pill
                'card_btn_style' => 'filled', // filled, icon_only, outline
            ],
            'bello' => [
                'primary_color' => '#c2410c',
                'secondary_color' => '#78350f',
                'accent_color' => '#ea580c',
                'bg_primary' => '#FFFBEB',
                'bg_secondary' => '#fdfaf6',
                'surface_color' => '#fdfaf6',
                'border_color' => '#FED7AA',
                'text_color' => '#431407',
                'title_color' => '#431407',
                'link_color' => '#c2410c',
                'btn_color' => '#c2410c',
                'btn_hover_color' => '#9a3412',
                'price_color' => '#c2410c',
                'promo_color' => '#dc2626',
                'badge_color' => '#c2410c',
                'nav_color' => '#431407',

                'btn_primary_bg' => '#c2410c',
                'btn_secondary_bg' => '#78350f',
                'btn_text_color' => '#ffffff',
                'btn_hover_bg' => '#9a3412',
                'btn_style' => 'filled',
                'btn_radius' => 'rounded-2xl',

                'card_bg' => '#fdfaf6',
                'card_border' => '#FED7AA',
                'card_style' => 'bordered',
                'card_radius' => 'rounded-3xl',
                'card_spacing' => 'spacious',
                'card_price_style' => 'standard',
                'card_promo_style' => 'pill',
                'card_btn_style' => 'filled',
            ],
            'luxe' => [
                'primary_color' => '#1a1a1a',
                'secondary_color' => '#e63b2e',
                'accent_color' => '#ffcc00',
                'bg_primary' => '#F5F0E8',
                'bg_secondary' => '#eee9e0',
                'surface_color' => '#F5F0E8',
                'border_color' => '#1a1a1a',
                'text_color' => '#1a1a1a',
                'title_color' => '#1a1a1a',
                'link_color' => '#1a1a1a',
                'btn_color' => '#1a1a1a',
                'btn_hover_color' => '#333333',
                'price_color' => '#1a1a1a',
                'promo_color' => '#e63b2e',
                'badge_color' => '#ffcc00',
                'nav_color' => '#1a1a1a',

                'btn_primary_bg' => '#1a1a1a',
                'btn_secondary_bg' => '#e63b2e',
                'btn_text_color' => '#ffffff',
                'btn_hover_bg' => '#333333',
                'btn_style' => 'filled',
                'btn_radius' => 'rounded-none',

                'card_bg' => '#f5f0e8',
                'card_border' => '#1a1a1a',
                'card_style' => 'bordered',
                'card_radius' => 'rounded-none',
                'card_spacing' => 'compact',
                'card_price_style' => 'bold',
                'card_promo_style' => 'badge',
                'card_btn_style' => 'filled',
            ],
            'naya' => [
                'primary_color' => '#047857',
                'secondary_color' => '#0f766e',
                'accent_color' => '#059669',
                'bg_primary' => '#F0FDF4',
                'bg_secondary' => '#ecfdf5',
                'surface_color' => '#ffffff',
                'border_color' => '#BBF7D0',
                'text_color' => '#064e3b',
                'title_color' => '#064e3b',
                'link_color' => '#047857',
                'btn_color' => '#047857',
                'btn_hover_color' => '#065f46',
                'price_color' => '#047857',
                'promo_color' => '#dc2626',
                'badge_color' => '#047857',
                'nav_color' => '#064e3b',

                'btn_primary_bg' => '#047857',
                'btn_secondary_bg' => '#0f766e',
                'btn_text_color' => '#ffffff',
                'btn_hover_bg' => '#065f46',
                'btn_style' => 'filled',
                'btn_radius' => 'rounded-full',

                'card_bg' => '#ffffff',
                'card_border' => '#bbf7d0',
                'card_style' => 'bordered',
                'card_radius' => 'rounded-2xl',
                'card_spacing' => 'normal',
                'card_price_style' => 'standard',
                'card_promo_style' => 'pill',
                'card_btn_style' => 'filled',
            ],
            'shop' => [
                'primary_color' => '#000000',
                'secondary_color' => '#904d00',
                'accent_color' => '#fe932c',
                'bg_primary' => '#F8FAFC',
                'bg_secondary' => '#f0edef',
                'surface_color' => '#FFFFFF',
                'border_color' => '#E2E8F0',
                'text_color' => '#1b1b1d',
                'title_color' => '#1b1b1d',
                'link_color' => '#000000',
                'btn_color' => '#fe932c',
                'btn_hover_color' => '#ea580c',
                'price_color' => '#000000',
                'promo_color' => '#dc2626',
                'badge_color' => '#fe932c',
                'nav_color' => '#1b1b1d',

                'btn_primary_bg' => '#fe932c',
                'btn_secondary_bg' => '#904d00',
                'btn_text_color' => '#ffffff',
                'btn_hover_bg' => '#ea580c',
                'btn_style' => 'filled',
                'btn_radius' => 'rounded-lg',

                'card_bg' => '#ffffff',
                'card_border' => '#e2e8f0',
                'card_style' => 'bordered',
                'card_radius' => 'rounded-xl',
                'card_spacing' => 'compact',
                'card_price_style' => 'bold',
                'card_promo_style' => 'badge',
                'card_btn_style' => 'filled',
            ]
        ];

        return $defaults[$themeId] ?? $defaults[self::DEFAULT_THEME];
    }

    /**
     * Récupère la personnalisation sauvegardée pour un thème, avec fallback sur les valeurs par défaut
     */
    public function getThemeCustomization(string $themeId): array
    {
        $default = $this->getDefaultCustomization($themeId);

        $stmt = $this->pdo->prepare("SELECT setting_value FROM shop_settings WHERE setting_key = :k LIMIT 1");
        $stmt->execute(['k' => 'theme_colors_' . $themeId]);
        $val = $stmt->fetchColumn();

        if ($val && is_string($val)) {
            $decoded = json_decode($val, true);
            if (is_array($decoded)) {
                return array_merge($default, $decoded);
            }
        }

        return $default;
    }

    /**
     * Valide et sauvegarde la personnalisation des couleurs et composants pour un thème
     */
    public function saveThemeCustomization(string $themeId, array $data): bool
    {
        if (!in_array($themeId, self::ALLOWED_THEMES, true)) {
            throw new InvalidArgumentException("Thème '{$themeId}' non autorisé.");
        }

        $default = $this->getDefaultCustomization($themeId);
        $clean = [];

        // Règle de cascade automatique (Exigence 3.4) :
        // Si la couleur principale change et que les éléments associés (boutons principaux, liens, accents)
        // n'ont pas été explicitement modifiés, ils héritent automatiquement de la nouvelle couleur principale !
        $newPrimary = !empty($data['primary_color']) && $this->isValidHex($data['primary_color'])
            ? $data['primary_color']
            : $default['primary_color'];

        $originalPrimary = $default['primary_color'];
        $primaryHasChanged = (strcasecmp($newPrimary, $originalPrimary) !== 0);

        // Validation des codes hexadécimaux pour chaque couleur
        $colorKeys = [
            'primary_color', 'secondary_color', 'accent_color', 'bg_primary', 'bg_secondary',
            'surface_color', 'border_color', 'text_color', 'title_color', 'link_color',
            'btn_color', 'btn_hover_color', 'price_color', 'promo_color', 'badge_color', 'nav_color',
            'btn_primary_bg', 'btn_secondary_bg', 'btn_text_color', 'btn_hover_bg',
            'card_bg', 'card_border'
        ];

        foreach ($colorKeys as $k) {
            if (!empty($data[$k]) && $this->isValidHex($data[$k])) {
                $clean[$k] = $data[$k];
            } else {
                $clean[$k] = $default[$k];
            }
        }

        // Application de la cascade automatique si la couleur principale a été modifiée
        if ($primaryHasChanged) {
            // Si le bouton principal n'a pas été explicitement personnalisé par l'utilisateur ou correspondait à l'ancienne couleur
            if (empty($data['btn_primary_bg']) || strcasecmp($data['btn_primary_bg'], $originalPrimary) === 0) {
                $clean['btn_primary_bg'] = $newPrimary;
                $clean['btn_color'] = $newPrimary;
            }
            if (empty($data['link_color']) || strcasecmp($data['link_color'], $originalPrimary) === 0) {
                $clean['link_color'] = $newPrimary;
            }
            if (empty($data['accent_color']) || strcasecmp($data['accent_color'], $default['accent_color']) === 0) {
                $clean['accent_color'] = $newPrimary;
            }
        }

        // Validation des options de style par listes blanches strictes
        $allowedBtnStyles = ['filled', 'outline', 'soft'];
        $clean['btn_style'] = in_array($data['btn_style'] ?? '', $allowedBtnStyles, true)
            ? $data['btn_style']
            : $default['btn_style'];

        $allowedBtnRadii = ['rounded-none', 'rounded-md', 'rounded-lg', 'rounded-xl', 'rounded-2xl', 'rounded-full'];
        $clean['btn_radius'] = in_array($data['btn_radius'] ?? '', $allowedBtnRadii, true)
            ? $data['btn_radius']
            : $default['btn_radius'];

        $allowedCardStyles = ['bordered', 'elevated', 'flat'];
        $clean['card_style'] = in_array($data['card_style'] ?? '', $allowedCardStyles, true)
            ? $data['card_style']
            : $default['card_style'];

        $allowedCardRadii = ['rounded-none', 'rounded-md', 'rounded-lg', 'rounded-xl', 'rounded-2xl', 'rounded-3xl'];
        $clean['card_radius'] = in_array($data['card_radius'] ?? '', $allowedCardRadii, true)
            ? $data['card_radius']
            : $default['card_radius'];

        $allowedCardSpacing = ['compact', 'normal', 'spacious'];
        $clean['card_spacing'] = in_array($data['card_spacing'] ?? '', $allowedCardSpacing, true)
            ? $data['card_spacing']
            : $default['card_spacing'];

        $allowedPriceStyles = ['standard', 'bold', 'badge'];
        $clean['card_price_style'] = in_array($data['card_price_style'] ?? '', $allowedPriceStyles, true)
            ? $data['card_price_style']
            : $default['card_price_style'];

        $allowedPromoStyles = ['badge', 'ribbon', 'pill'];
        $clean['card_promo_style'] = in_array($data['card_promo_style'] ?? '', $allowedPromoStyles, true)
            ? $data['card_promo_style']
            : $default['card_promo_style'];

        $allowedCardBtnStyles = ['filled', 'icon_only', 'outline'];
        $clean['card_btn_style'] = in_array($data['card_btn_style'] ?? '', $allowedCardBtnStyles, true)
            ? $data['card_btn_style']
            : $default['card_btn_style'];

        $this->saveSetting('theme_colors_' . $themeId, json_encode($clean, JSON_UNESCAPED_SLASHES));
        return true;
    }

    /**
     * Réinitialise les couleurs et styles personnalisés d'un thème à sa configuration par défaut
     */
    public function resetThemeCustomization(string $themeId): bool
    {
        if (!in_array($themeId, self::ALLOWED_THEMES, true)) {
            throw new InvalidArgumentException("Thème '{$themeId}' non autorisé.");
        }

        try {
            $stmt = $this->pdo->prepare("DELETE FROM shop_settings WHERE setting_key = :k");
            $stmt->execute(['k' => 'theme_colors_' . $themeId]);
        } catch (\Exception $e) {
            $this->saveSetting('theme_colors_' . $themeId, json_encode($this->getDefaultCustomization($themeId)));
        }

        return true;
    }

    /**
     * Bibliothèque de polices d'écriture sûres et web-performantes (Exigence 4.2)
     */
    public const FONT_LIBRARY = [
        'Inter' => [
            'name' => 'Inter',
            'family' => "'Inter', system-ui, -apple-system, sans-serif",
            'category' => 'Sans-Serif',
            'description' => 'Neutre, moderne, ultra-lisible sur écran mobile.',
            'google_family' => 'Inter:wght@300;400;500;600;700;800',
            'preview_text' => 'Boutique élégante & commande rapide WhatsApp'
        ],
        'Space Grotesk' => [
            'name' => 'Space Grotesk',
            'family' => "'Space Grotesk', system-ui, sans-serif",
            'category' => 'Sans-Serif Géométrique',
            'description' => 'Caractère fort, géométrique, parfait pour les titres audacieux.',
            'google_family' => 'Space+Grotesk:wght@400;500;600;700;800',
            'preview_text' => 'Marvens Fashion Édition Limitée'
        ],
        'Plus Jakarta Sans' => [
            'name' => 'Plus Jakarta Sans',
            'family' => "'Plus Jakarta Sans', system-ui, sans-serif",
            'category' => 'Sans-Serif Moderne',
            'description' => 'Frais, contemporain, excellent pour le commerce haut de gamme.',
            'google_family' => 'Plus+Jakarta+Sans:wght@400;500;600;700;800',
            'preview_text' => 'Découvrez nos collections exclusives'
        ],
        'Outfit' => [
            'name' => 'Outfit',
            'family' => "'Outfit', system-ui, sans-serif",
            'category' => 'Sans-Serif Rond',
            'description' => 'Doux, convivial et expressif.',
            'google_family' => 'Outfit:wght@400;500;600;700',
            'preview_text' => 'Qualité artisanale garantie'
        ],
        'Poppins' => [
            'name' => 'Poppins',
            'family' => "'Poppins', system-ui, sans-serif",
            'category' => 'Sans-Serif Géométrique',
            'description' => 'Très populaire en e-commerce pour sa clarté et son dynamisme.',
            'google_family' => 'Poppins:wght@400;500;600;700;800',
            'preview_text' => 'Offres spéciales & promotions'
        ],
        'Playfair Display' => [
            'name' => 'Playfair Display',
            'family' => "'Playfair Display', Georgia, serif",
            'category' => 'Serif Élégant',
            'description' => 'Traditionnel, raffiné, idéal pour les boutiques luxe et beauté.',
            'google_family' => 'Playfair+Display:ital,wght@0,400;0,600;0,700;1,400',
            'preview_text' => 'L\'art du raffinement à votre portée'
        ],
        'Cinzel' => [
            'name' => 'Cinzel',
            'family' => "'Cinzel', Georgia, serif",
            'category' => 'Serif Classique',
            'description' => 'Inspiré de la typographie romaine classique pour un prestige statutaire.',
            'google_family' => 'Cinzel:wght@500;600;700;800',
            'preview_text' => 'HORLOGERIE & JOAILLERIE FINE'
        ],
        'DM Sans' => [
            'name' => 'DM Sans',
            'family' => "'DM Sans', system-ui, sans-serif",
            'category' => 'Sans-Serif Minimal',
            'description' => 'Précis, compact et très performant sur les petits écrans.',
            'google_family' => 'DM+Sans:wght@400;500;700',
            'preview_text' => 'Simplicité et efficacité d\'achat'
        ],
        'Montserrat' => [
            'name' => 'Montserrat',
            'family' => "'Montserrat', system-ui, sans-serif",
            'category' => 'Sans-Serif Urbain',
            'description' => 'Solide, urbain, grande variété de graisses.',
            'google_family' => 'Montserrat:wght@400;500;600;700;800',
            'preview_text' => 'Tendances urbaines 2026'
        ],
        'Lora' => [
            'name' => 'Lora',
            'family' => "'Lora', Georgia, serif",
            'category' => 'Serif Littéraire',
            'description' => 'Chaud, éditorial, très agréable pour la lecture de descriptions.',
            'google_family' => 'Lora:ital,wght@0,400;0,500;0,600;1,400',
            'preview_text' => 'Une histoire d\'authenticité et de passion'
        ]
    ];

    /**
     * Retourne la bibliothèque de polices disponibles avec métadonnées et aperçu
     */
    public function getFontLibrary(): array
    {
        return self::FONT_LIBRARY;
    }

    /**
     * Configuration typographique par défaut pour chaque thème (Exigence 4.1 & 4.2)
     */
    public function getDefaultTypography(string $themeId): array
    {
        $defaults = [
            'fashion' => [
                'font_titles' => 'Space Grotesk',
                'font_subtitles' => 'Space Grotesk',
                'font_body' => 'Inter',
                'font_buttons' => 'Inter',
                'font_accents' => 'Space Grotesk',
                'size_titles' => 'scale-normal', // scale-compact, scale-normal, scale-large
                'size_subtitles' => 'scale-normal',
                'size_body' => 'scale-normal',
                'weight_titles' => 'font-bold', // font-normal, font-medium, font-semibold, font-bold, font-black
                'weight_body' => 'font-normal', // font-normal, font-medium, font-semibold
                'style_titles' => 'normal', // normal, uppercase, italic
            ],
            'bello' => [
                'font_titles' => 'Space Grotesk',
                'font_subtitles' => 'Space Grotesk',
                'font_body' => 'Inter',
                'font_buttons' => 'Inter',
                'font_accents' => 'Space Grotesk',
                'size_titles' => 'scale-normal',
                'size_subtitles' => 'scale-normal',
                'size_body' => 'scale-normal',
                'weight_titles' => 'font-bold',
                'weight_body' => 'font-normal',
                'style_titles' => 'normal',
            ],
            'luxe' => [
                'font_titles' => 'Space Grotesk',
                'font_subtitles' => 'Space Grotesk',
                'font_body' => 'Inter',
                'font_buttons' => 'Space Grotesk',
                'font_accents' => 'Space Grotesk',
                'size_titles' => 'scale-large',
                'size_subtitles' => 'scale-normal',
                'size_body' => 'scale-normal',
                'weight_titles' => 'font-black',
                'weight_body' => 'font-normal',
                'style_titles' => 'uppercase',
            ],
            'naya' => [
                'font_titles' => 'Space Grotesk',
                'font_subtitles' => 'Space Grotesk',
                'font_body' => 'Inter',
                'font_buttons' => 'Inter',
                'font_accents' => 'Space Grotesk',
                'size_titles' => 'scale-normal',
                'size_subtitles' => 'scale-normal',
                'size_body' => 'scale-normal',
                'weight_titles' => 'font-bold',
                'weight_body' => 'font-normal',
                'style_titles' => 'normal',
            ],
            'shop' => [
                'font_titles' => 'Inter',
                'font_subtitles' => 'Inter',
                'font_body' => 'Inter',
                'font_buttons' => 'Inter',
                'font_accents' => 'Inter',
                'size_titles' => 'scale-normal',
                'size_subtitles' => 'scale-normal',
                'size_body' => 'scale-normal',
                'weight_titles' => 'font-bold',
                'weight_body' => 'font-normal',
                'style_titles' => 'normal',
            ],
        ];

        return $defaults[$themeId] ?? $defaults[self::DEFAULT_THEME];
    }

    /**
     * Récupère la typographie personnalisée sauvegardée pour un thème avec fallback
     */
    public function getThemeTypography(string $themeId): array
    {
        $default = $this->getDefaultTypography($themeId);

        $stmt = $this->pdo->prepare("SELECT setting_value FROM shop_settings WHERE setting_key = :k LIMIT 1");
        $stmt->execute(['k' => 'theme_typography_' . $themeId]);
        $val = $stmt->fetchColumn();

        if ($val && is_string($val)) {
            $decoded = json_decode($val, true);
            if (is_array($decoded)) {
                return array_merge($default, $decoded);
            }
        }

        return $default;
    }

    /**
     * Valide et sauvegarde la personnalisation des polices d'écriture pour un thème (Module 4)
     */
    public function saveThemeTypography(string $themeId, array $data): bool
    {
        if (!in_array($themeId, self::ALLOWED_THEMES, true)) {
            throw new InvalidArgumentException("Thème '{$themeId}' non autorisé.");
        }

        $default = $this->getDefaultTypography($themeId);
        $clean = [];

        $validFonts = array_keys(self::FONT_LIBRARY);

        // Validation des polices (Whitelisting strict)
        $fontKeys = ['font_titles', 'font_subtitles', 'font_body', 'font_buttons', 'font_accents'];
        foreach ($fontKeys as $fk) {
            $val = $data[$fk] ?? '';
            $clean[$fk] = in_array($val, $validFonts, true) ? $val : $default[$fk];
        }

        // Validation des échelles de taille
        $validScales = ['scale-compact', 'scale-normal', 'scale-large'];
        $clean['size_titles'] = in_array($data['size_titles'] ?? '', $validScales, true)
            ? $data['size_titles']
            : $default['size_titles'];
        $clean['size_subtitles'] = in_array($data['size_subtitles'] ?? '', $validScales, true)
            ? $data['size_subtitles']
            : $default['size_subtitles'];
        $clean['size_body'] = in_array($data['size_body'] ?? '', $validScales, true)
            ? $data['size_body']
            : $default['size_body'];

        // Validation des graisses (Épaisseur des textes et titres)
        $validWeightsTitles = ['font-normal', 'font-medium', 'font-semibold', 'font-bold', 'font-black'];
        $clean['weight_titles'] = in_array($data['weight_titles'] ?? '', $validWeightsTitles, true)
            ? $data['weight_titles']
            : $default['weight_titles'];

        $validWeightsBody = ['font-normal', 'font-medium', 'font-semibold'];
        $clean['weight_body'] = in_array($data['weight_body'] ?? '', $validWeightsBody, true)
            ? $data['weight_body']
            : $default['weight_body'];

        // Validation du style (Normal, Majuscules, Italique)
        $validStyles = ['normal', 'uppercase', 'italic'];
        $clean['style_titles'] = in_array($data['style_titles'] ?? '', $validStyles, true)
            ? $data['style_titles']
            : $default['style_titles'];

        $this->saveSetting('theme_typography_' . $themeId, json_encode($clean, JSON_UNESCAPED_SLASHES));
        return true;
    }

    /**
     * Réinitialise les polices d'écriture d'un thème aux valeurs d'origine (Exigence 4.2)
     */
    public function resetThemeTypography(string $themeId): bool
    {
        if (!in_array($themeId, self::ALLOWED_THEMES, true)) {
            throw new InvalidArgumentException("Thème '{$themeId}' non autorisé.");
        }

        try {
            $stmt = $this->pdo->prepare("DELETE FROM shop_settings WHERE setting_key = :k");
            $stmt->execute(['k' => 'theme_typography_' . $themeId]);
        } catch (\Exception $e) {
            $this->saveSetting('theme_typography_' . $themeId, json_encode($this->getDefaultTypography($themeId)));
        }

        return true;
    }

    /**
     * Génère l'URL d'importation Google Fonts pour les polices actives
     */
    public function getGoogleFontsUrl(array $typo): string
    {
        $fontsNeeded = array_unique([
            $typo['font_titles'] ?? 'Space Grotesk',
            $typo['font_subtitles'] ?? 'Space Grotesk',
            $typo['font_body'] ?? 'Inter',
            $typo['font_buttons'] ?? 'Inter',
            $typo['font_accents'] ?? 'Space Grotesk',
        ]);

        $families = [];
        foreach ($fontsNeeded as $f) {
            if (isset(self::FONT_LIBRARY[$f]['google_family'])) {
                $families[] = 'family=' . self::FONT_LIBRARY[$f]['google_family'];
            }
        }

        if (empty($families)) {
            return "https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;700&display=swap";
        }

        return "https://fonts.googleapis.com/css2?" . implode('&', $families) . "&display=swap";
    }

    /**
     * Génère la feuille de style CSS injectée dynamiquement selon la personnalisation des couleurs ET des polices
     */
    public function generateCssVariables(array $cust, ?array $typo = null): string
    {
        // Conversion de radius en pixels effectifs
        $radiusMap = [
            'rounded-none' => '0px',
            'rounded-md' => '6px',
            'rounded-lg' => '8px',
            'rounded-xl' => '12px',
            'rounded-2xl' => '16px',
            'rounded-3xl' => '24px',
            'rounded-full' => '9999px',
        ];

        $btnRadius = $radiusMap[$cust['btn_radius'] ?? 'rounded-xl'] ?? '12px';
        $cardRadius = $radiusMap[$cust['card_radius'] ?? 'rounded-2xl'] ?? '16px';

        $cardSpacing = match($cust['card_spacing'] ?? 'normal') {
            'compact' => '0.75rem',
            'spacious' => '1.5rem',
            default => '1rem'
        };

        // Typographie (Module 4)
        $typo = $typo ?? $this->getDefaultTypography(self::DEFAULT_THEME);

        $fontTitles = self::FONT_LIBRARY[$typo['font_titles'] ?? 'Space Grotesk']['family'] ?? "'Space Grotesk', sans-serif";
        $fontSubtitles = self::FONT_LIBRARY[$typo['font_subtitles'] ?? 'Space Grotesk']['family'] ?? "'Space Grotesk', sans-serif";
        $fontBody = self::FONT_LIBRARY[$typo['font_body'] ?? 'Inter']['family'] ?? "'Inter', sans-serif";
        $fontButtons = self::FONT_LIBRARY[$typo['font_buttons'] ?? 'Inter']['family'] ?? "'Inter', sans-serif";
        $fontAccents = self::FONT_LIBRARY[$typo['font_accents'] ?? 'Space Grotesk']['family'] ?? "'Space Grotesk', sans-serif";

        // Échelles de taille
        $titleSizeRem = match($typo['size_titles'] ?? 'scale-normal') {
            'scale-compact' => '0.9',
            'scale-large' => '1.15',
            default => '1.0'
        };
        $subtitleSizeRem = match($typo['size_subtitles'] ?? 'scale-normal') {
            'scale-compact' => '0.9',
            'scale-large' => '1.15',
            default => '1.0'
        };
        $bodySizeRem = match($typo['size_body'] ?? 'scale-normal') {
            'scale-compact' => '0.9',
            'scale-large' => '1.1',
            default => '1.0'
        };

        // Graisse & Style
        $weightTitles = match($typo['weight_titles'] ?? 'font-bold') {
            'font-normal' => '400',
            'font-medium' => '500',
            'font-semibold' => '600',
            'font-black' => '900',
            default => '700'
        };
        $weightBody = match($typo['weight_body'] ?? 'font-normal') {
            'font-medium' => '500',
            'font-semibold' => '600',
            default => '400'
        };
        $styleTitles = match($typo['style_titles'] ?? 'normal') {
            'uppercase' => 'uppercase',
            'italic' => 'italic',
            default => 'none'
        };
        $transformTitles = ($styleTitles === 'uppercase') ? 'uppercase' : 'none';
        $fontStyleTitles = ($styleTitles === 'italic') ? 'italic' : 'normal';

        $primaryColor = htmlspecialchars($cust['primary_color'] ?? '#8d4b00');
        $secondaryColor = htmlspecialchars($cust['secondary_color'] ?? '#565e74');
        $accentColor = htmlspecialchars($cust['accent_color'] ?? '#b15f00');
        $bgPrimary = htmlspecialchars($cust['bg_primary'] ?? '#F8FAFC');
        $bgSecondary = htmlspecialchars($cust['bg_secondary'] ?? '#fff8f5');
        $surfaceColor = htmlspecialchars($cust['surface_color'] ?? '#ffffff');
        $borderColor = htmlspecialchars($cust['border_color'] ?? '#E2E8F0');
        $textColor = htmlspecialchars($cust['text_color'] ?? '#231a13');
        $titleColor = htmlspecialchars($cust['title_color'] ?? '#231a13');
        $linkColor = htmlspecialchars($cust['link_color'] ?? '#8d4b00');
        $btnColor = htmlspecialchars($cust['btn_color'] ?? '#8d4b00');
        $btnHoverColor = htmlspecialchars($cust['btn_hover_color'] ?? '#703c00');
        $priceColor = htmlspecialchars($cust['price_color'] ?? '#8d4b00');
        $promoColor = htmlspecialchars($cust['promo_color'] ?? '#ba1a1a');
        $badgeColor = htmlspecialchars($cust['badge_color'] ?? '#8d4b00');
        $navColor = htmlspecialchars($cust['nav_color'] ?? '#231a13');

        $btnPrimaryBg = htmlspecialchars($cust['btn_primary_bg'] ?? '#8d4b00');
        $btnSecondaryBg = htmlspecialchars($cust['btn_secondary_bg'] ?? '#565e74');
        $btnText = htmlspecialchars($cust['btn_text_color'] ?? '#ffffff');
        $btnHoverBg = htmlspecialchars($cust['btn_hover_bg'] ?? '#703c00');

        $cardBg = htmlspecialchars($cust['card_bg'] ?? '#ffffff');
        $cardBorder = htmlspecialchars($cust['card_border'] ?? '#E2E8F0');

        $css = "
        :root {
            /* Couleurs */
            --color-primary: {$primaryColor};
            --color-secondary: {$secondaryColor};
            --color-accent: {$accentColor};
            --color-bg-primary: {$bgPrimary};
            --color-bg-secondary: {$bgSecondary};
            --color-surface: {$surfaceColor};
            --color-border: {$borderColor};
            --color-text: {$textColor};
            --color-title: {$titleColor};
            --color-link: {$linkColor};
            --color-btn: {$btnColor};
            --color-btn-hover: {$btnHoverColor};
            --color-price: {$priceColor};
            --color-promo: {$promoColor};
            --color-badge: {$badgeColor};
            --color-nav: {$navColor};

            --btn-primary-bg: {$btnPrimaryBg};
            --btn-secondary-bg: {$btnSecondaryBg};
            --btn-text: {$btnText};
            --btn-hover-bg: {$btnHoverBg};
            --btn-radius: {$btnRadius};

            --card-bg: {$cardBg};
            --card-border: {$cardBorder};
            --card-radius: {$cardRadius};
            --card-spacing: {$cardSpacing};

            /* Typographie (Exigence 4.1 & 4.3) */
            --font-titles: {$fontTitles};
            --font-subtitles: {$fontSubtitles};
            --font-body: {$fontBody};
            --font-buttons: {$fontButtons};
            --font-accents: {$fontAccents};

            --scale-titles: {$titleSizeRem};
            --scale-subtitles: {$subtitleSizeRem};
            --scale-body: {$bodySizeRem};

            --weight-titles: {$weightTitles};
            --weight-body: {$weightBody};
            --transform-titles: {$transformTitles};
            --style-titles: {$fontStyleTitles};
        }

        body {
            background-color: var(--color-bg-primary) !important;
            color: var(--color-text) !important;
            font-family: var(--font-body) !important;
            font-weight: var(--weight-body) !important;
            font-size: calc(1rem * var(--scale-body)) !important;
        }

        /* 4.3 Titres et sous-titres */
        h1, h2, .font-headline {
            color: var(--color-title) !important;
            font-family: var(--font-titles) !important;
            font-weight: var(--weight-titles) !important;
            text-transform: var(--transform-titles) !important;
            font-style: var(--style-titles) !important;
            font-size: calc(1em * var(--scale-titles)) !important;
        }

        h3, h4, h5, h6, .font-subheadline {
            color: var(--color-title) !important;
            font-family: var(--font-subtitles) !important;
            font-weight: var(--weight-titles) !important;
            font-size: calc(1em * var(--scale-subtitles)) !important;
        }

        p, .font-body, .prose, .description-text {
            font-family: var(--font-body) !important;
            font-size: calc(1rem * var(--scale-body)) !important;
            line-height: 1.6;
        }

        /* 4.3 Boutons */
        .btn-theme, button[type='submit'].btn-theme, a.btn-theme, .btn-secondary-theme {
            font-family: var(--font-buttons) !important;
            border-radius: var(--btn-radius) !important;
            transition: all 0.2s ease !important;
        }

        .btn-theme, button[type='submit'].btn-theme, a.btn-theme {
            background-color: var(--btn-primary-bg) !important;
            color: var(--btn-text) !important;
        }

        .btn-theme:hover, button[type='submit'].btn-theme:hover, a.btn-theme:hover {
            background-color: var(--btn-hover-bg) !important;
        }

        .btn-secondary-theme {
            background-color: var(--btn-secondary-bg) !important;
            color: var(--btn-text) !important;
        }

        /* 4.3 Cartes produits & Prix */
        .card-theme {
            background-color: var(--card-bg) !important;
            border: 1px solid var(--card-border) !important;
            border-radius: var(--card-radius) !important;
        }

        .card-theme .card-content-spacing {
            padding: var(--card-spacing) !important;
        }

        .price-theme {
            color: var(--color-price) !important;
            font-family: var(--font-accents) !important;
            font-weight: 700 !important;
        }

        .badge-theme, .accent-theme {
            background-color: var(--color-badge) !important;
            color: #ffffff !important;
            font-family: var(--font-accents) !important;
        }

        .promo-theme {
            background-color: var(--color-promo) !important;
            color: #ffffff !important;
            font-family: var(--font-accents) !important;
        }

        /* 4.3 Navigation & Formulaires */
        header.bg-surface\/90, .nav-theme, nav a {
            color: var(--color-nav) !important;
            font-family: var(--font-subtitles) !important;
        }

        input, select, textarea {
            font-family: var(--font-body) !important;
        }
        ";

        return $css;
    }

    private function isValidHex(string $color): bool
    {
        return (bool) preg_match('/^#(?:[0-9a-fA-F]{3}){1,2}$/', trim($color));
    }

    private function saveSetting(string $key, string $value): void
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO shop_settings (setting_key, setting_value) VALUES (:k, :v)
                                          ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), updated_at = CURRENT_TIMESTAMP");
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
