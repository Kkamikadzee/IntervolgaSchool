<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR6/.core/database/Database.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR6/.core/model/index.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR6/.core/utils.php');

    class PlantsTable
    {
        private $database= null;

        private $queryCountRows = 
        '
        SELECT count(*) as count FROM plants WHERE 1 = 1
        ';

        private $querySelect = 
        '
        SELECT p.id as p_id, 
		        p.img_path as p_img_path, 
                p.name as p_name, 
                p.description as p_description, 
                p.price as p_price, 
                f.id as f_id, 
                f.name as f_name
	        FROM plants AS p 
    	        INNER JOIN fields AS f ON (p.id_field = f.id) 
            WHERE 1 = 1
        ';

        private $querySelectIdEqualsPart = 
        '
        p.id = :p_id:
        ';

        private $querySelectIdNotEqualsPart = 
        '
        p.id != :p_id:
        ';

        private $queryInsert = 
        '
        INSERT INTO plants
            (id, img_path, name, id_field, description, price)
            VALUES
        ';

        private $insertValuesPart = 
        '
        (:id:, :img_path:, :name:, :id_field:, :description:, :price:)
        ';

        private $onDuplicateInsertPart = 
        '
        ON DUPLICATE KEY UPDATE
            img_path=VALUE(img_path),
            name=VALUE(name),
            id_field=VALUE(id_field),
            description=VALUE(description),
            price=VALUE(price)
        ';

        private $queryUpdate = 
        '
        UPDATE plants
            SET img_path = :img_path,
                name = :name,
                id_field = :id_field,
                description = :description,
                price = :price
            WHERE id = :id
        ';

        private $queryDelete =
        '
        DELETE FROM plants
        ';

        private $queryDeleteIdPart = 
        '
        id = :id:
        ';

        private $queryLimitPart = 
        '
        LIMIT %d
        ';

        private function insertArrayObjects($plants, $onDuplicateUpdate = false)
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
                $executeParams[':img_path'.$i.'_'] = $plants[$i]->getImgPath();
                $executeParams[':name'.$i.'_'] = $plants[$i]->getName();
                $executeParams[':id_field'.$i.'_'] = $plants[$i]->getField()->getId();
                $executeParams[':description'.$i.'_'] = $plants[$i]->getDescription();
                $executeParams[':price'.$i.'_'] = $plants[$i]->getPrice();
            }

            if ($onDuplicateUpdate)
            {
                $query = $this->queryInsert.' '.implode(', ', $queryValues) . ' ' . $this->onDuplicateInsertPart;
            }
            else
            {
                $query = $this->queryInsert.' '.implode(', ', $queryValues);
            }

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

        private function deleteArrayObjects($plants)
        {
            $numberOfRecords = count($plants);

            $queryValues = array();
            $executeParams = array();

            for($i = 0; $i < $numberOfRecords; $i++)
            {
                $queryValues[] = str_replace(':id:', ':id'.$i.'_', 
                                     $this->queryDeleteIdPart);

                $executeParams[':id'.$i.'_'] = $plants[$i]->getId();
            }

            $query = $this->queryDelete.' WHERE '.implode(' OR ', $queryValues);

            $statement = $this->database->prepare($query);

            foreach($executeParams as $param => $value)
            {
                $statement->bindValue($param, $value, getPdoParamType($value));
            }

            if(!$statement->execute())
            {
                throw new PDOException("При удалении растения произошла ошибка");
            }
        }

        private function selectRestArrayObjects($plants)
        {
            $numberOfRecords = count($plants);

            $queryValues = array();
            $executeParams = array();

            for($i = 0; $i < $numberOfRecords; $i++)
            {
                $queryValues[] = str_replace(':p_id:', ':p_id'.$i.'_', 
                                     $this->querySelectIdNotEqualsPart);

                $executeParams[':p_id'.$i.'_'] = $plants[$i]->getId();
            }

            $query = $this->querySelect.' AND '.implode(' AND ', $queryValues);

            $statement = $this->database->prepare($query);

            foreach($executeParams as $param => $value)
            {
                $statement->bindValue($param, $value, getPdoParamType($value));
            }

            if(!$statement->execute())
            {
                throw new PDOException("При добавление растения произошла ошибка");
            }

            return $this->convertRowToObjects($statement);
        }

        private function convertRowToObjects($statement)
        {
            $plants = array();

            while ($row = $statement->fetch(PDO::FETCH_ORI_NEXT))
            {
                $plant = new PlantModel($row['p_id'], $row['p_img_path'], $row['p_name'], 
                                        new FieldModel($row['f_id'], $row['f_name']), 
                                        $row['p_description'], $row['p_price']);
                $plants[] = $plant;
            }

            return $plants;
        }

        public function __construct()
        {
            $this->database = Database::getInstance();
        }

        public function insert($plants, $onDuplicateUpdate = false)
        {
            if(is_array($plants))
            {
                $this->insertArrayObjects($plants, $onDuplicateUpdate);
            }
            else
            {
                $this->insertArrayObjects([$plants], $onDuplicateUpdate);
            }
        }

        public function update($plant)
        {
            $statement = $this->database->prepare($this->queryUpdate);

            $statement->bindValue(':id', $plant->getId(), getPdoParamType($plant->getId()));
            $statement->bindValue(':img_path', $plant->getImgPath(), getPdoParamType($plant->getImgPath()));
            $statement->bindValue(':name', $plant->getName(), getPdoParamType($plant->getName()));
            $statement->bindValue(':id_field', $plant->getField(), getPdoParamType($plant->getField()));
            $statement->bindValue(':description', $plant->getDescription(), getPdoParamType($plant->getDescription()));
            $statement->bindValue(':price', $plant->getPrice(), getPdoParamType($plant->getPrice()));

            if(!$statement->execute())
            {
                throw new PDOException("При удалении растения произошла ошибка");
            }

        }

        public function delete($plants)
        {
            if(is_array($plants))
            {
                $this->deleteArrayObjects($plants);
            }
            else
            {
                $this->deleteArrayObjects([$plants]);
            }
        }

        public function getAll()
        {
            $statement = $this->database->prepare($this->querySelect);
            $statement->execute();

            $plants = $this->convertRowToObjects($statement);

            return $plants;
        }

        public function getById($id)
        {
            $query = $this->querySelect . 'AND' . str_replace(':p_id:', ':p_id', $this->querySelectIdEqualsPart) . sprintf($this->queryLimitPart, 1);

            $statement = $this->database->prepare($query);

            $statement->bindValue(':p_id', $id, getPdoParamType($id));

            if(!$statement->execute())
            {
                throw new PDOException("При удалении растения произошла ошибка");
            }

            $plants = $this->convertRowToObjects($statement);

            return $plants[0];
        }

        public function getRest($plants)
        {
            if(is_array($plants))
            {
                return $this->selectRestArrayObjects($plants);
            }
            else
            {
                return $this->selectRestArrayObjects([$plants]);
            }
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