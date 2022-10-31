<?php 
    include '/xampp/htdocs/SBstore/includes/header.php';
    include_once '../connection/connection.php';
    if(empty($_SESSION['customer_id'])){
        header('location:../customer/customerlogin.php');
    }

    if(isset($_POST['updatecart'])){
        $quantity=$_POST['quantity'];
        $cart_id=$_POST['cart_id'];
        $sql = 'UPDATE cart SET quantity="'.$quantity.'" WHERE cart_id="'.$cart_id.'"';
        $result=mysqli_query($db_con,$sql);
        if($result){
            header('location:cart.php');
        }
    }
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    


    <main>
            
        <?php
            if(isset($_POST['edit_cart'])){
                $cart_id=$_POST['cart_id'];
                $sql = 'SELECT * FROM cart Where cart_id = "'.$cart_id.'"';
                $result=mysqli_query($db_con,$sql);
                if($result){
                    $product1=mysqli_fetch_array($result);
                    $product_id=$product1['product_id'];
                    $sql = 'SELECT * FROM product WHERE product_id = "'.$product_id.'"';
                    $result5=mysqli_query($db_con,$sql);
                    if($result5){
                        while($product = mysqli_fetch_array($result5)){
                        
        ?>
            <div id="productdescription">
                    <div id="imagebox">
                        <img src="../images/product/<?= $product['product_image']?>" alt="<?= $product['product_name']?>">
                    </div>


                    <div id="descriptionbox">
                        
                        <p style="font-size: 3em; font-weight: 600; color:orange;"><?= $product['product_name']?></p>
                        <p style="font-size: 1.25em; font-weight: 300;"><?= $product['product_description']?></p>
                        <p style="font-size: 1.75em; color:rgba(1,119,191,255); font-weight: 450;">Price: <?= $product['product_price']?></p>
                        <div id="quantity" style="font-size: 1.5em; font-weight: 400;">
                            
                            <form action="editcart.php" id="quantityform" method="POST">
                                <input type="hidden" name="cart_id" id="cart_id" value="<?= $cart_id?>">
                                <label>Quantity:</label>
                                <input type="number" name="quantity" id="quantity" value="<?= $product1['quantity']?>" style="width: 3vw;height:3vh; text-align:center;"min="1" max="<?=$product['product_quantity']?>">
                                
                            </form>
                            
                        </div>
                        <div id="order_addtocart">
                            <button id="updatecart" type="submit" name="updatecart" form="quantityform">Update Cart</button>
                        </div>
                    </div>

            </div>
        
        <?php
                        }
                    }
                }
                else{
                    die("Error: " . mysqli_error($db_con));
                }
            }
        ?>

    </main>

    
    <?php include '/xampp/htdocs/SBstore/includes/footer.php';?>
</body>
</html>