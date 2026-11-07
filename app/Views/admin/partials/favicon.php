<?php
/**
 * Injection automatique du favicon configuré pour l'espace d'administration
 * Source de vérité : shop_favicon_url dans shop_settings (Module 5.1)
 */
if (!isset($adminFaviconUrl)) {
    try {
        $settingsHelper = new \App\Application\Services\SettingsService();
        $shopInfo = $settingsHelper->getShopInfo();
        $adminFaviconUrl = $shopInfo['favicon_url'] ?? '';
    } catch (\Throwable $e) {
        $adminFaviconUrl = '';
    }
}
if (!empty($adminFaviconUrl)):
    $adminFaviconHref = str_starts_with($adminFaviconUrl, 'http') ? $adminFaviconUrl : '/' . ltrim($adminFaviconUrl, '/');
?>
    <link rel="icon" href="<?= htmlspecialchars($adminFaviconHref) ?>"/>
    <link rel="shortcut icon" href="<?= htmlspecialchars($adminFaviconHref) ?>"/>
    <link rel="apple-touch-icon" href="<?= htmlspecialchars($adminFaviconHref) ?>"/>
<?php endif; ?>
