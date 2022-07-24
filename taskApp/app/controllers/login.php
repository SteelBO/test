<?php
if(!isset($_SESSION)){
    session_start();
}


class Login extends Controller{

    private $user;

    public function __construct()
    {
        $this->user = $this->model('User');
    }

    public function index($name = ""){

        //$user = $this->model('User');
        //$user->name = $name;

        $this->view('login/index');
        //echo 'hellloooooo thereeee ' . $user->name;
    }

    public function signUp(){
        $this->view('login/signUp');
        session_destroy();
    }


    public function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);
    
        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }

    public function run(){

        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        if ($data['email'] == "" || $data['password'] == ""){
            $_SESSION['wrong'] = 'both';
            header("Location: " . $_SERVER["HTTP_REFERER"]);
            return;
        }

        $this->user->email = htmlspecialchars(strip_tags($data['email']));
        $this->user->password = htmlspecialchars(strip_tags($data['password']));
    
        $u = $this->user->search_by('email');

        echo var_dump($u);
        
        if(count($u) > 0){

            $hash = $u[0]["password"];
            
            $valid = password_verify($this->user->password, $hash);

            if($valid){
                unset($_SESSION['wrong']);
                createUserSession($u[0]);
            }else{
                $_SESSION['wrong'] = 'password';
                header("Location: " . $_SERVER["HTTP_REFERER"]);
            }

        } else {
            $_SESSION['wrong'] = 'email';
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
    }

    public function addUser(){

        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        if ($data['name'] == "" || $data['email'] == "" || $data['password'] == ""){
            $_SESSION['noAttr'] = 'true';
            header("Location: " . $_SERVER["HTTP_REFERER"]);
            return;
        }

        $this->user->name = htmlspecialchars(strip_tags($data['name']));
        $this->user->email = htmlspecialchars(strip_tags($data['email']));
        $this->user->password = htmlspecialchars(strip_tags($data['password']));
        $this->user->password = password_hash($this->user->password, PASSWORD_DEFAULT);
        if(isset($this->user->search_by('email')[0]['email'])){
            $_SESSION['exist'] = 'true';
            header("Location: " . $_SERVER["HTTP_REFERER"]);
            return;
        }

        if($this->user->create_user()){
            echo "OK";
        }
        $_SESSION['created'] = "true";
        header("Location: ../login");
    }

}

function createUserSession($user){
    if(!isset($_SESSION)){
        session_start();
    }
    $_SESSION['userId'] = $user['id'];
    $_SESSION['userName'] = $user['name'];
    $_SESSION['userEmail'] = $user['email'];
    header("Location: ../home/index");
}