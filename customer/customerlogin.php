<?php include '/xampp/htdocs/SBstore/includes/header.php';?>
<?php
    include_once '../connection/connection.php';
    if(isset($_POST['login'])){
        $email = $_POST['customer_email'];
        $password = $_POST['customer_password'];
       if(!empty($email) && !empty($password) && filter_var($email, FILTER_VALIDATE_EMAIL)){
        $query = 'SELECT * FROM customer WHERE customer_email = "'.$email.'" AND customer_password = "'.$password.'"';
        $result = mysqli_query($db_con,$query);
        if($result){
            if(mysqli_num_rows($result)>0){
                $row = mysqli_fetch_array($result);
                $_SESSION['customer_id']=$row['customer_id'];
                
                header('location:../index.php');
            }
            else{
                echo 'incorrect passord or username';
            }
        }
        else{
            echo "Error ".mysqli_error($db_con);;
        }
       }
       else{
        echo "Error: Empty field or Invalid Email";
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
        <div id="customerregister_form">
            <h2>Login</h2>
            <form action="customerlogin.php" method="POST">
                <input type="text" name="customer_email" id="customer_email" placeholder="Email"><br>
                <input type="password" name="customer_password" id="customer_password" placeholder="Password"><br>
                <input type="submit" value="Login" name="login">
            </form>
            <p>Don't have an account, Create Account <a href="customerregistration.php">here!</a></p>
        </div>
    </main>
    <?php include '/xampp/htdocs/SBstore/includes/footer.php';?>
</body>
</html>