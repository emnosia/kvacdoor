<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18"><i class="fas fa-trophy"></i> <?= $title ?></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/overview">KVacDoor</a></li>
                    <li class="breadcrumb-item active"><?= $title ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><i class="fa fa-flag"></i> Top 50</h4>
                <div class="table-responsive">
                    <table class="table table-centered table-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Numbers of Servers</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($leaders as $data) : ?>
                                <tr>
                                    <td><?= $index++; ?></td>
                                    <td class="table-user">
                                        <img src="<?= $data['avatar'] ?>" alt="<?= $data['username'] ?>" class="mr-2 avatar-xs rounded-circle" onerror="errorAvatar(this)">
                                        <a href="profile/<?= $data['id'] ?>" class="text-body font-weight-semibold"><?= $data['username'] ?></a>
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

</div>