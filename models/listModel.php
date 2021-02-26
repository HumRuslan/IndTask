<?php
    namespace models;
    use core\BaseModel;
    use \PDO;

    class ListModel extends BaseModel
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