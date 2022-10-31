<?php 
    include '/xampp/htdocs/SBstore/includes/header.php';
    include_once 'connection/connection.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SBstore</title>
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
                            <p onclick=location.href="products/products.php?category_id=<?=$row['category_id'] ?>"><?= $row['category_name'] ?></p>
                        <?php
                    }
                }
                else{
                    die("Error: " . mysqli_error($db_con));
                }
            ?>
        </div>
        <div id="categoryDiv">
                <?php
                    $sql = 'SELECT * FROM category';
                    $result=mysqli_query($db_con,$sql);
                    if($result){
                        foreach ($result as $row) {?>
                            
                        <div class="categoryCard" onclick=location.href="products/products.php?category_id=<?=$row['category_id'] ?>">
                            <div class="categoryImage">
                                <img src="/Sbstore/images/category/<?= $row['category_image'] ?>" alt="<?= $row['category_name']?>"><br>
                            </div>
                            <div class="categoryName">
                                <h3><?= $row['category_name']?></h3>
                        </div>
                        </div>
                <?php
                }
                }
                else{
                    die("Error: " . mysqli_error($db_con));
                }
                ?>

        </div>
    </main>
    <?php include 'includes/footer.php';?>
</body>
</html>
