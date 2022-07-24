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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <title>Home</title>
</head>
<body>
    <script>
        function chReminder(_obj){
            console.log($(_obj).attr('id'));
            $.ajax({url: "changeReminder/" + $(_obj).attr('id')  + "/" + $(_obj).attr('class'), type: 'PUT', success: function(result){
                if(result == "OK"){
                    if($(_obj).hasClass("reminder")){
                        $(_obj).removeClass("reminder");
                        console.log("k");
                    } else {
                        $(_obj).addClass("reminder");
                        console.log("k");
                    }
                }
                
            }});
            
            };


            function deleteTask(_obj){
            const el = $(_obj).parent().parent();
            console.log(el.attr('id'));
            $.ajax({url: "deleteTask/" + el.attr('id'), type: "DELETE", success: function(result){
                if(result == "OK"){
                    el.remove();
                }
                
            }});
            
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

    <script>
            function openAddTask(_obj){
                console.log("here");
                _obj.classList.toggle("active");
                var content = _obj.nextElementSibling;
                content.classList.toggle("active");
            }
    </script>



    <div class="background">
        <div class="bar">
            <h1 onclick="toTasks()">TASK APP!</h1>
            <?php if($_SESSION["userName"] == 'admin'): ?>
                <button style="font-weight:bold; background-color:rgb(179, 179, 179); border:0px; cursor:pointer; font-size: 15px; text-decoration:underline;" onclick="manageUsers()">Manage Users</button>
            <?php endif; ?>
            <button style="position: relative; left:78%; transform: translate(-50%, 0); font-weight:bold; background-color:rgb(179, 179, 179); border:0px; cursor:pointer; font-size: 15px; text-decoration:underline;" onclick="LogOut()">Sign Out</button>
        </div>

        <div class="container">

        <div class="add-task">
        <button class="collapsible">Open Collapsible</button>
            <div class="content">
                <?php if (isset($_SESSION['noTitle'])) : ?>
                    <div class="alert alert-dismissible alert-danger">
                        Task must have a title!
                    </div>
                <?php endif; ?>
                <form method="POST" action='addTask'>
                    <input type="hidden" name="uid" value="<?php echo $_SESSION["userId"] ?>">
                    <div>
                    <div>
                        <label for="title">Title:</label>
                        <input type="title" class="form-control" name="title" value="" placeholder="Title">
                    </div>
                    <div>
                        <label for="date">Date:</label>
                        <input type="text" class="form-control" name="date" value="" placeholder="Date">
                    </div>
                    <div>
                        <label for="address">Address:</label>
                        <input type="text" class="form-control" name="address" value="" placeholder="Address">
                    </div>
                    <div>
                        <label for="reminder">Reminder:</label>
                        <input type="checkbox" name="reminder" value="" placeholder="Reminder">
                    </div>
                    <div>
                        <input type="submit" class="btn btn-primary" name="submit" style="width: 100%; margin-top: 5px">
                    </div>
                    </div>
                </form>
            </div>
        </div>

            <div class="tasks-container">
                    <?php foreach($data['tasks'] as $task): ?>
                        <div id=<?php echo $task['id'] ?> class="task <?php if($task['reminder'] == 1) {echo "reminder";}?>" ondblclick="chReminder(this)">
                            <h2><?php echo $task['title']?> <button onclick="deleteTask(this)" style="cursor:pointer; float: right; background-color:  rgb(179, 179, 179); color: red; font-weight: bold; border:0px; font-size:large;">&#10006;</button></h2>
                            <p>Date: <?php echo $task['date']?></p>
                            <p>Address: <?php echo $task['address']?></p>
                        </div>
                    <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        var coll = document.getElementsByClassName("collapsible");
        var i;

        for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.maxHeight){
            content.style.maxHeight = null;
            } else {
            content.style.maxHeight = content.scrollHeight + "px";
            } 
        });
        }
</script>

</body>
</html>

