<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR6/.core/database/Database.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR6/.core/model/index.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR6/.core/utils.php');

    class FieldsTable
    {
        private $querySelect = 'SELECT id, name 
                                        FROM fields';
        private $database= null;

        public function __construct()
        {
            $this->database = Database::getInstance();
        }

        public function getAll()
        {
            $statement = $this->database->prepare($this->querySelect);
            $statement->execute();

            $fields = array();

            while ($row = $statement->fetch(PDO::FETCH_ORI_NEXT))
            {
                $field = new FieldModel($row['id'], $row['name']);
                $fields[] = $field;
            }

            return $fields;
        }
    }
?>