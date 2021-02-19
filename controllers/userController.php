<?php
namespace controllers;

use core\baseController;
use models\userModel;

class userController extends baseController
{
    public function __construct()
    {
        if (!isset($_SESSION)) session_start();
        $this->layot = true;
    }

    public function indexAction()
    {
        if (isset($_SESSION['auth'])) {
            $this->redirect('/list/index');
        }
        $this->render('index');
    }

    public function loginAction()
    {
        $user = userModel::find()
                    ->where(['email' => $_POST['email'],
                           'password' => $this->passwordHasher($_POST['password'])
                    ])
                    ->one();
        if ($user) {
            $_SESSION['auth'] = $user->id;
            $this->redirect('/list/index');
        } else {
            $_SESSION['error'] = 'Incorrect email or password';
        }           
        $this->render('index');
    }

    public function registerAction()
    {
        
        $user = userModel::find()
                    ->where(['email' => $_POST['email']])
                    ->one();
        if ($user) {
            $_SESSION['error'] = 'User with this email is already registered';
        } else {
        $user = new userModel;
        if ($user->loadPost() && $user->validate()){
            
            $user->password = $this->passwordHasher($user->password);
            if ($user->save()){
                $_SESSION['success'] = 'User is registered';
                $_SESSION['auth'] = $user->id;
                $this->redirect('/list/index');
            } else {
                $_SESSION['error'] = 'User registration error. Try later';
                $this->render('index');
            }
        }
    }
        $this->render('index');
    }

    public function logOutAction()
    {
        session_unset();
        session_destroy();
        $this->render('index');
    }
}