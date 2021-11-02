<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR3/.core/database/UsersTable.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR3/.core/utils.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LR3/.core/index.php');

    class UsersLogic
    {


        private $usersTable = null;

        private function allParamsIsValid($email, $full_name, $data_of_birth, $gender, 
            $blood_type, $rh, $password1, $password2, 
            $address_country, $address_city, $address_street, 
            $address_house, $address_room,
            $interests, $url_vk)
        {
            if(nullOrEmpty($email))
                throw new Exception('Некорретный формат электронной почты');

            if(nullOrEmpty($full_name))
                throw new Exception('Имя не может быть пустым');

            if(nullOrEmpty($data_of_birth))
                throw new Exception('Некорретный формат даты');

            if(nullOrEmpty($gender))
                throw new Exception('Гендер не может быть пустым');

            if(nullOrEmpty($blood_type))
                throw new Exception('Группа крови не может быть пустой');

            if(nullOrEmpty($rh))
                throw new Exception('Резус-фактор не может быть пустой');

            if(nullOrEmpty($password1))
                throw new Exception('Поле с паролем не может быть пустым');

            if(nullOrEmpty($password2))
                throw new Exception('Поле с повторным вводом пароля не может быть пустым');

            if($password1 != $password2)
                throw new Exception('Введённые пароли не совпадают');

            if(strlen($password1) <= 6)
                throw new Exception('Пароль должен быть длиннее 6 символов');

            // Я бы в жизни не стал регистрироваться на сайте с такими ограничениями по паролю
            // "azAZ12[] -_"
	        $a_zCharsRegExp = '/[a-z]/';
	        $A_ZCharsRegExp = '/[A-Z]/';
	        $digitCharsRegExp = '/\d/';
	        $specialCharsRegExp = '/[\'\/~`\!@#\$%\^&\*\(\)\\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
	        $hyphenCharsRegExp = '/-/';
	        $spaceCharsRegExp = '/ /';
	        $underscoreCharsRegExp = '/_/';
            if(!(preg_match($a_zCharsRegExp, $password1) > 0
                && preg_match($A_ZCharsRegExp, $password1) > 0
                && preg_match($digitCharsRegExp, $password1) > 0
                && preg_match($specialCharsRegExp, $password1) > 0
                && strpos($password1, $hyphenCharsRegExp) === false
                && strpos($password1, $spaceCharsRegExp) === false
                && strpos($password1, $underscoreCharsRegExp) === false))
            {
                throw new Exception('Пароль обязательно должен содержать: большие латинские буквы, маленькие латинские буквы, спецсимволы (знаки препинания, арифметические действия и тп), пробел, дефис, подчеркивание и цифры. Русские буквы запрещены.');
            }
        }

        public function __construct()
        {
            $this->usersTable = new UsersTable();
        }

        public function signUp($email, $full_name, $data_of_birth, $gender, 
            $blood_type, $rh, $password1, $password2, 
            $address_country, $address_city, $address_street, 
            $address_house, $address_room,
            $interests, $url_vk)
        {
            $this->allParamsIsValid($email, $full_name, $data_of_birth, $gender, 
                $blood_type, $rh, $password1, $password2, 
                $address_country, $address_city, $address_street, 
                $address_house, $address_room,
                $interests, $url_vk);

            $existed_user = $this->usersTable->getByEmail($email);
            if($existed_user != null)
                throw new Exception('Пользователь с такой электронной почтой уже существует');

            $created_id = $this->usersTable->create($email, $full_name, $data_of_birth, $gender, 
                            $blood_type, $rh, getMd5Hash($password1), 
                            $address_country, $address_city, $address_street, 
                            $address_house, $address_room,
                            $interests, $url_vk);

            $_SESSION['USER_ID'] = $created_id;
        }

        public function signIn($email, $password)
        {
            if($this->isAuthorized())
            {
                throw new Exception('Вы уже авторизованы');
            }

            $user = $this->usersTable->getByEmail($email);
            if($user == null)
            {
                throw new Exception('Пользователь с таким email не найден');
            }

            if(getMd5Hash($password) != $user['password'])
            {
                throw new Exception('Неверно указан пароль');
            }

            $_SESSION['USER_ID'] = $user['id'];
        }

        public function signOut()
        {
            unset($_SESSION['USER_ID']);
        }

        public function isAuthorized()
        {
            return isset($_SESSION['USER_ID']);
        }

        public function current()
        {
            if (!$this->isAuthorized())
            {
                return null;
            }

            $user = $this->usersTable->getById($_SESSION['USER_ID']);
            unset($user['password']);

            return $user;
        }
    }
?>