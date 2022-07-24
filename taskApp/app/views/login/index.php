<?php
if(!isset($_SESSION)){
    session_start();
    $_SESSION['wrong'] = '';
} /*else{
    session_destroy();
}*/
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <link rel="stylesheet" href="../../../../taskApp/public/css/style.css">
    <title>Login</title>
</head>
<body>
    <script>
        function signUp(){
            window.location.href="login/addUser";
        }
    </script>
    <div class="background">
    
<div class="container">
            <?php if (isset($_SESSION['wrong']) && $_SESSION['wrong'] != '') : ?>
                <div class="alert alert-dismissible alert-danger">
                    <?php if ($_SESSION['wrong'] == 'email') : ?>
                        <strong>Wrong credentials!</strong> This email is not registered! Please check and try submitting again.
                    <?php elseif ($_SESSION['wrong'] == 'password') : ?>
                        <strong>Wrong Password!</strong> Please check and try submitting again.
                    <?php elseif ($_SESSION['wrong'] == 'both') : ?>
                        Please fill in all the fields and try submitting again.
                    <?php endif; ?>
                </div>
            <?php elseif(isset($_SESSION['created'])): ?>
                <div class="alert alert-dismissible alert-success">
                        User Created!
                </div>
            <?php endif; ?>
            <form class="form-style" method="POST" action='login/run'>
                <div class="form-inside">
                <div class="form-part">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="email" value="" placeholder="Email">
                </div>
                <div class="form-part">
                    <label for="password">Password:</label>
                    <input type="text" class="form-control" name="password" value="" placeholder="Password">
                </div>
                <div class="form-part">
                    <input type="submit" class="btn btn-primary" name="submit" style="width: 100%; margin-top: 5px">
                </div>
                </div>
                <a href="login/signUp" style="margin-left: 45%; transform: translate(-50%, 0); font-weight:bold; border:0px; cursor:pointer; font-size: 15px; background-color:transparent; text-decoration:underline;">Sign Up</button>
            </form>

        </div>
    </div>
    </body>
</html>


