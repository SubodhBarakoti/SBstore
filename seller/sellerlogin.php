<?php include '/xampp/htdocs/SBstore/includes/header.php';?>
<?php
    include_once '../connection/connection.php';
    if(isset($_POST['login'])){
        $email = $_POST['seller_email'];
        $password = $_POST['seller_password'];
        if(!empty($email) && !empty($password) && filter_var($email, FILTER_VALIDATE_EMAIL)){
            $query = 'SELECT * FROM seller WHERE seller_email = "'.$email.'" AND seller_password = "'.$password.'"';
            $result = mysqli_query($db_con,$query);
            if($result){
                if(mysqli_num_rows($result)>0){
                    $row = mysqli_fetch_array($result);
                    $_SESSION['seller_id']=$row['seller_id'];
                    header('location:sellerdashboard.php');
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
            echo "Error: Empty fields or Invalid email.";
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
            <h2>Seller Login</h2>
            <form action="sellerlogin.php" method="POST">
                <input type="text" name="seller_email" id="seller_emails" placeholder="Email"><br>
                <input type="password" name="seller_password" id="seller_passwords" placeholder="Password"><br>
                <input type="submit" value="Login" name="login">
            </form>
        </div>
    </main>
    <?php include '/xampp/htdocs/SBstore/includes/footer.php';?>
</body>
</html>