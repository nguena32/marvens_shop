<?php
$dir = __DIR__ . '/../public/assets/icons';
if (!is_dir($dir)) {
    mkdir($dir, 0755, true);
}

function makeIcon($path, $size) {
    if (extension_loaded('gd')) {
        $im = imagecreatetruecolor($size, $size);
        $bg = imagecolorallocate($im, 79, 70, 229); // #4f46e5 Indigo
        imagefilledrectangle($im, 0, 0, $size, $size, $bg);
        $white = imagecolorallocate($im, 255, 255, 255);
        imagestring($im, 5, (int)($size/2 - 10), (int)($size/2 - 10), 'MS', $white);
        imagepng($im, $path);
        imagedestroy($im);
    } else {
        file_put_contents($path, base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg=='));
    }
}

makeIcon($dir . '/icon-192x192.png', 192);
makeIcon($dir . '/icon-512x512.png', 512);
echo "Icons successfully generated\n";
