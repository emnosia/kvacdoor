<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18"><i class="fa fa-history"></i> <?= $title ?></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/overview">KVacDoor</a></li>
                    <li class="breadcrumb-item"><a href="/servers">Servers</a></li>
                    <li class="breadcrumb-item active"><?= $title ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Hostname</th>
                            <th scope="col">IP</th>
                            <th scope="col">Gamemode</th>
                            <th scope="col">Rcon</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="serverlist">
                        <?php foreach (Server::getAllOfflineFromUser($_SESSION['user']['id']) as $server): ?>
                        <?php

                            // if($server['rcon'] === "Not Found" || $server['rcon'] === ""){
                            //     continue;
                            // }

                            if(strlen($server['rcon']) >= 30)
                            {
                                $rcon = '<p class="text-danger">VERY LONG RCON!</p>';
                            } else {
                                $rcon = $server['rcon'];
                            }

                            if(strlen($server['hostname']) >= 60)
                            {
                                $hostname = substr($server['hostname'], 0, 60);
                            } else {
                                $hostname = $server['hostname'];
                            }

                        ?>
                        <tr>
                            <th scope="row"><?= $serverid++ ?></th>
                            <td><?= htmlentities($hostname) ?></td>
                            <td><?= htmlentities($server['ip']) ?></td>
                            <td><?= htmlentities($server['gamemode']) ?></td>
                            <td><?= $rcon ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm" <?= ($server['rcon'] == 'Not Found' || empty(trim($server['rcon']))) ? 'disabled=""' : '';  ?> onclick="reconnect_rcon('<?= $server['ip'] ?>','<?= $server['rcon'] ?>')">Reconnect With Rcon</button>
                                <button class="btn btn-success btn-sm" onclick="donateMenu(<?= $server['id'] ?>)">Change Owner</button>
                            </td>
                        </tr>
                        <?php endforeach ?>
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
                <h5 class="modal-title" id="exampleModalLabel">Change Owner</h5>
                <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <p>Nom: <span id="info_serverhostname">Loading...</span></p>
                    <p>IP: <span id="info_serverip">Loading...</span></p>
                    <select class="form-control" id="targetID">
                        <?php foreach (User::getAll() as $member): ?>
                        <?php if($member['id'] != $AUTHUSER['id'] && $member['ban'] == 0): ?>
                        <option value="<?= $member['id'] ?>"><?= $member['id'] ?> | <?= htmlentities($member['username']) ?></option>
                        <?php endif; ?>
                        <?php endforeach ?>
                    </select>
                    <input type="hidden" name="server_id" value="">
                    <input type="hidden" name="wadixexec" value="<?= CSRF::CreateToken() ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect waves-light" id="ajax-alert" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="donate()">Change</button>
            </div>
        </div>
    </div>
</div>

<script>
var giveServID = 0x0;
var giveUserID = 0x0;

function refresh_server() {
    $.ajax({
        'method': 'GET',
        'url': '/ajax/get_server-history.php',
        'success': _0x45c12f => {
            $('#serverlist').html(_0x45c12f);
        }
    });
}

function reconnect_rcon(ip, b) {
    address = ip.split(':');

    $.ajax({
        'method': 'GET',
        'url': '/api/rcon?ip=' + address[0] + '&port=' + address[1],
        'success': _0x5b682e => {
            if (_0x5b682e.success == true) {
                Swal.fire({
                    'title': 'Success!',
                    'text': _0x5b682e.message,
                    'type': 'success',
                    'timer': 0x3e8
                });
            } else {
                Swal.fire({
                    'type': 'error',
                    'title': 'Oops...',
                    'text': _0x5b682e.message,
                    'timer': 0xbb8
                });
            }
        }
    });
}

function donateMenu(_0x3ae375) {
    $.ajax({
        'url': '../ajax/get-server-content.php' + '?id=' + _0x3ae375
    }).done(function (_0x332583) {
        $('#give-server').modal('show');
        $('#info_serverhostname').text(' ' + _0x332583[0x1]);
        $('#info_serverip').text(' ' + _0x332583[0x2]);
        giveServID = _0x332583[0x0];
    });
}

function donate() {
    giveUserID = $('#targetID').val();
    $.ajax({
        'url': '../ajax/give-server.php?target' + '=' + giveUserID + '&server=' + giveServID
    }).done(function () {
        $('#give-server').modal('hide');
        refresh_server();
    });
}
setInterval(refresh_server, 0x7530);
</script>
