<?php 
    include '/xampp/htdocs/SBstore/includes/header.php';
    include_once '../connection/connection.php';
    if(empty($_SESSION['seller_id'])){
        header('location:/SBstore/seller/sellerlogin.php');
    }
    if(isset($_POST['deliver'])){
        $status=$_POST['status']+1;
        $order_id=$_POST['order_id'];
        $sql='UPDATE orders SET status="'.$status.'" WHERE order_id="'.$order_id.'"';
        $result=mysqli_query($db_con,$sql);
        if(!$result){
            echo "Error: ".mysqli_error($db_con);
        }
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
            $seller_id=$_SESSION['seller_id'];
            $sql='SELECT * FROM seller WHERE seller_id="'.$seller_id.'"';
            if($result=mysqli_query($db_con,$sql)){
                while($seller=mysqli_fetch_array($result)){
            
        ?>
        <div class="profile">
            <h2 style="color:green;">Profile Information</h2>
            <span class="user_info">Name: </span><span class="info_value"><?= $seller['seller_name']?></span><br>
            <span class="user_info">Email: </span><span class="info_value"><?= $seller['seller_email']?></span><br>
            <span class="user_info">Address: </span><span class="info_value"><?= $seller['seller_address']?></span><br>
            <span class="user_info">Contact: </span><span class="info_value"><?= $seller['seller_contact']?></span><br>
            <span class="user_info">Account Number: </span><span class="info_value"><?= $seller['seller_bank_account_no']?></span><br>
            <button class="update" onclick=location.href="/Sbstore/seller/updateseller.php">Change Password and Info</button>
        </div>
        <?php
                }
            }
            else{
                echo 'Error: '.mysqli_error($db_con);
            }
        ?>


            <div class="go_product_dashboard">
                <button onclick=location.href="/Sbstore/products/productdashboard.php">See Product List</button>
            </div>







        <div class="customerorder">
            <table style="margin-left: 10vw;">
                <h1 style="margin:5vh auto auto 10vw; color:green;">Order List</h1>
                <tr>
                    <th>S No.</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Customer Name</th>
                    <th>Contact Info</th>
                    <th>Delivery Location</th>
                    <th>Status</th>
                    <th>Choose Action</th>
                </tr>
                <?php
                    $seller_id=$_SESSION['seller_id'];
                    $sql='SELECT * FROM orders WHERE seller_id="'.$seller_id.'"';
                    $sn=0   ;
                    if($result=mysqli_query($db_con,$sql)){
                        foreach($result as $row){
                            $sn++;
                            $sql='SELECT product_name FROM product WHERE product_id="'.$row['product_id'].'"';
                            if($result2=mysqli_query($db_con,$sql)){
                                $product_name=mysqli_fetch_array($result2);
                                if($row['status']==0){
                                    $delivery_satus="Ordered";
                                    $button_status="Deliver Package";
                                }
                                elseif($row['status']==1){
                                    $delivery_satus="Delivering";
                                    $button_status="Delivered";
                                }
                                else{
                                    $delivery_satus="Delivered";
                                }

                                
                ?>
                <tr>
                    <td><?= $sn?></td>
                    <td style="cursor:pointer;" onclick=location.href="/Sbstore/products/individualproduct.php?product_id=<?=$row['product_id'] ?>">
                    <?= $product_name['product_name']?></td>

                    <td><?= $row['quantity']?></td>
                    <td>Rs. <?= $row['amount']?></td>
                    <td><?= $row['customers_name']?></td>
                    <td><?= $row['contact_info']?></td>
                    <td><?= $row['delivery_address']?></td>
                    <td><?=$delivery_satus?></td>
                    <td>
                        <?php
                            if($row['status']==0){ ?>
                                <form action="sellerdashboard.php" method="POST">
                                    <input type="hidden" name="status" value="<?=$row['status']?>">
                                    <input type="hidden" name="order_id" value="<?=$row['order_id']?>">
                                    <input type="submit" value="<?= $button_status?>" name="deliver" class="status_button">
                                </form>
                        <?php }
                            elseif($row['status']==1){?>
                                <form action="sellerdashboard.php" method="POST">
                                    <input type="hidden" name="status" value="<?=$row['status']?>">
                                    <input type="hidden" name="order_id" value="<?=$row['order_id']?>">
                                    <input type="submit" value="<?= $button_status?>" name="deliver" class="status_button">
                                </form>
                            <?php  
                            }
                            else{
                        ?>
                            <b style="color:#5eb85a;">Done</b>
                        <?php  
                            }
                        ?>
                    </td>

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