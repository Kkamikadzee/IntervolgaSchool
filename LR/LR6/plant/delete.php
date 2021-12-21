<?php 
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR6/.core/logic/PlantsLogic.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR6/.core/utils.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR6/.core/model/PlantModel.php');

    $plantsLogic = new PlantsLogic();

    if(!(isset($_POST['plantId'])
        && isset($_POST['plantName'])
        && isset($_POST['plantField'])
        && isset($_POST['plantFieldName'])
        && isset($_POST['plantDescription'])
        && isset($_POST['plantPrice'])
        && isset($_POST['plantImgPath'])))
    {
        throw new Exception('Одно из полей не полученно');
    }

    $newPlant = new PlantModel(htmlspecialchars($_POST['plantId']),
                                htmlspecialchars($_POST['plantImgPath']),
                                htmlspecialchars($_POST['plantName']),
                                new FieldModel(htmlspecialchars($_POST['plantField']), 
                                    htmlspecialchars($_POST['plantFieldName'])),
                                htmlspecialchars($_POST['plantDescription']),
                                htmlspecialchars($_POST['plantPrice']));

    $plantsLogic->delete($newPlant);

    header("Location: /LR6/plant/", true, 303);
?>
