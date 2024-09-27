<?php 

$webhookscontent = $_POST['message'];

$curl = curl_init("https://discord.com/api/webhooks/907631949739343882/nFAG5rFePKQrulq-4oBZZMM2BvS-xXz4CSyH9iuJnbxk7ul9H_4g9fqXD4AMV6EGkoWj");
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array('content' => $webhookscontent)));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, false);
$response = curl_exec($curl);
curl_close($curl);
