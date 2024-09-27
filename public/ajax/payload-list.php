<?php
session_start();
if(!isset($_SESSION['user']['id'])) {
	die();
}
require_once '../../app/Models/includes.php';
if (!User::isAuthentified() || !CSRF::isAjaxRequest())
{
    die("Bad request");
}

$payloads = array_reverse(Payload::GetUserPayloads());

?>

<?php foreach ($payloads as $payload): ?>
<?php

$date = new DateTime($payload["created_at"]);

if($payload['clientside']){
    $clientside = '<span class="badge badge-warning">Clientside</span>';
} else {
    $clientside = '<span class="badge badge-info">Serverside</span>';
}

?>
<tr>
    <th scope="row"><?= $payload['id'] ?></th>
    <td><?= htmlentities($payload['name']) ?></td>
    <td><code><?= htmlentities(substr($payload['content'], 0, 60)) ?></code></td>
    <td><?= $clientside ?></td>
    <td><?= CSRF::TimeAgo($date->getTimestamp()) ?></td>
    <td>
        <button class="btn btn-info" onclick="edit_payload_pnl(<?= $payload['id']; ?>)"><i class="fas fa-edit"></i> Edit</button>
        <button class="btn btn-danger" onclick="deletePayload(<?= $payload['id']; ?>)"><i class="fa fa-trash"></i> Delete</button>
    </td>
</tr>
<?php endforeach ?>