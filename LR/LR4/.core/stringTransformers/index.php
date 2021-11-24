<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR4/.core/stringTransformers/Task4.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR4/.core/stringTransformers/Task7.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR4/.core/stringTransformers/TableOfContentsConstructor.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR4/.core/stringTransformers/Task18.php');

    function getStringTransformers()
    {
        return [
            '4' => new Task4(), 
            '7' => new Task7(), 
            '18' => new Task18()
        ];
    }
?>