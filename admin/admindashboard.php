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
        <div class="admin_dashboard">
            <button onclick=location.href="/Sbstore/admin/addcategory.php">Categories</button>
            <button onclick=location.href="/Sbstore/admin/view_product.php">Products</button>
            <button onclick=location.href="/Sbstore/admin/view_seller.php">Seller Info</button>
            <button onclick=location.href="/Sbstore/admin/view_customer.php">Customer Info</button>
            <button onclick=location.href="/Sbstore/admin/view_order.php">Order Info</button>
        </div>

    </main>

    
    <?php include '/xampp/htdocs/SBstore/includes/footer.php';?>
</body>
</html>