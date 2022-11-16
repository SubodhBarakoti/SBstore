<?php include '/xampp/htdocs/SBstore/includes/header.php';?>
<?php
    include_once '../connection/connection.php';
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
                if(isset($_GET['category_id'])){
                    $category_id=$_GET['category_id'];
                    $query1="SELECT category_name FROM category Where category_id='".$category_id."'";
                    $result1=mysqli_query($db_con,$query1);
                    foreach($result1 as $row)
            ?>
                    <div class="productheading">
                        <br><h1 style="color: green;">&emsp;<?=$row['category_name'] ?></h1>
                    </div>
                    <div id="categoryDiv">
                <?php
                    $sql = 'SELECT * FROM product Where category_id = "'.$category_id.'"';
                    $result=mysqli_query($db_con,$sql);
                    if($result){
                        foreach ($result as $row) {   
                
                ?>
                            
                        <div class="categoryCard" onclick=location.href="../products/individualproduct.php?product_id=<?=$row['product_id'] ?>">
                            <div class="categoryImage">
                                <img src="../images/product/<?= $row['product_image'] ?>" alt="<?= $row['product_name']?>"><br>
                            </div>
                            <div class="categoryName">
                                <h3><?= $row['product_description']?></h3>
                                <h2 style="color: rgba(1,119,191,255);">Price: <?= $row['product_price']?></h2>
                            </div>
                        </div>
                    
                <?php
                }
                }
                else{
                    die("Error: " . mysqli_error($db_con));
                }
            }
                ?>
        </div>



        <!-- incase of search  -->
        <?php
                if(isset($_GET['product_name'])){
                    $product_name=$_GET['product_name'];
                    ?>
                            <div class="productheading">
                                <br><h1 style="color: green;">&emsp;Search result for: <?=$product_name ?></h1>
                            </div>
                            <div id="categoryDiv">
                    <?php
                    $query1="SELECT * FROM product Where product_description LIKE '%".$product_name."%' OR product_name LIKE '%".$product_name."%' ORDER BY totalproductordered DESC";
                    $result1=mysqli_query($db_con,$query1);
                    if(mysqli_num_rows($result1)>0 && strlen($product_name)>2){
                        foreach($result1 as $product){
            ?>
                    
                        <div class="categoryCard" onclick=location.href="../products/individualproduct.php?product_id=<?=$product['product_id'] ?>">
                            <div class="categoryImage">
                                <img src="../images/product/<?= $product['product_image'] ?>" alt="<?= $product['product_name']?>"><br>
                            </div>
                            <div class="categoryName">
                                <h3><?= $product['product_description']?></h3>
                                <h2 style="color: rgba(1,119,191,255);">Price: <?= $product['product_price']?></h2>
                            </div>
                        </div>
                    
                <?php
                        }
                    }
                else{   
                    ?>
                        <h1 style="margin-top: 20vh;margin-left: 25vw; color:red;">!!Product Not Found!!</h1>
                    <?php
                }
            }
                ?>
                </div>

    </main>

    
    <?php include '/xampp/htdocs/SBstore/includes/footer.php';?>
</body>
</html>