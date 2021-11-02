<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR3/.core/logic/UsersLogic.php');
    
    $userLogic = new UsersLogic();
    if($userLogic->isAuthorized())
    {
        $userName = $userLogic->signOut();
    }

    header("Location: login.php");
?>