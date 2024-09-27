<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18"><i class="fab fa-accessible-icon"></i> <?= $title ?></h4>

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
        <?php if (isset($errors)): ?>
        <?php foreach ($errors as $error): ?>
        <div class="alert alert-danger">
        <?= $error; ?>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
        <div align="center">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Select the <code>.zip</code> file where you want to inject your code and click on "Inject"</label>
                    <br>
                    <input type="file" accept="application/zip, application/x-zip-compressed, multipart/x-zip, application/x-compressed" name="filetoscan">
                    <input type="submit" value="Inject" name="submit" class="btn btn-primary btn-sm">
                </div>
            </form>
        </div>
        <?php if ($showDL): ?>
        <div class="alert alert-info text-center">
            <a href="/assets/upload/<?= $filename; ?>" download="<?= $filename; ?>">Télécharger l'addons</a>
        </div>
        <?php endif; ?>
    </div>
</div>