<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR6/.core/database/PlantsTable.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR6/.core/utils.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR6/.core/index.php');

    class PlantsLogic
    {
        private $plantsTable = null;

        private function removeOldImg($oldPlants)
        {
            $restPlants = $this->plantsTable->getRest($oldPlants);

            foreach($oldPlants as &$oldPlant)
            {
                $fileName = $oldPlant->getImgPath();

                $fileIsUsed = false;
                foreach($restPlants as &$plant)
                {
                    if($plant->getImgPath() == $fileName)
                    {
                        $fileIsUsed = true;
                        break;
                    }
                }

                if(!$fileIsUsed)
                {
                    unlink($_SERVER['DOCUMENT_ROOT'] . '/LR6/' . getPathToCatalogImage($fileName));
                }
            }
        }

        public function __construct()
        {
            $this->plantsTable = new PlantsTable();
        }

        public function getAll()
        {
            return $this->plantsTable->getAll();
        }

        public function getById($id)
        {
            return $this->plantsTable->getById($id);
        }

        public function edit($oldPlant, $newPlant)
        {
            if($oldPlant->getImgPath() != $newPlant->getImgPath())
            {
                $this->removeOldImg([$oldPlant]);
            }

            $this->plantsTable->update($newPlant);
        }

        public function add($plants)
        {
            return $this->plantsTable->insert($plants);
        }

        public function delete($plants)
        {
            if(is_array($plants))
            {
                $this->removeOldImg($plants);
            }
            else
            {
                $this->removeOldImg([$plants]);
            }

            return $this->plantsTable->delete($plants);
        }
    }
?>