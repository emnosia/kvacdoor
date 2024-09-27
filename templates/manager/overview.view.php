<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18"><i class="fa fa-home"></i> Overview</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/overview">KVacDoor</a></li>
                    <li class="breadcrumb-item active">Overview</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="card-statistics">
                    <i class="fa fa-users text-primary"></i>
                    <h2 class="text-primary"><?= number_format(User::count()); ?></h2>
                    <p class="text">ACCOUNTS</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="card-statistics">
                    <i class="fa fa-server text-primary"></i>
                    <h2 class="text-primary"><?= number_format(Server::countFromUser()); ?></h2>
                    <p class="text">SERVERS</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="card-statistics">
                    <i class="fa fa-street-view text-primary"></i>
                    <h2 class="text-primary"><?= number_format(floor(Player::count())); ?></h2>
                    <p class="text">PLAYERS</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="card-statistics">
                    <i class="fa fa-code text-primary"></i>
                    <h2 class="text-primary"><?= number_format(Payload::countFromUser($AUTHUSER['id'])); ?></h2>
                    <p class="text">PAYLOADS</p>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title d-inline-block mb-3"><i class="fa fa-server" aria-hidden="true"></i> Your Progress</h4>
                <canvas id="stat-server" height="20%" width="100%"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><i class="fa fa-users"></i> Latest Members</h4>
                <div class="table-responsive">
                    <table class="table table-centered table-nowrap">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Registered Since</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (User::getAllRecent(7) as $member) : ?>
                                <tr>
                                    <td class="table-user">
                                        <img src="<?= $member['avatar'] ?>?size=32" alt="<?= $member['username'] ?>" class="mr-2 avatar-xs rounded-circle" onerror="errorAvatar(this)">
                                        <a href="profile/<?= $member['id'] ?>" class="text-body font-weight-semibold"><?= $member['username'] ?></a>
                                    </td>
                                    <td><?= $member['created_at'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><i class="fa fa-flag"></i> Best Members Ever</h4>
                <div class="table-responsive">
                    <table class="table table-centered table-nowrap">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Numbers of Servers</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($leaders as $data) : ?>
                                <tr>
                                    <td class="table-user">
                                        <img src="<?= htmlentities($data['avatar']) ?>?size=32" alt="<?= htmlentities($data['username']) ?>" class="mr-2 avatar-xs rounded-circle" onerror="errorAvatar(this)">
                                        <a href="profile/<?= $data['id'] ?>" class="text-body font-weight-semibold"><?= htmlentities($data['username']) ?></a>
                                    </td>
                                    <td><?= number_format($data['servers_nbr']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div> <!-- END ROWS -->

<?php $data = Stat::SelectLastData($AUTHUSER['id'], 14); ?>
<script>
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


<div class="modal fade" id="ads" tabindex="-1" role="dialog" aria-labelledby="adsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-users"></i> Ads</h5>
                <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-centered table-nowrap">
                    <thead>
                        <tr>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php if (isset($_SESSION['ads']) && 1 == 0) : ?>
    <!-- <canvas id="app-confetti" style="position: fixed; width: 100%; height: 100%; top: 0px; left: 0px; z-index: 1000; pointer-events: none;" width="1920" height="491"></canvas>
    <script src="https://cdn.jsdelivr.net/npm/js-confetti@latest/dist/js-confetti.browser.js"></script> -->

    <script>
        // const canvas = document.getElementById("app-confetti"),
        //     jsConfetti = new JSConfetti({
        //         canvas: canvas
        //     });
        // jsConfetti.addConfetti({
        //     emojis: ["⚽", "🏆", "🥇"]
        // });
    </script>
<?php endif; ?>