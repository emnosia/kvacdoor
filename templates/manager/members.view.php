<?php foreach ($ranks_lists as $rank_id => $rank_name) : ?>
    <div class="row">
        <div class="col-12">
            <div class="text-center">
                <i class="h3 <?= $ranks_icon[$rank_id] ?>"></i>
                <h4 class="mb-3"><?= $rank_name ?></h4>
            </div>
        </div>
    </div>

    <div class="row">

        <?php foreach (User::getAll() as $user) : ?>
            <?php if ($user['roles'] == $rank_id && $user['ban'] == 0 && $user['last_login'] > time() - (43800 * 60)) : ?>

                <?php
                $colouronline = (($user['last_login'] + 60) > time()) ? "rgb(67, 181, 129)" : "rgb(116, 127, 141)"; 


                if (($user['last_login'] + 60) > time()) {
                    $colouronline = "rgb(67, 181, 129)";
                } elseif (($user['last_login'] + 3600) > time()) {
                    $colouronline = "rgb(255, 138, 51)";
                } elseif (($user['last_login'] + 86400) > time()) {
                    $colouronline = "rgb(255, 51, 51)";
                } else {
                    $colouronline = "rgb(116, 127, 141)";
                }
                ?>

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="avatar-lg">
                                        <img src="<?= htmlentities($user['avatar']); ?>?size=64" class="img-fluid avatar-lg rounded-circle" style="border-width : 3px; border-style : solid; border-color : <?= $colouronline ?>;" onerror="errorAvatar(this)">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <h5 class="mb-1 mt-2 font-16">
                                        <span class="<?= $ranks_class[$rank_id] ?>">
                                            <?= htmlentities($user['username']) ?>
                                            <?php if ($user['discord_nitro'] != 0) : ?>
                                                <img src="/assets/img/boost.png" style="margin-left:1px;margin-top:-2px;" width="18" height="18">
                                            <?php endif; ?>
                                        </span>
                                    </h5>
                                    <p class="mb-2 text-muted">
                                        <?= User::getUserRole($user['id']); ?>
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <a class="btn btn-sm btn-primary" href="/profile/<?= $user['id'] ?>"><i class="fa fa-user"></i> Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        <?php endforeach; ?>

    </div>
<?php endforeach; ?>

<?php if ($AUTHUSER['roles'] == 3) : ?>
    <div class="row">
        <div class="col-12">
            <div class="text-center">
                <i class="h3 fa fa-ban"></i>
                <h4 class="mb-3">Banned</h4>
            </div>
        </div>
    </div>

    <div class="row">

        <?php foreach (User::getAll() as $user) : ?>
            <?php if ($user['ban'] == 1) : ?>
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="avatar-lg">
                                        <img src="<?= $user['avatar']; ?>" class="img-fluid avatar-lg rounded-circle" style="border-width : 3px; border-style : solid; border-color : rgb(116, 127, 141);" onerror="errorAvatar(this)">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <h5 class="mb-1 mt-2 font-16">
                                        <span class="<?= $ranks_class[$rank_id] ?>">
                                            <?= $user['username'] ?>
                                        </span>
                                    </h5>
                                    <p class="mb-2 text-muted">
                                        <?= User::getUserRole($user['id']); ?>
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <a class="btn btn-sm btn-primary" href="profile/<?= $user['id'] ?>"><i class="fa fa-user"></i> Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        <?php endforeach; ?>

    </div>
<?php endif; ?>