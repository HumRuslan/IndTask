<?php
    namespace models;
    use core\BaseModel;
    use \PDO;

    class UserModel extends BaseModel
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