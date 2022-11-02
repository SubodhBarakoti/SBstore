<?php 
    include '/xampp/htdocs/SBstore/includes/header.php';
    include_once '../connection/connection.php';



    function already_in_cart($product_id,$customer_id,$db_con){
        $query1='SELECT * FROM cart WHERE product_id="'.$product_id.'" AND customer_id ="'.$customer_id.'"';
        if(mysqli_num_rows(mysqli_query($db_con,$query1))>0){
            return true;
        }
        else{return false;}
    }

    if(isset($_POST['addtocart'])){
        $quantity=$_POST['quantity'];
        $product_id=$_POST['product_id'];
        if(empty($_SESSION['customer_id'])){
            header('location:../customer/customerlogin.php');
        }
        else{
            $customer_id=$_SESSION['customer_id'];
            $query1='SELECT * FROM cart WHERE product_id="'.$product_id.'" AND customer_id ="'.$customer_id.'"';
            if(mysqli_num_rows($result1=mysqli_query($db_con,$query1))>0){
                $row=mysqli_fetch_array($result1);
                $sql = 'UPDATE cart SET quantity="'.$quantity.'" WHERE cart_id="'.$row['cart_id'].'"';
                $result=mysqli_query($db_con,$sql);
                if($result){
                    $_SESSION['already_in_cart']=true;
                    header('location:cart.php');
                }
            }
            else{
                $sql = 'INSERT INTO cart(customer_id,product_id,quantity) VALUES("'.$customer_id.'","'.$product_id.'","'.$quantity.'")';
                $result=mysqli_query($db_con,$sql);
                if($result){
                    header('location:cart.php');
                }   
            }
        }
        
    }


    if(isset($_POST['buynow'])){
        $quantity=$_POST['quantity'];
        $product_id=$_POST['product_id'];
        if(empty($_SESSION['customer_id'])){
            header('location:../customer/customerlogin.php');
        }
        else{
            $customer_id=$_SESSION['customer_id'];
            $query1='SELECT * FROM cart WHERE product_id="'.$product_id.'" AND customer_id ="'.$customer_id.'"';
            if(mysqli_num_rows($result1=mysqli_query($db_con,$query1))>0){
                $row=mysqli_fetch_array($result1);
                $sql = 'UPDATE cart SET quantity="'.$quantity.'" WHERE cart_id="'.$row['cart_id'].'"';
                $result=mysqli_query($db_con,$sql);
                if($result){
                    $_SESSION['cart_id']=$row['cart_id'];
                    header('location:../order/checkout.php');
                }
            }
            else{
                $sql = 'INSERT INTO cart(customer_id,product_id,quantity) VALUES("'.$customer_id.'","'.$product_id.'","'.$quantity.'")';
                $result=mysqli_query($db_con,$sql);
                if($result){
                    $cart_id = mysqli_insert_id($db_con);
                    $_SESSION['cart_id']=$cart_id;
                    header('location:../order/checkout.php');
                } 
            }
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
        <div id="categorylist">
            <h2>Category</h2>
            <?php
                $query="SELECT * FROM category";
                $result = mysqli_query($db_con,$query);
                if($result){
                    foreach($result as $row){
                        ?>
                            <p onclick=location.href="products.php?category_id=<?=$row['category_id'] ?>"><?= $row['category_name'] ?></p>
                        <?php
                    }
                }
                else{
                    die("Error: " . mysqli_error($db_con));
                }
            ?>
        </div>
            
        <?php
            if(isset($_GET['product_id'])){
                $product_id=$_GET['product_id'];
                $sql = 'SELECT * FROM product Where product_id = "'.$product_id.'"';
                $result=mysqli_query($db_con,$sql);
                if($result){
                    $product=mysqli_fetch_array($result);
        ?>
            <div id="productdescription">
                    <div id="imagebox">
                        <img src="../images/product/<?= $product['product_image']?>" alt="<?= $product['product_name']?>">
                    </div>


                    <div id="descriptionbox">
                        
                        <p style="font-size: 3em; font-weight: 600; color:orange;"><?= $product['product_name']?></p>
                        <p style="font-size: 1.25em; font-weight: 300;"><?= $product['product_description']?></p>
                        <p style="font-size: 1.75em; color:rgba(1,119,191,255); font-weight: 450;">Price: Rs.<?= $product['product_price']?></p>
                        <div id="quantity" style="font-size: 1.5em; font-weight: 400;">
                            
                            <form action="individualproduct.php" id="quantityform" method="POST">
                                <input type="hidden" name="product_id" id="product_id" value="<?= $product_id?>">
                                <label>Quantity:</label>
                                <input type="number" name="quantity" id="quantity" value="1" style="width: 3vw;height:3vh; text-align:center;"min="1" max="<?=$product['product_quantity']?>">
                                
                            </form>
                            
                        </div>
                        <div id="order_addtocart">
                            <button id="buynow" type="submit" name="buynow" form="quantityform">Buy Now</button>
                            <button id="addtocart" type="submit" name="addtocart" form="quantityform">Add to Cart</button>
                        </div>
                    </div>

            </div>
        
        <?php
                }
                else{
                    die("Error: " . mysqli_error($db_con));
                }
            }
        ?>



        <recommend style="margin-left: 25vw;margin-top:10vh; font-size:1.8em;">Recommended</recommend>
        <div id="recommended_list">
        
        <?php
            $query4 = 'SELECT * FROM product Where product_name = "'.$product['product_name'].'" AND NOT product_id="'.$product_id.'" ORDER BY  "'.$product['totalproductordered'].'" DESC';
            if($result4= mysqli_query($db_con,$query4)){
                foreach($result4 as $recommendation){

                

        ?>

            <div class="recommended_card" onclick=location.href="/SBstore/products/individualproduct.php?product_id=<?= $recommendation['product_id']?>">
                <div class="recommended_image">
                    <img src="/SBstore/images/product/<?= $recommendation['product_image']?>">
                </div>
                <div class="recommendedproductname">
                    <?= $recommendation['product_description']?>
                </div>
                <div class="recommendedproductprice">
                    <?= $recommendation['product_price']?>
                </div>
            </div>
        <?php
            }
        }
        ?>




            
        </div>

    </main>

    
    <?php include '/xampp/htdocs/SBstore/includes/footer.php';?>
</body>
</html>