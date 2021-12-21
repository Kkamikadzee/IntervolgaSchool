<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR6/.core/utils.php');

    $fileName = $_GET['img'];
    $fileName = str_replace('/', '', $fileName);
    $fileName = str_replace('\\', '', $fileName);
    $fileName = getPathToCatalogImage($fileName);

    if (file_exists($fileName)) {

       $imageInfo = getimagesize($fileName);

       header('Content-Type: ' . $imageInfo['mime']);
       
       header('Content-Length: ' . filesize($fileName));
       
       readfile($fileName);
    }
?>
