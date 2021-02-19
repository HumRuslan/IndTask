<?php
    namespace core;
    use config\config;

    class baseController extends config
    {
        protected $layot;

        public function render ($view, array $params = [])
        {
            $className = str_replace('Controller', '', substr(get_class($this), strrpos(get_class($this), "\\")+1));
            if ($this->layot){
                require_once './views/_shared/header.php';
            }
            $viewPath ='./views/' . $className . '/' . $view . '.php';
            if (file_exists($viewPath)){
                extract ($params);
                require_once $viewPath;
            } else {
                extract(['error' => "View file not found file name: $viewPath"]);
                require_once ('./views/_shared/error.php');
            }
            if ($this->layot){
                require_once ('./views/_shared/footer.php');
            }
        }

        public function redirect($path)
        {
            Header("Location: $path");
        }

        protected function passwordHasher($password){
            return sha1(self::SALT . $password . self::SALT);
        }
    }