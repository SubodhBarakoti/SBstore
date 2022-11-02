<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keyword" content="SBstore, online store">
    <link rel="icon" type="image/x-icon" href="/SBstore/images/logo3.png">
    <title>SBstore</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div id="logo" onclick=location.href="/SBstore/index.php">
            <img src="/SBstore/images/logo.jpg">
        </div>

        <div class="header_upper">
            <?php
                if(empty($_SESSION['customer_id'])){

            ?>
                <div class="login" onclick=location.href="/SBstore/customer/customerlogin.php">
                    Login
                </div>
                <div class="signup" onclick=location.href="/SBstore/customer/customerregistration.php">
                    Signup
                </div>
            <?php
                }
                elseif(!empty($_SESSION['customer_id'])){
                    
            ?>
                <div class="logout" onclick=location.href="/SBstore/customer/customerlogout.php">
                    Logout
                </div>
                <div class="profile" onclick=location.href="/SBstore/customer/customerdashboard.php">
                    Profile
                </div>
            <?php
                }
            ?>
            <?php
                if(empty($_SESSION['seller_id'])){
            ?>
                <div class="sellhere" onclick=location.href="/SBstore/seller/sellerregistration.php">
                    Sell on SBstore
                </div>
            <?php
                }
                elseif(!empty($_SESSION['seller_id'])){
            ?>
                <div class="logout" onclick=location.href="/SBstore/seller/sellerlogout.php">
                    Seller Logout
                </div>
                
                <div class="dashboard" onclick=location.href="/SBstore/seller/sellerdashboard.php">
                    Seller Dashboard
                </div>
            <?php
            
                }
                if(!empty($_SESSION['admin_id'])){
            ?>
                <div class="dashboard" onclick=location.href="/SBstore/admin/admindashboard.php">
                    Admin Dashboard
                </div>
                <div class="logout" onclick=location.href="/SBstore/admin/logout.php">
                    Admin Logout
                </div>
                <?php
                }
            ?>
        </div>

        <div class="header_lower">
                <div id="search">
                    <form action="/SBstore/products/products.php" method="get" id="search_product">
                        <input type="search" id="product_names" name="product_name" 
                        style="border:0px;background-color: #fde4d7; width :30vw; height: 5vh; text-align: center; border-radius: 0.5em;" 
                        placeholder="Search for any product">
                        <button type="submit" form="search_product" style="background-color: aliceblue;border:none;"><i class="fa fa-search" aria-hidden="true" style="font-size: 1.7em;"></i></button>
                    </form>
                </div>
                <div id="cart" onclick=location.href="/SBstore/products/cart.php">
                    <i class="fa fa-shopping-cart" style="font-size:2em; color:rgba(1,119,191,255);"></i>
                    <!-- <i class="fa-thin fa-cart-shopping-fast" style="font-size:2em;"></i> -->
                </div>
                <div id="customer_care" onclick=location.href="#" >
                    Customer Care
                </div>
                <div id="aboutus" onclick=location.href="#" >
                    About Us  
                </div>
        </div>
    </header>
</body>
</html>