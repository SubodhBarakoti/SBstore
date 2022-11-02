<?php 
    include '/xampp/htdocs/SBstore/includes/header.php';
    include_once '../connection/connection.php';
    if(empty($_SESSION['admin_id'])){
        header('location:/SBstore/admin/login.php');
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
        <div class="heading">
            <h1 style="margin: 5vh 5vw; color:#5eb85a;">Product table</h1>
        </div>
        <div class="admin_table">
            <table>
                <tr>
                    <th>Sn</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price Per Piece</th>
                    <th>Remaining Quantity</th>
                    <th>Total Order</th>
                    <th>Seller</th>
                    <th>Category</th>
                </tr>
                <?php
                    
                    $sql = 'SELECT * FROM product';
                    if($result = mysqli_query($db_con,$sql)){
                        $sn=0;
                        foreach($result as $row){
                            $sn++;
                            // $query1='SELECT customer_name FROM customer WHERE customer_id="'.$row['customer_id'].'"';
                            // $customer_name=mysqli_fetch_array(mysqli_query($db_con,$query1));
                            $query2='SELECT seller_name FROM seller WHERE seller_id="'.$row['seller_id'].'"';
                            $seller_name=mysqli_fetch_array(mysqli_query($db_con,$query2));
                            $query3='SELECT category_name FROM category WHERE category_id="'.$row['category_id'].'"';
                            $category_name=mysqli_fetch_array(mysqli_query($db_con,$query3));
                           
                ?>
                <tr>
                    <td><?= $sn?></td>
                    <td>
                        <div class="product_cart_image">
                            <img height="100vh" width="100vw" src="/SBstore/images/product/<?=$row['product_image']?>" alt="<?= $row['product_name']?>">
                        </div>
                    </td>
                    <td><?= $row['product_name']?></td>
                    <td><?= $row['product_description']?></td>
                    <td><?= $row['product_price']?></td>
                    <td><?= $row['product_quantity']?></td>
                    <td><?= $row['totalproductordered']?></td>
                    <td><?= $seller_name['seller_name']?></td>
                    <td><?= $category_name['category_name']?></td>
                </tr>

                <?php
                        }
                    }
                ?>
            </table>
        </div>
    </main>

    
    <?php include '/xampp/htdocs/SBstore/includes/footer.php';?>
</body>
</html>