<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR3/.core/database/index.php');

    if(isset($_GET['clear']))
    {
        header("Location: index.php");
    }
    
    $title = 'Plant store';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>
        <?php 
            echo $title;
        ?>
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        include('header.php');
    ?>
    <main>
        <div class="my-3 d-grid gap-2 col-3 mx-auto">
            Не стану дублировать информацию об авторизации, ибо она видна в header'е.
        </div>
    </main>
<?php include('footer.php');?>
</body>
</html>
