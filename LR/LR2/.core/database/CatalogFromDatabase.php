<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR2/.core/database/Database.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR2/.core/utils.php');

    class CatalogFromDatabase
    {
        private $getCatalogQuery = 'SELECT p.img_path, p.name name, f.name field_name, p.description, p.price 
                                        FROM plants as p
                                            inner join fields as f on (p.id_field = f.id)';
        private $database= null;

        private function buildQuery(
            $nameFilter = null, 
            $fieldFilter = null, 
            $descriptionFilter = null, 
            $priceMinFilter = null,
            $priceMaxFilter = null)
        {
            $filterAsCondition = array();
            $executeParams = array();

            // Какой неприятный блок условий
            if(!nullOrEmpty($nameFilter))
            {
                $filterAsCondition[] = 'p.name LIKE :nameFilter';
                $executeParams[':nameFilter'] = '%' . $nameFilter . '%';
            }
            if(!nullOrEmpty($fieldFilter))
            {
                $filterAsCondition[] = 'p.id_field = :fieldFilter';
                $executeParams[':fieldFilter'] = $fieldFilter;
            }
            if(!nullOrEmpty($descriptionFilter))
            {
                $filterAsCondition[] = 'p.description LIKE :descriptionFilter';
                $executeParams[':descriptionFilter'] = '%' . $descriptionFilter . '%';
            }
            if(!nullOrEmpty($priceMinFilter))
            {
                $filterAsCondition[] = 'p.price >= :priceMinFilter';
                $executeParams[':priceMinFilter'] = $priceMinFilter;
            }
            if(!nullOrEmpty($priceMaxFilter))
            {
                $filterAsCondition[] = 'p.price <= :priceMaxFilter';
                $executeParams[':priceMaxFilter'] = $priceMaxFilter;
            }

            return array($this->getCatalogQuery . ' WHERE ' . implode(' AND ', $filterAsCondition), $executeParams);
        }

        public function __construct()
        {
            $this->database = Database::getInstance();
        }

        public function getCatalog(
            $nameFilter = null, 
            $fieldFilter = null, 
            $descriptionFilter = null, 
            $priceMinFilter = null,
            $priceMaxFilter = null)
        {
            if (nullOrEmpty($nameFilter) 
                && nullOrEmpty($fieldFilter) 
                && nullOrEmpty($descriptionFilter) 
                && nullOrEmpty($priceMinFilter)
                && nullOrEmpty($priceMaxFilter))
                {
                    return $this->database->query($this->getCatalogQuery)->fetchAll();
                }

            list($query, $executeParams) = $this->buildQuery($nameFilter, $fieldFilter, $descriptionFilter, $priceMinFilter, $priceMaxFilter);
            //echo '<br>'.$query;
            //echo '<br>';
            //print_r($executeParams);
            //echo '<br>';
            $statement = $this->database->prepare($query);
            $statement->execute($executeParams);
            
            return $statement->fetchAll();
        }
    }
?>