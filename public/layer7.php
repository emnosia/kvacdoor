<?php

opcache_reset();

$title = "HUB Layer 7";

$protocols = [
    "layer7" => [
        "HTTPS-RAW",
        "HTTPS-BROWSER",
        "HTTP-MIX-BYPASS"
    ],
    "cloudflare" => [
        "CF-BYPASS",
        "CF-UAM-BYPASS",
        "CF-PRO-BYPASS"
    ],
    "nuke" => [
        'HTTPS-NUKE'
    ]
];

require_once '../includes/autoloads.php';
