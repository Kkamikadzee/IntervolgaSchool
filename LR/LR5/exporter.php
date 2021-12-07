<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR5/.core/export/index.php');

    $result = array();
    if(isset($_POST['path_to_save'])) //action="exporter.php"
    {
        try
        {
            $plantExporter = new PlantsExporter();
            $pathToFile = $plantExporter->exportToFile($_POST['path_to_save']);
            $result['result'] = true;
            $result['url'] = $pathToFile;
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
        $result['msg'] = 'Не указан путь для сохранения';
    }

    header("Location: ".$_SERVER['HTTP_REFERER'] . '?' . http_build_query($result), true, 303);
?>