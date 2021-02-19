<?php
    namespace models;
    use core\baseModel;
    use \PDO;

    class taskModel extends baseModel
    {
        public $id;
        public $name;
        public $user_id;
        public $list_id;
        public $completed;
        public $position;
        public $created_at;
        public $completed_at;

        static $table = 'tasks';

        public function rules()
        {
            return [
                'required' => ['name', 'user_id', 'list_id', ],
                'text'     => ['name'],
                'integer'  => ['user_id', 'list_id', 'position'],
                'boolean'  => ['completed'],

            ];
        }
    }