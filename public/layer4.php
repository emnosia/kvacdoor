<?php

opcache_reset();

$title = "HUB Layer 4";

$protocols = [
    "layer4" => [
        "DNS-AMP",
        "MIX-AMP",
        "TCP-SYN",
        "TCP-SYN-ACK",
        "UDP-PPS",
        "UDP-RAW",
        "HANDSHAKE"
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
    ],
    "nuke" => [
        "DNS-NUKE",
        "SYN-NUKE",
        "UDP-NUKE"
    ]
];

// $protocols = [
//     "layer4" => [
//         "DNS-AMP" => ['name' => "DNS"],
//         "MIX-AMP" => ['name' => "MIX"],
//         "TCP-SYN" => ['name' => "SYN"],
//         "TCP-SYN-ACK" => ['name' => "SYN ACK"],
//         "UDP-PPS" => ['name' => "UDP BOMB"],
//         "UDP-RAW" => ['name' => "UDP FLOOD"],
//         "HANDSHAKE" => ['name' => "HANDSHAKE"]
//     ],
//     "gaming" => [
//         "MINECRAFT-MCPE" => ['name' => "MINECRAFT"],
//         "FIVEM-BYPASS" => ['name' => "FIVEM"],
//         //"SAMP" => ['name' => "GTA SA"],
//         "VALVE-UDP" => ['name' => "GARRY'S MOD"],
//         "RUST-UDP" => ['name' => "RUST"]
//     ],
//     "hosting" => [
//         "OVH-UDP" => ['name' => "OVH UDP"],
//         "OVH-HANDSHAKE" => ['name' => "OVH HANDSHAKE"],
//         "OVH-GAMING" => ['name' => "OVH GAME"],
//         "HETZNER" => ['name' => "HETZNER"],
//     ],
//     "nuke" => [
//         "DNS-NUKE" => ['name' => "DNS (200 Gbps)"],
//         "SYN-NUKE" => ['name' => "SYN (500 Gbps)"],
//         "UDP-NUKE" => ['name' => "UDP (500 Gbps)"]
//     ]
// ];

require_once '../includes/autoloads.php';
