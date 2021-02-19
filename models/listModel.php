<?php
    namespace models;

    use core\baseModel;
    use \PDO;

    class listModel extends baseModel
    {
        public $id;
        public $name;
        public $user_id;

        static $table = 'lists';

        public function rules()
        {
            return [
                'required' => ['name', 'user_id'],
                'text'     => ['name'],
                'integer'  => ['user_id'],
            ];
        }
    }