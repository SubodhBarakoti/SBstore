<?php 
    include '/xampp/htdocs/SBstore/includes/header.php';
    include_once '../connection/connection.php';
    if(isset($_POST['add'])){
        $product_name=$_POST['product_name'];
        $seller_id=$_SESSION['seller_id'];
        $product_description = $_POST['product_description'];
        $product_quantity = $_POST['product_quantity'];
        $category_id=$_POST['category_id'];
        $product_price= $_POST['product_price'];
        $file_name=basename($_FILES['image']['name']);
        $extension = pathinfo($file_name,PATHINFO_EXTENSION);
        $image=$product_name.rand(1,100000).'.'.$extension;
        $target = "../images/product/".$image;

        if(!empty($product_name) && !empty($image) && !empty($product_description) && !empty($product_quantity) && !empty($category_id)&& !empty($product_price)){
            $sql = 'INSERT INTO product(product_name,product_image,product_description,product_price,product_quantity,category_id,seller_id) 
            VALUES("'.$product_name.'","'.$image.'","'.$product_description.'","'.$product_price.'","'.$product_quantity.'","'.$category_id.'","'.$seller_id.'")';
            $result=mysqli_query($db_con,$sql);
            if($result){
                if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
                    header('location:/SBstore/products/productdashboard.php');
                }
                else{
                    echo 'Some error occured';
                }
            }
            else{
                die("Error: " . mysqli_error($db_con));
            }
        }
        else{
            echo "required all fields";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <main>
        <div id="addproduct">
            <form action="addproduct.php" method="post" enctype="multipart/form-data">

                <h2>Add Product</h2>
                <input type="text" name="product_name" id="product_name" placeholder="Product Name"><br><br> 

                <textarea name="product_description" id="product_description" cols="30" rows="5" placeholder="Product Description"></textarea><br>

                <input type="number" name="product_price" id="product_price" placeholder="Product Price"><br>

                <input type="number" name="product_quantity" id="product_quantity" placeholder="Product Quantity"><br>

                <select name="category_id" id="category_id" style="text-align: center;"><br>
                    <?php 
                        $query="SELECT * FROM category";
                        $result=mysqli_query($db_con,$query);
                        if($result){
                            foreach($result as $row){
                        
                    ?>
                        <option value="<?= $row['category_id']?>"><?= $row['category_name']?></option>
                    <?php 
                            }
                        }
                        else{
                            echo "Error: ".mysqli_error($db_con);
                        }
                    ?>
                </select><br>
                <label for="picture" style="font-size:1.15em;">Upload a image:</label>
                <input type="file" name="image" id="image"><br>

                <input type="submit" name="add" value="Add">
            </form>
        </div>
        <div id="showcategory">
                <div class="categoryheading">
                    <h2 style="margin-left:5vw;">Category of Product</h2>
                </div>
                <table>
                    <tr>
                        <th>Product Id</th>
                        <th>product Name</th>
                        <th>Product Description</th>
                        <th>Product Price</th>
                        <th>Product Quantity</th>
                        <!-- <th>Category Name</th> -->
                        <!-- <th>Delete category</th> -->
                    </tr>
                    <?php
                        $seller_id=$_SESSION['seller_id'];
                        $query='SELECT * FROM product Where seller_id= "'.$seller_id.'"';
                        $result=mysqli_query($db_con,$query);
                        while($row=mysqli_fetch_assoc($result)){
                            echo "<tr>";
                            echo "<td>".$row['product_id']."</td>";
                            echo "<td>".$row['product_name']."</td>";
                            echo "<td>".$row['product_description']."</td>";
                            echo "<td>".$row['product_price']."</td>";
                            echo "<td>".$row['product_quantity']."</td>";
                            // echo "<td>".$row['category_name']."</td>";
                            echo "</tr>";
                        }
                    ?>
                </table>
            </div>
        
    </main>


    <?php include '/xampp/htdocs/SBstore/includes/footer.php';?>

</body>
</html>