<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title d-inline-block">All Servers</h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Owner</th>
                                <th scope="col">Hostname</th>
                                <th scope="col">IP</th>
                                <th scope="col">Gamemode</th>
                                <th scope="col">Slots</th>
                                <th scope="col">API</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (Server::getAll() as $server) : ?>
                                <?php if ($server['last_update'] + 130 < time()) continue; ?>
                                <?php $owner_name = Server::GetServerOwner($server['owner']); ?>
                                <?php if ($server['owner'] == 0) {
                                    $owner_name = "ADMINISTRATEUR";
                                } ?>
                                <?php $nb_ply = $nb_ply + $server['used_slots']; ?>
                                <?php //$versions[$server['api_version']]++;  
                                ?>
                                <tr>
                                    <th scope="row"><?= $serverid++ ?></th>
                                    <td><?= $owner_name; ?></td>
                                    <td>
                                        <?php

                                        if (strpos($server['backdoors'], "store") !== false) {
                                            echo '<span class="text-primary">' . htmlentities(substr($server['hostname'], 0, 70)) . '</span>';
                                        } else {
                                            echo htmlentities(substr($server['hostname'], 0, 70));
                                        }

                                        ?>
                                    </td>
                                    <td><?= htmlentities($server['ip']) ?></td>
                                    <td><?= substr($server['gamemode'], 0, 10) ?></td>
                                    <td><?= $server['used_slots'] ?>/<?= $server['max_slots'] ?></td>
                                    <td><?= htmlentities($server['api_version']) ?></td>
                                    <td>
                                        <a href="servers/<?= $server['id'] ?>" class="btn btn-primary btn-sm">Accedez</a>
                                        <button class="btn btn-info btn-sm" onclick="donateMenu(<?= $server['id'] ?>)">Donate</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <th scope="row"></th>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Total :</td>
                                <td><?= $nb_ply ?></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="give-server" tabindex="-1" role="dialog" aria-labelledby="give-serverLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Give Server</h5>
                <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <p>Nom: <span id="info_serverhostname">Chargement...</span></p>
                    <p>IP: <span id="info_serverip">Chargement...</span></p>
                    <select class="form-control" id="targetID">
                        <?php foreach (User::getAll() as $member) : ?>
                            <option value="<?= $member['id'] ?>"><?= $member['id'] ?> | <?= htmlentities($member['username']) ?></option>
                        <?php endforeach ?>
                    </select>
                    <input type="hidden" name="server_id" value="">
                    <input type="hidden" name="wadixexec" value="<?= CSRF::CreateToken() ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect waves-light" id="ajax-alert" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="donate()">Give</button>
            </div>
        </div>
    </div>
</div>

<?php
// Calcul du total des valeurs
// $total = array_sum($versions);

// // Calcul du pourcentage pour chaque version d'API
// foreach ($versions as $version => $count) {
//     $percentage = ($count / $total) * 100;
//     echo "Version d'API $version : ".round($percentage) . "%<br>";
// }

?>



<script>
    var giveServID = 0;
    var giveUserID = 0;

    function donateMenu(id) {
        $.ajax({
            url: "../ajax/get-server-content.php?id=" + id
        }).done(function(data) {
            $("#give-server").modal('show');
            $("#info_serverhostname").text(' ' + data[1]);
            $("#info_serverip").text(' ' + data[2]);
            giveServID = data[0];
        });
    }

    function donate() {
        giveUserID = $("#targetID").val();

        $.ajax({
            url: "../ajax/give-server.php?target=" + giveUserID + "&server=" + giveServID
        }).done(function() {
            $("#give-server").modal('hide');
        });
    }
</script>