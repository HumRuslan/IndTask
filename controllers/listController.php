<?php
namespace controllers;
use core\baseController;
use models\listModel;

class listController extends baseController
{
    public function __construct()
    {
        if (!isset($_SESSION)) session_start();
        if (!isset($_SESSION['auth'])) {
            $this->redirect('/');
        }
        $this->layot = true;
    }

    public function indexAction()
    {
        $lists = listModel::find()
                    ->where(['user_id' => $_SESSION['auth']])
                    ->orderBy(['name' => 'ASC'])
                    ->all();
        $this->render('index', ['lists' => $lists]);
    }

    public function createAction()
    {
        $model = new listModel;
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

    public function editAction()
    {
        $model = new listModel;
        $list = listModel::find()
                        ->where(['id' => $_GET['id']])
                        ->one();
        foreach ($list as $key => $value){
            $model->{$key} = $value;
        }
        if ($model->loadPost() && $model->validate()){
            $model->update(['id' => $list->id]);
            $this->redirect('/list/index');
        }
        $this->render('create', ['model' => $model]);
    }

    public function deleteAction()
    {
        listModel::delete(['id' => $_GET['id']]);
        $this->redirect('/list/index');
    }
}