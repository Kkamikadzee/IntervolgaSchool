<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR3/.core/database/Database.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR3/.core/utils.php');

    class FieldsTable
    {
        private $getCatalogQuery = 'SELECT id, name 
                                        FROM fields';
        private $database= null;

        public function __construct()
        {
            $this->database = Database::getInstance();
        }

        public function getFields()
        {
            return $this->database->query($this->getCatalogQuery)->fetchAll();
        }
    }
?>