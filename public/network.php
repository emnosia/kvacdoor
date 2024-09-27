<?php

opcache_reset();

$title = "Network";

$protocols = [
    "layer3" => [
        "PROTOCOL-RANDOM"
    ],
    "layer4" => [
        "DNS-AMP",
        "MIX-AMP",
        "TCP-SYN",
        "TCP-SYN-ACK",
        "UDP-PPS",
        "UDP-RAW",
        "HANDSHAKE"
    ],
    "layer7" => [
        "HTTP-RAW",
        "HTTPS-RAW"
    ],
    "gaming" => [
        "MINECRAFT-MCPE",
        "FIVEM-BYPASS",
        "SAMP",
        "VALVE-UDP",
        "RUST-UDP"
    ],
    "hosting" => [
        "OVH-UDP",
        "OVH-HANDSHAKE",
        "OVH-GAMING",
        "HETZNER",
        "TYNAHOST"
    ]
];

require_once '../includes/autoloads.php';
