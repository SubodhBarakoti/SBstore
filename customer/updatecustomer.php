<?php 
    include '/xampp/htdocs/SBstore/includes/header.php';
    include_once '../connection/connection.php';
    if(empty($_SESSION['customer_id'])){
        header('location:/SBstore/customer/customer.php');
    }
    if(isset($_POST['update'])){
        $customer_id=$_SESSION['customer_id'];
        $customer_name = $_POST['customer_name'];
        $customer_email = $_POST['customer_email'];
        $customer_password = $_POST['customer_password'];
        $confirmPassword = $_POST['confirmPassword'];
        $customer_contact = $_POST['customer_contact'];
        $customer_dob = $_POST['customer_dob'];
        $customer_address = $_POST['customer_address'];
        
        if($customer_password == $confirmPassword){
            if(!empty($customer_name) && !empty($customer_email) && !empty($customer_password) && !empty($customer_contact) && !empty($customer_dob) && !empty($customer_address) && filter_var($customer_email, FILTER_VALIDATE_EMAIL)){
                $query3 = "SELECT * FROM customer WHERE (customer_email = '$customer_email' OR customer_contact = '$customer_contact') AND NOT customer_id='$customer_id'";
                $result3 = mysqli_query($db_con,$query3);
                if($result3){
                    if(mysqli_num_rows($result3)>0){
                        echo 'Given credentials already used.';
                    }
                    else{
                            $query = "UPDATE customer SET customer_name='$customer_name',customer_email='$customer_email',customer_password='$customer_password',
                            customer_contact='$customer_contact',customer_dob='$customer_dob',customer_address='$customer_address' WHERE customer_id=$customer_id";
                            if(mysqli_query($db_con,$query)){
                                header('location:/SBstore/customer/customerdashboard.php');
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
            <h2>Update Account</h2>
            <form action="updatecustomer.php" method="POST">
                <?php
                    
                        $customer_id=$_SESSION['customer_id'];
                        $sql='SELECT * FROM customer WHERE customer_id="'.$customer_id.'"';
                        if($result=mysqli_query($db_con,$sql)){
                            while($customer=mysqli_fetch_array($result)){
                    
                ?>
                <input type="hidden" name="customer_id" value="<?=$customer_id?>">
                <input type="text" id="customer_name" name="customer_name" placeholder="Customer Name" value=<?=$customer['customer_name']?>><br>
                <input type="email" name="customer_email" id="customer_email" placeholder="Email" value=<?=$customer['customer_email']?>><br>
                <input type="text" name="customer_contact" id="customer_contact" placeholder="Phone Number" value=<?=$customer['customer_contact']?>><br>
                <label for="customer_dob">Enter your Date of Birth:</label><br>
                <input type="date" name="customer_dob" id="customer_dob" value=<?=$customer['customer_dob']?>><br>
                <input type="text" id="customer_address" name="customer_address" placeholder="Address" value=<?=$customer['customer_address']?>><br>
                <input type="password" name="customer_password" id="customer_password" placeholder="New Password"><br>
                <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password">
                <input type="submit" name="update" value="Update Account"><br>
                
            </form>
            <?php
                        }
                    }
            ?>
        </div>

    </main>

    
    <?php include '/xampp/htdocs/SBstore/includes/footer.php';?>
</body>
</html>