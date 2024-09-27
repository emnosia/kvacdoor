<?php if ($userprofile['ban']) : ?>
    <div class="alert alert-danger">
        That user is currently banned!
    </div>
<?php endif; ?>
<div class="row">
    <div class="col-lg-4 col-xl-4">
        <div class="card">
            <div class="card-body">
                <?php if ($_GET['id'] === $_SESSION['user']['id']) : ?>
                    <div class="dropdown float-right position-relative">
                        <a href="#" class="dropdown-toggle h4 text-muted" data-toggle="dropdown" aria-expanded="true">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right" x-placement="top-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-144px, -168px, 0px);">
                            <li><a href="#" class="dropdown-item" data-toggle="modal" data-target="#edit-profile">Settings</a></li>
                            <!-- <li><a href="#" onclick="report()" class="dropdown-item">Report</a></li> -->
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="d-flex align-items-start">
                    <img class="rounded-circle avatar-xl img-thumbnail" alt="<?= htmlentities($userprofile['username']) ?>" onerror="errorAvatar(this)" src="<?= htmlentities($userprofile['avatar']); ?>">
                    <div class="w-100 ml-3 pt-3">
                        <h4 class="my-0"><?= htmlentities($userprofile['username']); ?></h4>
                        <p class="text-muted mb-1">@<?= htmlentities($userprofile['username']); ?>#<?= $userprofile['discriminator']; ?></p>

                        <?php foreach ($badges as $badge) : ?>
                            <span class="mr-1"><img src="<?= $badge['icon'] ?>" style="width:19px" alt="" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?= $badge['name'] ?>"></span>
                        <?php endforeach; ?>

                    </div>
                </div>


                <div class="text-left mt-3">
                    <h4 class="font-13 text-uppercase">Description :</h4>
                    <p class="text-muted font-13 mb-3">
                        <?= htmlspecialchars($userprofile['description']) ?>
                    </p>
                    <p class="text-muted mb-2 font-13"><strong>Discord ID :</strong><span class="ml-1"><?= $userprofile['discord_id'] ?></span></p>

                    <p class="text-muted mb-2 font-13"><strong>Last Login :</strong><span class="ml-2"><?= $lastlogin ?></span></p>

                    <hr>

                    <p class="text-muted mb-2 font-13"><strong>Number of Server :</strong><span class="ml-2"><?= Server::countFromUser($_GET['id']); ?></span></p>
                    <p class="text-muted mb-2 font-13"><strong>Number of Payload :</strong><span class="ml-2"><?= Payload::countFromUser($_GET['id']); ?></span></p>

                    <?php if ($AUTHUSER['roles'] >= 2 && $_SESSION['admin_mode'] == 1) : ?>

                        <?php if ($userprofile['user_agent'] !== null) : ?>
                            <p class="text-muted mb-2 font-13"><strong>OS :</strong><span class="ml-2"><?= getOS() ?></span></p>
                            <p class="text-muted mb-2 font-13"><strong>Browser :</strong><span class="ml-2"><?= getBrowser() ?></span></p>
                        <?php endif; ?>

                        <?php if ($userprofile['email'] !== null) : ?>
                            <p class="text-muted mb-2 font-13"><strong>Email :</strong><span class="ml-2"><?= $userprofile['email'] ?></span></p>
                        <?php endif; ?>

                        <p class="text-muted mb-2 font-13"><strong>IP :</strong><span class="ml-2"><?= $userprofile['ip'] ?> | <img src="/assets/img/flags/<?= strtoupper($info_ip->countryCode) ?>/flat/64.png" width="20"></span></p>

                        <?php if ($userprofile['ip'] != "0.0.0.0") : ?>
                            <p class="text-muted mb-2 font-13"><strong>City :</strong><span class="ml-2"><?= $info_ip->city . " - " . $info_ip->regionName ?></span></p>

                            <p class="text-muted mb-2 font-13"><strong>Telecom :</strong><span class="ml-2"><?= $info_ip->as ?></span></p>
                        <?php endif; ?>

                        <p class="text-muted mb-2 font-13"><strong>KEY :</strong><span class="ml-2"><?= $userprofile['infectkey'] ?></span></p>

                        <p class="text-muted mb-2 font-13"><strong>Created At :</strong><span class="ml-2"><?= $userprofile['created_at'] ?></span></p>

                    <?php endif; // ENDIF (GRADE == 3) 
                    ?>
                </div>

                <?php if ($AUTHUSER['roles'] == 3 && $userprofile['id'] != $AUTHUSER['id'] && $userprofile['roles'] != 3) : ?>
                    <ul class="social-list list-inline mt-3 mb-0 text-center">
                        <li class="list-inline-item">
                            <a href="#" id="free" onclick="free()" class="btn btn-success btn-sm <?= ($userprofile['roles'] == 0) ? 'disabled' : '' ?>">Mettre Free</a>
                        </li>

                        <li class="list-inline-item">
                            <a href="#" id="premium" onclick="premium()" class="btn btn-warning btn-sm <?= ($userprofile['roles'] == 1) ? 'disabled' : '' ?>">Mettre Premium</a>
                        </li>
                        <li class="list-inline-item" id="ban-btn">
                            <?php if ($userprofile['ban'] == 0) : ?>
                                <a href="#" onclick="ban()" class="btn btn-danger btn-sm">Bannir</a>
                            <?php else : ?>
                                <a href="#" onclick="unban()" class="btn btn-danger btn-sm">Débannir</a>
                            <?php endif; ?>
                        </li>
                    </ul>
                <?php endif; ?>
            </div> <!-- end card-box -->
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title d-inline-block"><?= htmlentities($userprofile['username']) ?> Progress</h4>
                <canvas id="stat-server" height="50%" width="100%"></canvas>
            </div>
        </div>

    </div>

    <div class="col-lg-8 col-xl-8">

        <div class="card">
            <div class="card-body">
                <textarea placeholder="what's on your mind?" id="addcomment" name="comment" class="form-control"></textarea>
                <br>
                <button type="submit" onclick="add_comment();" class="btn btn-primary float-right">Publish</button>
            </div>
        </div>

        <span id="comments_pnl">

            Loading...

        </span>

    </div>

</div>

<script>
    function report() {
        console.log('reported')

        Swal.fire({
            title: "Reported!",
            text: "this user has been reported ",
            type: "success"
        });
    }

    function comments_tbl() {
        $.ajax({
            "method": "GET",
            "url": "../ajax/get-profile-comments.php?id=<?= $_GET['id'] ?>",
            "success": (data) => {
                $('#comments_pnl').html(data);
            }
        });
    }

    comments_tbl();

    setInterval(
        function() {
            comments_tbl();
        }, 40000);

    function add_comment() {
        var content = $('#addcomment').val();
        $.ajax({
            "method": "GET",
            "url": "../ajax/profile-add-comment.php?toUser=<?= $_GET['id'] ?>&content=" + content,
            "success": (data) => {
                $('#addcomment').val('');
                comments_tbl();
            }
        });
    }

    <?php

    $data = Stat::SelectLastData((int)$_GET['id'], 7);

    ?>

    $(function() {
        "use strict";
        const chart = document.getElementById("stat-server");
        new Chart(
            chart, {
                "type": "line",
                "data": {
                    "labels": [
                        <?php foreach ($data as $stat) : ?> "<?= $stat['day']; ?>",
                        <?php endforeach; ?>
                    ],
                    "datasets": [{
                        "label": "Servers",
                        "data": [
                            <?php foreach ($data as $stat) : ?> "<?= $stat['nbr']; ?>",
                            <?php endforeach; ?>
                        ],
                        "fill": true,
                        "borderColor": "#20B799",
                        "backgroundColor": "#0d5c4c",
                        // "backgroundColor": "#2a57b1",
                        // "borderColor": "#346ee0",
                        "lineTension": 0
                    }]
                },
                "options": {
                    "legend": {
                        "display": false
                    },
                    "scales": {
                        "yAxes": [{
                            "ticks": {
                                "beginAtZero": false
                            }
                        }]
                    }
                }
            });
    });
</script>

<?php if ($AUTHUSER['roles'] == 3) : ?>
    <script>
        function premium() {
            Swal.fire({
                title: "Étes Vous Sur?",
                text: "Cette utilisateur sera Premium!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Oui, je suis sur!",
                cancelButtonText: "Enfaite non",
                confirmButtonClass: "btn btn-success mt-2",
                cancelButtonClass: "btn btn-danger ml-2 mt-2",
                buttonsStyling: !1
            }).then(function(t) {
                if (t.value === true) {
                    $.ajax({
                        "method": "POST",
                        "data": "rank=1&userid=<?= $_GET['id'] ?>",
                        "url": "../ajax/admin_change_rank.php",
                        "success": (data) => {
                            Swal.fire({
                                title: "Succès!",
                                text: "Le grade Premium à été appliquer.",
                                type: "success"
                            });
                            //setTimeout(() => {
                            //    location.reload();
                            //}, 1000);
                            $('#premium').addClass("disabled");
                            $('#free').removeClass("disabled");
                        }
                    });
                }
            })
        }

        function free() {
            Swal.fire({
                title: "Étes Vous Sur?",
                text: "Cette utilisateur sera Free!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Oui, je suis sur!",
                cancelButtonText: "Enfaite non",
                confirmButtonClass: "btn btn-success mt-2",
                cancelButtonClass: "btn btn-danger ml-2 mt-2",
                buttonsStyling: !1
            }).then(function(t) {
                if (t.value === true) {
                    $.ajax({
                        "method": "POST",
                        "data": "rank=0&userid=<?= $_GET['id'] ?>",
                        "url": "../ajax/admin_change_rank.php",
                        "success": (data) => {
                            Swal.fire({
                                title: "Succès!",
                                text: "Le grade Free à été appliquer.",
                                type: "success"
                            });
                            //setTimeout(() => {
                            //    location.reload();
                            //}, 1000);
                            $('#premium').removeClass("disabled");
                            $('#free').addClass("disabled");
                        }
                    });
                }
            })
        }

        function ban() {
            Swal.fire({
                title: "Entrez la raison du bannisement",
                input: "text",
                inputAttributes: {
                    autocapitalize: "off"
                },
                showCancelButton: !0,
                confirmButtonText: "Bannir!",
                cancelButtonText: "Enfaite non",
                confirmButtonClass: "btn btn-danger mt-2",
                cancelButtonClass: "btn btn-secondary ml-2 mt-2",
                showLoaderOnConfirm: !0,
                buttonsStyling: !1,
                preConfirm: function(t) {
                    $.ajax({
                        "method": "POST",
                        "data": "userid=<?= $_GET['id'] ?>&reason=" + t,
                        "url": "../ajax/admin_ban_user.php",
                        "success": (data) => {
                            Swal.fire({
                                title: "Succès!",
                                text: "Banni avec succèes.",
                                type: "success"
                            });
                            $('#ban-btn').html('<a href="#" onclick="unban()" class="btn btn-danger btn-sm">Débannir</a>');
                        }
                    });
                }
            })
        }

        function unban() {
            Swal.fire({
                title: "Étes Vous Sur?",
                text: "Cette utilisateur sera debanni!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Oui, je suis sur!",
                cancelButtonText: "Enfaite non",
                confirmButtonClass: "btn btn-success mt-2",
                cancelButtonClass: "btn btn-danger ml-2 mt-2",
                buttonsStyling: !1
            }).then(function(t) {
                if (t.value === true) {
                    $.ajax({
                        "method": "POST",
                        "data": "userid=<?= $_GET['id'] ?>",
                        "url": "../ajax/admin_unban_user.php",
                        "success": (data) => {
                            Swal.fire({
                                title: "Succès!",
                                text: "L'utilisateur a été deban.",
                                type: "success"
                            });
                            $('#ban-btn').html('<a href="#" onclick="ban()" class="btn btn-danger btn-sm">Bannir</a>');
                        }
                    });
                }
            })
        }
    </script>
<?php endif ?>

<?php if ($_GET['id'] === $_SESSION['user']['id']) : ?>

    <!-- EDIT PROFILE MODAL -->

    <div class="modal fade" id="edit-profile" tabindex="-1" role="dialog" aria-labelledby="edit-profileLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editer mon profil</h5>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="row" style="display:none;">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="firstname">Nom d'utilisateur</label>
                                    <input type="text" class="form-control" name="username" value="<?= htmlentities($AUTHUSER['username']) ?>" placeholder="Enter username">
                                </div>
                            </div>
                        </div>

                        <div class="row" style="display:none;">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="useremail">Avatar</label>
                                    <input type="text" class="form-control" name="avatar" value="<?= $AUTHUSER['avatar'] ?>" placeholder="https://">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="userbio">Description</label>
                                    <input type="text" class="form-control" name="description" maxlength="80" placeholder="Je suis au chomage" value="<?= $AUTHUSER['description'] ?>" placeholder="https://">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="userbio">STEAM ID</label>
                                    <input type="text" class="form-control" name="steamid" maxlength="80" placeholder="STEAM_000000000" value="<?= $AUTHUSER['steamid'] ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="edit-profile" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>