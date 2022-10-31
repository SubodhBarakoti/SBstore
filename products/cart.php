<?php 
    include '/xampp/htdocs/SBstore/includes/header.php';
    include_once '../connection/connection.php';
    if(empty($_SESSION['customer_id'])){
        header('location:/SBstore/customer/customerlogin.php');
    }
    if(isset($_POST['delete_Cart'])){
        $cart_id=$_POST['cart_id'];
        $sql='DELETE FROM cart WHERE cart_id="'.$cart_id.'"';
        $result=mysqli_query($db_con,$sql);
        if(!$result){
            die("Error: ".mysqli_error($db_con));
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <main>
        <div id="cart_div">
            <br><h1 style="color:Green;">&emsp;&emsp;&ensp;My Cart</h1>
            <table>
                <tr>
                    <th>S No.</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>

                <?php
                    $customer_id=$_SESSION['customer_id'];
                    $query="SELECT * FROM cart WHERE customer_id = '".$customer_id."'";
                    $result = mysqli_query($db_con,$query);
                    if($result){
                        $sn=1;
                        $sum=0;
                        foreach($result as $row){
                            $product_id=$row['product_id'];
                            $sql = 'SELECT * FROM product WHERE product_id = "'.$product_id.'"';
                            $result5=mysqli_query($db_con,$sql);
                            if($result5){
                                while($product = mysqli_fetch_array($result5)){
                                    $sum=$sum+$product['product_price']*$row['quantity'];
                ?>

                <tr>
                    <td><?= $sn++; ?></td>
                    <td><?= $product['product_name']?></td>
                    <td>Rs. <?= $product['product_price']?></td>
                    <td><?= $row['quantity']?></td>
                    <td style="color: rgba(1,119,191,255);">Rs. <?= $product['product_price']* $row['quantity']?></td>
                    <td class="cart_crud">

                        <form action="cart.php" method="post">
                            <input type="hidden" name="cart_id" value="<?= $row['cart_id']?>">
                            <button name="delete_Cart" type="submit">Delete</button>
                        </form>
                        
                        <form action="editcart.php" method="post">
                            <input type="hidden" name="cart_id" value="<?= $row['cart_id']?>">
                            <button name="edit_cart" type="submit">Edit</button>
                        </form>


                        <form action="/SBstore/order/checkout.php" method="post">
                            <input type="hidden" name="cart_id" value="<?= $row['cart_id']?>">
                            <button name="user_checkout" type="submit">Checkout</button>
                        </form>
                        
                    </td>
                </tr>
                <?php
                                }
                            }
                        }
                        ?>
                            <tr>
                                <td colspan="4">Total</td>
                                <td>Rs. <?=$sum;?></td>
                            </tr>
                        <?php

                        
                    }
                    
                ?>

            </table>
        </div>
    </main>

    
    <?php include '/xampp/htdocs/SBstore/includes/footer.php';?>
</body>
</html>