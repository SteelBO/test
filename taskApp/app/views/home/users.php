<?php

if(!isset($_SESSION)){
    session_start();
}

if(!isset($_SESSION['userName'])){
    header("Location: ../login");
} else {
    if($_SESSION['userName'] != 'admin'){
        header("Location: index");
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../../taskApp/public/css/style.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <title>Home</title>
</head>
<body>
    <script>
            function deleteUser(_obj){
                if(confirm('Are you sure you want to delete this user?')){
                    const el = $(_obj).parent().parent();
                    console.log(el.attr('id'));
                    $.ajax({url: "deleteUser/" + el.attr('id'), type: "DELETE", success: function(result){
                        if(result == "OK"){
                            el.remove();
                        }
                        
                    }});
                }
            };

            function LogOut(){
            $.ajax({url: "logOut", success: function(result){
                window.location.href = "../login";
            }});
            
            };

            function manageUsers(){
                window.location.href = "users";
            }

            function toTasks(){
                window.location.href = "index";
            }
    
    </script>



    <div class="background">
        <div class="bar">
            <h1 onclick="toTasks()">TASK APP!</h1>
            <?php if($_SESSION["userName"] == 'admin'): ?>
                <button style="float: right; font-weight:bold; background-color:rgb(179, 179, 179); border:0px; cursor:pointer; font-size: 15px; text-decoration:underline;" onclick="manageUsers()">Manage Users</button>
            <?php endif; ?>
            <button style="position: relative; left:78%; transform: translate(-50%, 0); font-weight:bold; background-color:rgb(179, 179, 179); border:0px; cursor:pointer; font-size: 15px; text-decoration:underline;" onclick="LogOut()">Sign Out</button>
        </div>

        <div class="container">

            <div class="tasks-container">
                    <?php foreach($data as $user): ?>
                        <div id=<?php echo $user['id']; ?> class="task">
                            <h2><?php echo $user['name']?> <button onclick="deleteUser(this)" style="cursor:pointer; float: right; background-color:  rgb(179, 179, 179); color: red; font-weight: bold; border:0px; font-size:large;">&#10006;</button></h2>
                            <p>Email: <?php echo $user['email']?></p>
                        </div>
                    <?php endforeach; ?>
            </div>
        </div>
    </div>

</body>
</html>

