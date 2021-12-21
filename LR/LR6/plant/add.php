<?php 
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR6/.core/logic/PlantsLogic.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR6/.core/utils.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR6/.core/model/PlantModel.php');

    $plantsLogic = new PlantsLogic();

    if(!(isset($_POST['plantName'])
        && isset($_POST['plantField'])
        && isset($_POST['plantDescription'])
        && isset($_POST['plantPrice'])
        && isset($_POST['MAX_FILE_SIZE'])
        && isset($_FILES['plantImage'])))
    {
        throw new Exception('Одно из полей не полученно');
    }

    $imgName = uploadFile($_FILES['plantImage'], $_POST['MAX_FILE_SIZE']);

    $newPlant = new PlantModel($id = null,
                                nullorEmpty($imgName) ? $oldPlant->getImgPath() : $imgName,
                                htmlspecialchars($_POST['plantName']),
                                new FieldModel(htmlspecialchars($_POST['plantField'])),
                                htmlspecialchars($_POST['plantDescription']),
                                htmlspecialchars($_POST['plantPrice']));

    $plantsLogic->add($newPlant);

    header("Location: /LR6/plant/", true, 303);
?>
