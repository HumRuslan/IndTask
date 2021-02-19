<?php
namespace controllers;

use core\baseController;
use models\taskModel;
use models\listModel;

class taskController extends baseController
{
    public function __construct()
    {
        if (!isset($_SESSION)) session_start();
        $this->layot = true;
    }

    public function indexAction()
    {
        $tasks = taskModel::find()
                ->where(['list_id' => $_GET['list_id']])
                ->orderBy(['name' => 'ASC'])
                ->all();
        $list = listModel::find()
                ->where(['id' => $_GET['list_id']])
                ->one();
        $this->render('index', ['tasks' => $tasks, 'list' => $list]);
        $this->render('index');
    }

    public function createAction()
    {
        $model = new taskModel;
        if ($model->loadPost()) {
            $model->user_id = $_SESSION['auth'];

            if ($model->validate()) {
                if ($model->save()){
                    $_SESSION['success'] = 'record save';
                } else {
                    $_SESSION['error'] = 'error save DB';
                }
                $this->redirect('/list/index');
            }
        }
        $this->render('create', ['model' => $model]);
    }
}