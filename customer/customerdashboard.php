<?php 
    include '/xampp/htdocs/SBstore/includes/header.php';
    include_once '../connection/connection.php';
    if(empty($_SESSION['customer_id'])){
        header('location:/SBstore/customer/customerlogin.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <main>
        <?php
            $customer_id=$_SESSION['customer_id'];
            $sql='SELECT * FROM customer WHERE customer_id="'.$customer_id.'"';
            if($result=mysqli_query($db_con,$sql)){
                while($customer=mysqli_fetch_array($result)){
            
        ?>
        <div class="profile">
            <h2 style="color:green;">Profile Information</h2>
            <span class="customer_info">Name: </span><span class="info_value"><?= $customer['customer_name']?></span><br>
            <span class="customer_info">Email: </span><span class="info_value"><?= $customer['customer_email']?></span><br>
            <span class="customer_info">Address: </span><span class="info_value"><?= $customer['customer_address']?></span><br>
            <span class="customer_info">Contact: </span><span class="info_value"><?= $customer['customer_contact']?></span><br>
            <button class="update" onclick=location.href="/Sbstore/customer/updatecustomer.php">Change Password and Info</button>
        </div>
        <?php
                }
            }
            else{
                echo 'Error: '.mysqli_error($db_con);
            }
        ?>
        <div class="customerorder">
            <table style="margin-left: 25vw;">
                <h1 style="margin:5vh auto auto 25vw; color:green;">Order History</h1>
                <tr>
                    <th>S No.</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Delivery Location</th>
                    <th>Status</th>
                </tr>
                <?php
                    $customer_id=$_SESSION['customer_id'];
                    $sql='SELECT * FROM orders WHERE customer_id="'.$customer_id.'"';
                    $sn=0   ;
                    if($result=mysqli_query($db_con,$sql)){
                        foreach($result as $row){
                            $sn++;
                            $sql='SELECT product_name FROM product WHERE product_id="'.$row['product_id'].'" LIMIT 1';
                            if($result2=mysqli_query($db_con,$sql)){
                                $product_name=mysqli_fetch_array($result2);
                                if($row['status']==0){
                                    $delivery_satus="Ordered";
                                    $color='black';
                                }
                                elseif($row['status']==1){
                                    $delivery_satus="Delivering";
                                    $color='orange';
                                }
                                else{
                                    $delivery_satus="Delivered";
                                    $color='#5eb857';
                                }

                                
                ?>
                <tr>
                    <td><?= $sn?></td>
                    <td style="cursor:pointer;" onclick=location.href="/Sbstore/products/individualproduct.php?product_id=<?=$row['product_id'] ?>">
                    <?= $product_name['product_name']?></td>

                    <td><?= $row['quantity']?></td>
                    <td>Rs. <?= $row['amount']?></td>
                    <td><?= $row['delivery_address']?></td>
                    <td style="color:<?=$color?>;"><?=$delivery_satus?></td>
                </tr>
                <?php
                            }
                        }
                    }
                    else{
                        echo 'Error: '.mysqli_error($db_con);
                    }
                ?>
            </table>
        </div>
    </main>

    
    <?php include '/xampp/htdocs/SBstore/includes/footer.php';?>
</body>
</html>