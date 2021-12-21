<?php
    class FieldModel implements JsonSerializable
    {
        private $id;
        private $name;

        public function __construct($id = null, $name = null)
        {
            $this->id = $id;
            $this->name = $name;
        }

        public function getId() { return $this->id; }
        public function setId($value) { $this->id = $value; }

        public function getName() { return $this->name; }
        public function setName($value) { $this->name = $value; }

        public function jsonSerialize()
        {
            return [
                'id' => $this->id,
                'name' => $this->name
            ];
        }
    }
?>