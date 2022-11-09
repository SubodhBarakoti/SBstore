<?php include '/xampp/htdocs/SBstore/includes/header.php';?>
<?php
    include_once '../connection/connection.php';
    if(isset($_POST['register'])){
        $customer_name = $_POST['customer_name'];
        $customer_email = $_POST['customer_email'];
        $customer_password = $_POST['customer_password'];
        $confirmPassword = $_POST['confirmPassword'];
        $customer_contact = $_POST['customer_contact'];
        $customer_dob = $_POST['customer_dob'];
        $customer_address = $_POST['customer_address'];
        
        if($customer_password == $confirmPassword){
            if(!empty($customer_name) && !empty($customer_email) && !empty($customer_password) && !empty($customer_contact) && !empty($customer_dob) && !empty($customer_address) && filter_var($customer_email, FILTER_VALIDATE_EMAIL)){
                $query3 = "SELECT * FROM customer WHERE customer_email = '$customer_email' OR customer_contact = '$customer_contact'";
                $result3 = mysqli_query($db_con,$query3);
                if($result3){
                    if(mysqli_num_rows($result3)>0){
                        echo 'Given credentials already used.';
                    }
                    else{
                            $query = "INSERT INTO customer(customer_name,customer_email,customer_password,customer_contact,customer_dob,customer_address) 
                            VALUES ('$customer_name','$customer_email','$customer_password','$customer_contact','$customer_dob','$customer_address')";
                            $result = mysqli_query($db_con,$query);
                            if($result){
                                $query2="SELECT * FROM customer WHERE customer_email = '$customer_email' AND customer_password = '$customer_password'";
                                $result2 = mysqli_query($db_con,$query2);
                                if($result2){
                                    if(mysqli_num_rows($result2)>0){
                                        $row = mysqli_fetch_array($result2);
                                        $_SESSION['customer_id']=$row['customer_id'];
                                        header('location:../index.php');
                                    }
                                    else{
                                        echo "Error: ".mysqli_error($db_con);
                                    }
                                }
                                else{
                                    echo "Error: ".mysqli_error($db_con);
                                }
                            }
                            else{
                                echo "Error: ".mysqli_error($db_con);
                            }
                    }
                }
                else{
                    echo "Error: ".mysqli_error($db_con);
                }
            }
            else{
                echo"Empty field or Invalid email format";
            }
        }
        else{
            echo"Password did not match";
        }
            
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>


    <main>
        <div id="customerregister_form">
            <h2>Create an Account</h2>
            <form action="customerregistration.php" method="POST">
                <input type="text" id="customer_name" name="customer_name" placeholder="Customer Name"><br>
                <input type="email" name="customer_email" id="customer_email" placeholder="Email"><br>
                <input type="password" name="customer_password" id="customer_password" placeholder="Password"><br>
                <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password">
                <input type="text" name="customer_contact" id="customer_contact" placeholder="Phone Number"><br>
                <label for="customer_dob">Enter your Date of Birth:</label><br>
                <input type="date" name="customer_dob" id="customer_dob"><br>
                <input type="text" id="customer_address" name="customer_address" placeholder="Address"><br>
                <input type="submit" name="register" value="Create Account"><br>
                <p style="float: right;">Already have an account, Login <a href="customerlogin.php">here!</a></p>
            </form>
        </div>

    </main>

    
    <?php include '/xampp/htdocs/SBstore/includes/footer.php';?>
</body>
</html>