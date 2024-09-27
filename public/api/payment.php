<?php

$payload = json_decode(file_get_contents('php://input'));

// verify signature
if ($payload->event === 'order:paid') {

    require '../../app/Models/includes.php';

    $order = $payload->data->order;

    $user = User::GetUserByEmail($order->email);

    // Premium Access
    if ($order->product_id == "JV5lx9X") {
        User::setRole($user['id'], 1);
    }

    // Steam Resolver
    if ($order->product_id == "azrSwuc") {
        User::UpdateUserxray($user['id'], 1);
    }
}