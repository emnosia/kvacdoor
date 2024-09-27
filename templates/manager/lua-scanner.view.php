<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18"><i class="fa fa-blind"></i> <?= $title ?></h4>

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
        <?php if (!empty($errors)) : ?>
            <?php foreach ($errors as $error) : ?>
                <div class="alert alert-danger">
                    <?= $error; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <div align="center">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">To use the Lua-Scanner module you must select the <code>.zip</code> you want to scan.</label><br>
                    <input type="file" name="file">
                    <input type="submit" value="Scan" name="submit" class="btn btn-primary btn-sm">
                </div>
            </form>
        </div>

        <?php if (!empty($detectedBackdoors)) : ?>
            <div class="container">
                <table class="table table-striped table-dark">
                    <thead>
                        <tr>
                            <th scope="col"><i>Filename</i></th>
                            <th scope="col"><i>Detection</i></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($detectedBackdoors as $filename => $backdoors) : ?>
                            <tr>
                                <td><b><?= $filename ?></b></td>
                                <td>
                                    <ul class="ml-0">
                                    <?php foreach ($backdoors as $backdoor) : ?>
                                        <li>
                                            <p><?= $backdoor['name'] ?> <?= $backdoor['level'] == 3 ? '⛔' : '🟡' ?></p>
                                        </li>
                                    <?php endforeach; ?>
                                    </ul>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php elseif(isset($_FILES["file"]["name"])): ?>
            <div class="alert alert-info text-center">
                <b>No Backdoor found !</b>
            </div>
        <?php endif; ?>

    </div>

</div>