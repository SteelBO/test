<?php
if(!isset($_SESSION)){
    session_start();
} 
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
    <div class="background">
        <div class="container">
                <?php if (isset($_SESSION['noAttr'])) : ?>
                    <div class="alert alert-dismissible alert-danger">
                            Please fill in all the fields and try submitting again.
                    </div>
                <?php elseif(isset($_SESSION["exist"])): ?>
                    <div class="alert alert-dismissible alert-danger">
                            User already exists!
                    </div>
                <?php endif; ?>
                <form class="form-style" method="POST" action='addUser'>
                    <div class="form-inside">
                    <div class="form-part">
                        <label for="name">Name:</label>
                        <input type="name" class="form-control" name="name" value="" placeholder="name">
                    </div>
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
                </form>

        </div>
    </div>
    </body>
</html>


