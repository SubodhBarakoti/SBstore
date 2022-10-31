<?php include '/xampp/htdocs/SBstore/includes/header.php';?>
<?php
    include_once '../connection/connection.php';
    if(isset($_POST['register'])){
        $seller_name = $_POST['seller_name'];
        $seller_email = $_POST['seller_email'];
        $seller_password = $_POST['seller_password'];
        $confirmPassword = $_POST['confirmPassword'];
        $seller_contact = $_POST['seller_contact'];
        $seller_citizenshipno = $_POST['seller_citizenshipno'];
        $seller_dob = $_POST['seller_dob'];
        $seller_bank_account_no = $_POST['seller_bank_account_no'];
        $seller_address = $_POST['seller_address'];
        if($seller_password == $confirmPassword){
            if(!empty($seller_name) && !empty($seller_email) && !empty($seller_password) && !empty($seller_contact) && !empty($seller_citizenshipno) && !empty($seller_dob) && !empty($seller_bank_account_no) && !empty($seller_address) && filter_var($seller_email, FILTER_VALIDATE_EMAIL)){
                $query3 = "SELECT * FROM seller WHERE seller_email = '$seller_email' OR seller_contact = '$seller_contact' OR seller_citizenshipno = '$seller_citizenshipno' OR seller_bank_account_no = '$seller_bank_account_no'";
                $result3 = mysqli_query($db_con,$query3);
                if($result3){
                    if(mysqli_num_rows($result3)>0){
                        echo 'Given credentials already used.';
                    }
                    else{
                            $query = "INSERT INTO seller(seller_name,seller_email,seller_password,seller_contact,seller_citizenshipno,seller_dob,seller_bank_account_no,seller_address) 
                            VALUES ('$seller_name','$seller_email','$seller_password','$seller_contact','$seller_citizenshipno','$seller_dob','$seller_bank_account_no','$seller_address')";
                            $result = mysqli_query($db_con,$query);
                            if($result){
                                $query2="SELECT * FROM seller WHERE seller_email = '$seller_email' AND seller_password = '$seller_password'";
                                $result2 = mysqli_query($db_con,$query2);
                                if($result2){
                                    if(mysqli_num_rows($result2)>0){
                                        $row = mysqli_fetch_array($result2);
                                        $_SESSION['seller_id']=$row['seller_id'];
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
    <title>Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    

    <main>
        <div id="sellerregister_form">
            <h2>Register as a Seller</h2>
            <form action="sellerregistration.php" method="POST">
                <input type="text" id="seller_name" name="seller_name" placeholder="Seller Name"><br>
                <input type="email" name="seller_email" id="seller_email" placeholder="Email"><br>
                <input type="password" name="seller_password" id="seller_password" placeholder="Password">
                <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password"><br>
                <input type="text" name="seller_contact" id="seller_contact" placeholder="Phone Number">
                <input type="text" name="seller_citizenshipno" id="seller_citizenshipno" placeholder="Citizenship Number"><br>
                <label for="seller_dob">Enter your Date of Birth:</label><br>
                <input type="date" name="seller_dob" id="seller_dob"><br>
                <input type="text" id="seller_bank_account_no" name="seller_bank_account_no" placeholder="Bank Account Number"><br>
                <input type="text" id="seller_address" name="seller_address" placeholder="Address"><br>
                <input type="submit" name="register" value="Register as Seller"><br>
                <p style="float: right;">Already a registered Seller, Login <a href="sellerlogin.php">here!</a></p>
            </form>
        </div>

    </main>

    
    <?php include '/xampp/htdocs/SBstore/includes/footer.php';?>
</body>
</html>