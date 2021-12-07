<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR5/.core/database/PlantsTable.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR5/.core/model/index.php');

    class PlantsImporter
    {
        private $plantsTable;
        private $workDir = '/LR5/upload/';

        public function __construct()
        {
            $this->plantsTable = new PlantsTable();
        }

        public function importFromJson($fileContent)
        {
            $data = json_decode($fileContent);
            if($data->{'table'} != 'plants')
            {
                throw new Exception('Данный файл содержит информацию не из таблицы plants');
            }

            $startCountRow = $this->plantsTable->getCountRows();

            $plants = array();
            foreach($data->{'data'} as &$plant)
            {
                $plants[] = new PlantModel(
                    $id = $plant->{'id'}, 
                    $img_path = $plant->{'img_path'}, 
                    $name = $plant->{'name'}, 
                    $id_field = $plant->{'id_field'}, 
                    $description = $plant->{'description'}, 
                    $price = $plant->{'price'});
            }

            $this->plantsTable->insertOrUpdate($plants);

            $endCountRow = $this->plantsTable->getCountRows();

            $countInsertedRow = $endCountRow - $startCountRow;
            $countUpdatedRow = count($plants) - $countInsertedRow;

            return [
                'table' => $data->{'table'},
                'inserted' => $countInsertedRow,
                'updated' => $countUpdatedRow
            ];
        }

        public function importFromFile($filePath)
        {
            $absolutPath = $_SERVER['DOCUMENT_ROOT'] . $this->workDir . $filePath;

            if(!file_exists($absolutPath))
            {
                throw new Exception('Файл с таким именем не существует');
            }

            $path_parts = pathinfo($absolutPath);
            
            if(!isset($path_parts['extension']))
            {
                throw new Exception('Укажите файл с расширением в конце имени файла');
            }

            $importResult = null;
            if($path_parts['extension'] == 'json')
            {
                // Использую file_get_contents, потому что какой смысл разбивать json на куски.
                // "Но может быть очень большой файл". И как его читать без сторонних пакетов, если json в одну строку написан?
                $fileContent = file_get_contents($absolutPath);
                $importResult = $this->importFromJson($fileContent);
            }
            else
            {
                throw new Exception('Неизвестный формат для импорта');
            }

            return $importResult;
        }
    }
?>