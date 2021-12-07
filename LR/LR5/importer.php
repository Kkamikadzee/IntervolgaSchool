<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR5/.core/import/index.php');

    $result = array();
    if(isset($_POST['path_to_file'])) //action="importer.php" 
    {
        try
        {
            $plantImporter = new PlantsImporter();
            $importResult = $plantImporter->importFromFile($_POST['path_to_file']);
            $result['result'] = true;
            $result['pathToFile'] = $_POST['path_to_file'];
            $result['table'] = $importResult['table'];
            $result['updated'] = $importResult['updated'];
            $result['inserted'] = $importResult['inserted'];
        }
        catch (Exception $e)
        {
            $result['result'] = false;
            $result['msg'] = $e->getMessage();
        }
    }
    else
    {
        $result['result'] = false;
        $result['msg'] = 'Не указан путь к файлу';
    }

    header("Location: ".$_SERVER['HTTP_REFERER'] . '?' . http_build_query($result), true, 303);
?>