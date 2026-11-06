<?php
$lines = file('Docs/CAHIER_DES_CHARGES_FONCTIONNEL_TECHNIQUE.md');
foreach ($lines as $i => $l) {
    if (preg_match('/^#+\s+/i', $l)) {
        echo ($i + 1) . ': ' . trim($l) . "\n";
    }
}
