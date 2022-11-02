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
            <h1 style="margin: 5vh 5vw; color:#5eb85a;">Order table</h1>
        </div>
        <div class="admin_table">
            <table>
                <tr>
                    <th>Sn</th>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Total Amount</th>
                    <th>Delivery Address</th>
                    <th>Payment Method</th>
                    <th>Customer</th>
                    <th>Seller</th>
                    <th>Status</th>
                </tr>
                <?php
                    
                    $sql = 'SELECT * FROM orders';
                    if($result = mysqli_query($db_con,$sql)){
                        $sn=0;
                        foreach($result as $row){
                            $sn++;
                            
                            $query2='SELECT seller_name FROM seller WHERE seller_id="'.$row['seller_id'].'"';
                            $seller_name=mysqli_fetch_array(mysqli_query($db_con,$query2));
                            $query3='SELECT * FROM product WHERE product_id="'.$row['product_id'].'"';
                            $product=mysqli_fetch_array(mysqli_query($db_con,$query3));
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
                    <td>
                        <div >
                            <img height="100vh" width="100vw" src="/SBstore/images/product/<?=$product['product_image']?>" alt="<?= $product['product_name']?>">
                        </div>
                    </td>
                    <td onclick=location.href="/Sbstore/products/individualproduct.php?product_id=<?=$row['product_id']?>"><?= $product['product_name']?></td>
                    <td><?= $row['quantity']?></td>
                    <td><?= $row['amount']?></td>
                    <td><?= $row['delivery_address']?></td>
                    <td><?= $row['payment']?></td>
                    <td><?= $row['customers_name']?></td>
                    <td><?= $seller_name['seller_name']?></td>
                    <td style="color:<?=$color?>;"><?= $delivery_satus ?></td>
                    
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