<?php 
    include '/xampp/htdocs/SBstore/includes/header.php';
    include_once '../connection/connection.php';
    if(empty($_SESSION['seller_id'])){
        header('location:/SBstore/seller/sellerlogin.php');
    }
    if(isset($_POST['delete'])){
        $product_id=$_POST['product_id'];
        $sql='DELETE FROM product WHERE product_id="'.$product_id.'"';
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
    <title></title>
    <link rel="stylesheet" href="SBstore/css/style.css">
</head>
<body>



    <main>
            <div class="add_product">
                <button onclick=location.href="/Sbstore/seller/addproduct.php">+ Add Product</button>   
            </div>
        <div class="product_table">
            <table style="margin-left: 10vw;">
                <h1 style="margin:5vh auto auto 10vw; color:green;">Product List</h1>
                <tr>
                    <th>S No.</th>
                    <th>Product</th>
                    <th>Product Name</th>
                    <th>Quantity Left</th>
                    <th>Price </th>
                    <th>Category</th>
                    <th>Total Product Sold</th>
                    
                </tr>
                <?php

                    $seller_id=$_SESSION['seller_id'];
                    $sql='SELECT * FROM product WHERE seller_id="'.$seller_id.'"';
                    $sn=0   ;
                    if($result=mysqli_query($db_con,$sql)){
                        foreach($result as $row){
                            $sn++;
                            $sql='SELECT category_name FROM category WHERE category_id="'.$row['category_id'].'"';
                            if($result2=mysqli_query($db_con,$sql)){
                                $category_name=mysqli_fetch_array($result2);
                                

                                
                ?>
                <tr>
                    <td><?= $sn?></td>
                    <td>
                        <div class="product_cart_image">
                            <img height="100vh" width="100vw" src="/SBstore/images/product/<?=$row['product_image']?>" alt="<?= $row['product_name']?>">
                        </div>
                    </td>
                    <td style="cursor:pointer;" onclick=location.href="/Sbstore/products/individualproduct.php?product_id=<?=$row['product_id'] ?>">
                    <?= $row['product_name']?></td>

                    <td><?= $row['product_quantity']?></td>
                    <td>Rs. <?= $row['product_price']?></td>
                    <td><?=  $category_name['category_name']?></td>
                    <td><?=$row['totalproductordered']?></td>
                    <td>
                        <span class="product_curd">
                            <button onclick=location.href="/SBstore/products/updatequantity.php?product_id=<?= $row['product_id']?>">Edit Quantity</button>
                            <form action="productdashboard.php" method="post">
                                <input type="hidden" name="product_id" value="<?= $row['product_id']?>">
                                <button type="submit" name="delete">Delete</button>
                            </form>
                        </span>
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