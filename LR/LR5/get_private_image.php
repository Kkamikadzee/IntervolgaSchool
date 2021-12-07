<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR3/.core/logic/UsersLogic.php');
    if(isset($_GET['img']) && (new UsersLogic())->IsAuthorized())
    {
        $img = str_replace('/', '', $_GET['img']);
        $img = str_replace('\\', '', $img);

        $file = file_get_contents('inc/catalog_images/' . $img, true);
        echo $file;
    }
?>
