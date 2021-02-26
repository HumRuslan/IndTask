<?php
namespace controllers;
use core\BaseController;
use models\TaskModel;
use models\ListModel;

class TaskController extends BaseController
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
        $tasks = TaskModel::find()
                ->where(['list_id' => $_GET['list_id']])
                ->orderBy(['position' => 'DESC',
                           'name' => 'ASC'])
                ->all();
        $list = ListModel::find()
                ->where(['id' => $_GET['list_id']])
                ->one();
        $this->render('index', ['tasks' => $tasks, 'list' => $list]);
        $this->render('index');
    }

    public function createAction()
    {
        $model = new TaskModel;
        if ($model->loadPost()) {
            
            $model->user_id = $_SESSION['auth'];
            if ($model->validate()) {
                if ($model->save()){
                    $_SESSION['success'] = 'record save';
                } else {
                    $_SESSION['error'] = 'error save DB';
                }
                $_SESSION['error'] = 'error save DB';
                $this->redirect("/task/index?list_id=$model->list_id");
            }
        }
        $model->list_id = $_GET['list_id'];
        $this->render('create', ['model' => $model]);
    }

    public function editAction()
    {
        $model = new TaskModel;
        $task = TaskModel::find()
                        ->where(['id' => $_GET['id']])
                        ->one();
        foreach ($task as $key => $value){
            $model->{$key} = $value;
        }
        $list_id = $task->list_id;
        if ($model->loadPost() && $model->validate()){
            if (isset($_POST['completed'])) {
                $model->completed = true;
                $model->completed_at = date('Y-m-d h:i:s');
            } else {
                $model->completed_at = null;
                $model->completed = false;
            }
            if ($model->update(['id' => $task->id])){
                $_SESSION['success'] = 'record save';
            } else {
                $_SESSION['error'] = 'error save DB';
            }
            $this->redirect("/task/index?list_id=$list_id");
        }
        $this->render('edit', ['model' => $model]);
    }

    public function deleteAction()
    {
        $task = TaskModel::find()
                        ->where(['id' => $_GET['id']])
                        ->one();
        $list_id = $task->list_id;                
        TaskModel::delete(['id' => $_GET['id']]);
        $this->redirect("/task/index?list_id=$list_id");
    }

    public function completedAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $model = new TaskModel;
            $task = TaskModel::find()
                            ->where(['id' => $_POST['id']])
                            ->one();
            foreach ($task as $key => $value){
                $model->{$key} = $value;
            }
            if ($_POST['completed'] == "true") {
                $model->completed = true;
                $model->completed_at = date('Y-m-d h:i:s');
            } else {
                $model->completed_at = null;
                $model->completed = false;
            }
            if ($model->update(['id' => $task->id])){
                echo json_encode(['status' => 'success', 'data' => $model, 'post' => $_POST['completed']]);
            } else {
                echo json_encode(['status' => 'error']);
            }
        }
    }

    public function positionUpAction()
    {
        $model = new TaskModel;
        $task = TaskModel::find()
                        ->where(['id' => $_GET['id']])
                        ->one();
        foreach ($task as $key => $value){
            $model->{$key} = $value;
        }
        $model->position++;
        $list_id = $task->list_id;
        $model->update(['id' => $task->id]);
        $this->redirect("/task/index?list_id=$list_id");
    }

    public function positionDownAction()
    {
        $model = new TaskModel;
        $task = TaskModel::find()
                        ->where(['id' => $_GET['id']])
                        ->one();
        $list_id = $task->list_id;
        if ($task->position > 1) {
            foreach ($task as $key => $value){
                $model->{$key} = $value;
            }
            $model->position--;
            $model->update(['id' => $task->id]);
        }
        $this->redirect("/task/index?list_id=$list_id");
    }
}