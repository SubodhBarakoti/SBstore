<?php 
    include '/xampp/htdocs/SBstore/includes/header.php';
    include_once '../connection/connection.php';
    if(isset($_POST['login'])){
        $username = $_POST['admin_username'];
        $password = $_POST['admin_password'];
        $query = 'SELECT * FROM admin WHERE admin_username = "'.$username.'" AND admin_password = "'.$password.'"';
        $result = mysqli_query($db_con,$query);
        if($result){
            if(mysqli_num_rows($result)>0){
                $row = mysqli_fetch_array($result);
                $_SESSION['admin_id']=$row['admin_id'];
                
                header('location:admindashboard.php');
            }
            else{
                echo 'incorrect passord or username';
            }
        }
        else{
            echo 'error';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    
    <main>
        <div id="login_form">
            <h2>Admin Login</h2>
            <form action="login.php" method="POST">
                <input type="text" name="admin_username" id="admin_username" placeholder="Username"><br>
                <input type="password" name="admin_password" id="admin_password" placeholder="Password"><br>
                <input type="submit" value="Login" name="login">
            </form>
        </div>
    </main>
    <?php include '/xampp/htdocs/SBstore/includes/footer.php';?>
</body>
</html>