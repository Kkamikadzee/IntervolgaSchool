<?php
    class PlantModel implements JsonSerializable
    {
        private $id;
        private $imgPath;
        private $name;
        private $field;
        private $description;
        private $price;

        public function __construct($id = null, $imgPath = null, $name = null, $field = null, $description = null, $price = null)
        {
            $this->id = $id;
            $this->imgPath = $imgPath;
            $this->name = $name;
            $this->field = $field;
            $this->description = $description;
            $this->price = $price;
        }

        public function getId() { return $this->id; }
        public function setId($value) { $this->id = $value; }

        public function getImgPath() { return $this->imgPath; }
        public function setImgPath($value) { $this->imgPath = $value; }

        public function getName() { return $this->name; }
        public function setName($value) { $this->name = $value; }

        public function getField() { return $this->field; }
        public function setField($value) { $this->field = $value; }

        public function getDescription() { return $this->description; }
        public function setDescription($value) { $this->description = $value; }

        public function getPrice() { return $this->price; }
        public function setPrice($value) { $this->price  = $value; }

        public function jsonSerialize()
        {
            return [
                'id' => $this->id,
                'imgPath' => $this->imgPath,
                'name' => $this->name,
                'field' => $this->field,
                'description' => $this->description,
                'price' => $this->price
            ];
        }
    }
?>