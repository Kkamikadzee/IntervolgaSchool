<?php include('header.php');?>
<main>
    <div class="my-3 d-grid gap-2 col-3 mx-auto">
        <div class="container">
            <?php if(isset($_GET['result']) && $_GET['result']): ?>
                <h4>
                    <span>Файл с данными сохранен на диск по адресу: </span>
                    <a href="<?= $_GET['url'] ?>" download="<?= pathinfo($_GET['url'])['filename'] ?>"><?= $_GET['url'] ?></a>
                </h4>
                    <a class="btn btn-primary" href="/LR5/export.php">Назад</a>
            <?php  elseif(isset($_GET['result']) && !$_GET['result']): ?>
                <h4>
                    <span>Ошибка при экспорте: </span>
                </h4>
                    <p><?= $_GET['msg'] ?></p>
                    <a class="btn btn-primary" href="/LR5/export.php">Назад</a>
            <?php  else: ?>
                <form method="post" action="exporter.php">
                    <div class="form-group">
                        <label for="path_to_save">Путь сохранения файла</label>
                        <input type="text" class="form-control" id="path_to_save" name="path_to_save" placeholder="export.json" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </form>
            <?php endif?>
        </div>
    </div>
</main>
<?php include('footer.php');?>