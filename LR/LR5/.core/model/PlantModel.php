<?php
    class PlantModel implements JsonSerializable
    {
        private $id;
        private $img_path;
        private $name;
        private $id_field;
        private $description;
        private $price;

        public function __construct($id = null, $img_path = null, $name = null, $id_field = null, $description = null, $price = null)
        {
            $this->id = $id;
            $this->img_path = $img_path;
            $this->name = $name;
            $this->id_field = $id_field;
            $this->description = $description;
            $this->price = $price;
        }

        public function getId() { return $this->id; }
        public function setId($value) { $this->id = $value; }

        public function getImg_path() { return $this->img_path; }
        public function setImg_path($value) { $this->img_path = $value; }

        public function getName() { return $this->name; }
        public function setName($value) { $this->name = $value; }

        public function getIdField() { return $this->id_field; }
        public function setIdField($value) { $this->id_field = $value; }

        public function getDesctiption() { return $this->description; }
        public function setDesctiption($value) { $this->description = $value; }

        public function getPrice() { return $this->price; }
        public function setPrice($value) { $this->price  = $value; }

        public function jsonSerialize()
        {
            return [
                'id' => $this->id,
                'img_path' => $this->img_path,
                'name' => $this->name,
                'id_field' => $this->id_field,
                'description' => $this->description,
                'price' => $this->price
            ];
        }
    }
?>