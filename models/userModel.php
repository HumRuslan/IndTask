<?php
    namespace models;
    use core\baseModel;
    use \PDO;

    class userModel extends baseModel
    {
        public $id;
        public $email;
        public $password;

        static $table = 'users';

        public function rules()
        {
            return [
                'required' => ['email', 'password'],
                'email'    => ['email'],
            ];
        }
    }