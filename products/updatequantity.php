<?php 
    include '/xampp/htdocs/SBstore/includes/header.php';
    include_once '../connection/connection.php';
    if(empty($_SESSION['seller_id'])){
        header('location:/SBstore/seller/sellerlogin.php');
    }
    if(isset($_POST['add'])){
        $product_id=$_POST['product_id'];
        $quantity=$_POST['quantity'];
        $sql = 'UPDATE product SET product_quantity="'.$quantity.'" WHERE product_id="'.$product_id.'"';
        if(mysqli_query($db_con,$sql)){
            header('location:/SBstore/products/productdashboard.php');
        }
        else{
            die("Error: ".mysqli_error($db_con));
        }
    }
    if(isset($_GET['product_id'])){
        $product_id=$_GET['product_id'];
        $seller_id=$_SESSION['seller_id'];
        
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
        <div class="edit_quantity">
            <h1>Update Product Quantity</h1>
            <?php
                $sql='SELECT * FROM product WHERE product_id="'.$product_id.'"';
                if($result = mysqli_query($db_con,$sql)){
                    $product=mysqli_fetch_array($result);
            ?>
            <form action="updatequantity.php" method="POST">
                <input type="hidden" name="product_id" value="<?= $product_id?>">
                <input type="number" name="quantity" id="quantity" min="1" placeholder="Quantity" value="<?=$product['product_quantity']?>">
                <input type="submit" value="Add" name="add">
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