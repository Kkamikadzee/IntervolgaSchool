<?php include('header.php');?>
<main>
    <div class="my-3 d-grid gap-2 col-3 mx-auto">
        <div class="container">
            <?php if(isset($_GET['result']) && $_GET['result']): ?>
                <h4>
                    <span>Файл с данными получен из "<?= $_GET['pathToFile'] ?>" и обработан. В таблице "<?= $_GET['pathToFile'] ?>" обновлено <?= $_GET['updated'] ?> и создано <?= $_GET['inserted'] ?> записи.</span>
                </h4>
                    <a class="btn btn-primary" href="/LR5/import.php">Назад</a>
            <?php  elseif(isset($_GET['result']) && !$_GET['result']): ?>
                <h4>
                    <span>Ошибка при импорте: </span>
                </h4>
                    <p><?= $_GET['msg'] ?></p>
                    <a class="btn btn-primary" href="/LR5/import.php">Назад</a>
            <?php  else: ?>
                <form method="post" action="importer.php" >
                    <div class="form-group">
                        <label for="path_to_file">Путь к JSON файлу</label>
                        <input type="text" class="form-control" name="path_to_file" id="path_to_file" placeholder="import.json" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Загрузить</button>
                </form>
            <?php endif?>
        </div>
    </div>
</main>
<?php include('footer.php');?>