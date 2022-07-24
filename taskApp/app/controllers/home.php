<?php

if(!isset($_SESSION)){
    session_start();
}

class Home extends Controller{

    public $user;

    public function index($name = ""){
        //echo $_SESSION['userId'];
        if(!isset($_SESSION['userId'])){ 
            header("Location: login");
            return;
        } 

        $this->setUser();


        //echo "id" . $user->id;        

        $tasks = $this->user->fetch_tasks();
        
        //echo var_dump($tasks);

        $this->view('home/index', ['tasks' => $tasks]);
    }

    public function setUser(){
        $this->user = $this->model('User');
        $this->user->name = $_SESSION["userName"];
        $this->user->email = $_SESSION["userEmail"];
        $this->user->id = $_SESSION["userId"];
    }

    public function changeReminder($id, $class){
        $task = $this->model('Task');
        $task->id = $id;
        if(str_contains($class, 'reminder')){
            $task->reminder = '0';
        } else {
            $task->reminder = '1';
        }
        if($task->changeReminder()){
            echo "OK";
        }
    }

    public function deleteTask($id){
        $task = $this->model('Task');
        $task->id = $id;
        if($task->deleteTask()){
            echo "OK";
        }
    }

    public function deleteUser($id){
        $u = $this->model('user');
        $u->id = $id;
        if($u->delete_user()){
            echo "OK";
        }
    }

    public function logOut(){
        session_destroy();
        header("Location: ../login/index");
        echo $_SESSION["userId"];
    }

    public function users(){
        $this->setUser();
        $data = $this->user->fetch_all();
        $this->view("home/users", $data);
    }

    public function addTask(){
        echo "here";
        $task = $this->model('Task');

        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        echo var_dump($data);
        if ($data['title'] == ""){
            $_SESSION['noTitle'] = 'both';
            header("Location: " . $_SERVER["HTTP_REFERER"]);
            return;
        }

        $task->title = htmlspecialchars(strip_tags($data['title']));
        $task->date = htmlspecialchars(strip_tags($data['date']));
        $task->address = htmlspecialchars(strip_tags($data['address']));
        if(isset($data['reminder'])){
            $task->reminder = '1';
        } else {
            $task->reminder = '0';
        }

        if($task->create_task($data['uid'])){
            echo "OK";
        }
        header("Location: ../home/index");
    }
}

function getUserSession($user){
    $_SESSION['userId'] = $user->usersId;
    $_SESSION['userName'] = $user->usersName;
    $_SESSION['userEmail'] = $user->usersEmail;
    session_destroy();
    header("Location: ../home/index");
}