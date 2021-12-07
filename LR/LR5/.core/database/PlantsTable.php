<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR5/.core/database/Database.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR5/.core/model/index.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR5/.core/utils.php');

    class PlantsTable
    {
        private $queryInsert = 
        'INSERT INTO plants
            (id, img_path, name, id_field, description, price)
            VALUES';

        private $insertValuesPart = '(:id:, :img_path:, :name:, :id_field:, :description:, :price:)';

        private $onDuplicateInsertPart = 
        'ON DUPLICATE KEY UPDATE
            img_path=VALUE(img_path),
            name=VALUE(name),
            id_field=VALUE(id_field),
            description=VALUE(description),
            price=VALUE(price)';

        private $querySelect = 'SELECT * FROM plants WHERE 1 = 1';

        private $queryCountRows = 'SELECT count(*) as count FROM plants WHERE 1 = 1';

        private $database= null;

        private function insertOrUpdateArrayObjects($plants)
        {
            $numberOfRecords = count($plants);

            $queryValues = array();
            $executeParams = array();

            for($i = 0; $i < $numberOfRecords; $i++)
            {
                $queryValues[] = str_replace([':id:', ':img_path:', ':name:', ':id_field:', ':description:', ':price:'], 
                                     [':id'.$i.'_', ':img_path'.$i.'_', ':name'.$i.'_', 
                                      ':id_field'.$i.'_', ':description'.$i.'_', ':price'.$i.'_'], 
                                     $this->insertValuesPart);

                $executeParams[':id'.$i.'_'] = $plants[$i]->getId();
                $executeParams[':img_path'.$i.'_'] = $plants[$i]->getImg_path();
                $executeParams[':name'.$i.'_'] = $plants[$i]->getName();
                $executeParams[':id_field'.$i.'_'] = $plants[$i]->getIdField();
                $executeParams[':description'.$i.'_'] = $plants[$i]->getDesctiption();
                $executeParams[':price'.$i.'_'] = $plants[$i]->getPrice();
            }

            $query = $this->queryInsert.' '.implode(', ', $queryValues) . ' ' . $this->onDuplicateInsertPart;

            $statement = $this->database->prepare($query);

            foreach($executeParams as $param => $value)
            {
                $statement->bindValue($param, $value, getPdoParamType($value));
            }

            if(!$statement->execute())
            {
                throw new PDOException("При добавление растения произошла ошибка");
            }
        }

        public function __construct()
        {
            $this->database = Database::getInstance();
        }

        public function insertOrUpdate($plants)
        {
            if(is_array($plants))
            {
                $this->insertOrUpdateArrayObjects($plants);
            }
            else
            {
                $this->insertOrUpdateArrayObjects([$plants]);
            }

            $lastInsertedId = $this->database->lastInsertId();

            return $lastInsertedId;
        }

        public function getAll()
        {
            $statement = $this->database->prepare($this->querySelect);
            $statement->execute();

            $plants = array();

            while ($row = $statement->fetch(PDO::FETCH_ORI_NEXT))
            {
                $plant = new PlantModel($row['id'], $row['img_path'], $row['name'], 
                                        $row['id_field'], $row['description'], $row['price']);
                $plants[] = $plant;
            }

            return $plants;
        }

        public function getCountRows()
        {
            $statement = $this->database->prepare($this->queryCountRows);
            $statement->execute();

            $fetch = $statement->fetchAll(PDO::FETCH_ORI_NEXT);

            return $fetch[0]['count'];
        }
    }
?>