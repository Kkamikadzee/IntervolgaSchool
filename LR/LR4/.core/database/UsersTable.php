<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR3/.core/database/Database.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR3/.core/utils.php');

    class UsersTable
    {
        private $queryInsert = 
        'INSERT users
            (email, full_name, data_of_birth, gender, 
            address_country, address_city, address_street, address_house, address_room,
            interests, url_vk, blood_type, rh, password)
            VALUES
            (:email, :full_name, :data_of_birth, :gender, 
            :address_country, :address_city, :address_street, :address_house, :address_room,
            :interests, :url_vk, :blood_type, :rh, :password)';
        private $queryGetByParam = 
        'SELECT * 
            FROM `users` 
            WHERE `:param_name` = :param_value LIMIT 1';

        private $database= null;

        private function getFirstByParam($param_name, $param_value)
        {
            $query = $this->database->prepare(str_replace(':param_name', $param_name, $this->queryGetByParam));
            $query->bindValue(':param_value', $param_value, getPdoParamType($param_value));
            $query->execute();

            $users = $query->fetchAll();

            if(!count($users))
            {
                return null;
            }

            return $users[0];
        }

        public function __construct()
        {
            $this->database = Database::getInstance();
        }

        public function create($email, $full_name, $data_of_birth, $gender, 
            $blood_type, $rh, $password, 
            $address_country = null, $address_city = null, $address_street = null, 
            $address_house = null, $address_room = null,
            $interests = null, $url_vk = null)
        {
            $query = $this->database->prepare($this->queryInsert);

            $query->bindValue(':email', $email, getPdoParamType($email));
            $query->bindValue(':full_name', $full_name, getPdoParamType($full_name));
            $query->bindValue(':data_of_birth', $data_of_birth, getPdoParamType($data_of_birth));
            $query->bindValue(':gender', $gender, getPdoParamType($gender));
            $query->bindValue(':blood_type', $blood_type, getPdoParamType($blood_type));
            $query->bindValue(':rh', $rh, getPdoParamType($rh));
            $query->bindValue(':password', $password, getPdoParamType($password));
            $query->bindValue(':address_country', $address_country, getPdoParamType($address_country));
            $query->bindValue(':address_city', $address_city, getPdoParamType($address_city));
            $query->bindValue(':address_street', $address_street, getPdoParamType($address_street));
            $query->bindValue(':address_house', $address_house, getPdoParamType($address_house));
            $query->bindValue(':address_room', $address_room, getPdoParamType($address_room));
            $query->bindValue(':interests', $interests, getPdoParamType($interests));
            $query->bindValue(':url_vk', $url_vk, getPdoParamType($url_vk));

            if(!$query->execute())
            {
                throw new PDOException("При добавление пользователя произошла ошибка");
            }

            $inserted_id = $this->database->lastInsertId();

            return $inserted_id;
        }

        public function getByEmail($email)
        {
            return $this->getFirstByParam('email', $email);
        }

        public function getById($id)
        {
            return $this->getFirstByParam('id', $id);
        }
    }
?>