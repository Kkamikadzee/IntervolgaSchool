<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR6/.core/database/FieldsTable.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR6/.core/utils.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR6/.core/index.php');

    class FieldsLogic
    {
        private $fieldsTable = null;

        public function __construct()
        {
            $this->fieldsTable = new FieldsTable();
        }

        public function getAll()
        {
            return $this->fieldsTable->getAll();
        }
    }
?>