<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR5/.core/database/PlantsTable.php');

    class PlantsExporter
    {
        private $plantsTable;
        private $workDir = '/LR5/upload/';

        public function __construct()
        {
            $this->plantsTable = new PlantsTable();
        }

        public function exportToJson()
        {
            $data = [
                'table' => 'plants',
                'data' => $this->plantsTable->getAll()
            ];
            return json_encode($data);
        }

        public function exportToFile($filePath)
        {
            $absolutPath = $_SERVER['DOCUMENT_ROOT'] . $this->workDir . $filePath;

            if(file_exists($absolutPath))
            {
                throw new Exception('Файл с таким именем уже существует');
            }

            $fileContent = null;

            $path_parts = pathinfo($absolutPath);
            
            if(!isset($path_parts['extension']))
            {
                throw new Exception('Укажите расширение в конце имени файла');
            }

            if($path_parts['extension'] == 'json')
            {
                $fileContent = $this->exportToJson();
            }
            else
            {
                throw new Exception('Неизвестный формат для импорта');
            }

            file_put_contents($absolutPath, $fileContent, LOCK_EX);

            return $this->workDir . $filePath;
        }
    }
?>