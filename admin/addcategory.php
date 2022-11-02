<?php 
    include '/xampp/htdocs/SBstore/includes/header.php';
    include_once '../connection/connection.php';
    if(isset($_POST['add'])){
        $category_name=$_POST['category_name'];
        $file_name=basename($_FILES['image']['name']);
        $extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $image=$category_name.'.'.$extension;
        $target = "../images/category/".$category_name.'.'.$extension;

        if(($category_name!=null || $category_name!="") && ($image!=null)){
            $sql = 'INSERT INTO category(category_name,category_image) VALUES("'.$category_name.'","'.$image.'")';
            $result=mysqli_query($db_con,$sql);
            if($result){
                if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
                    header('location:admindashboard.php');
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
            echo "required category name and image";
        }
    }
    if(isset($_POST['delete_category'])){
        $category_id=$_POST['category_id'];
        $sql='DELETE FROM category WHERE category_id="'.$category_id.'"';
        $result1=mysqli_query($db_con,$sql);
        if(!$result1){
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
    <title>Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>


    <main>
        <div id="addcategory">
            <form action="addcategory.php" method="post" enctype="multipart/form-data">

                <h2>Add Category</h2>
                <input type="text" name="category_name" id="category_name" placeholder="Category Name"><br><br> 

                <label for="image" style="font-size:1.25em;">Upload an image:</label>
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
                        <th>Sno</th>
                        <th>Category Image</th>
                        <th>Category Name</th>
                        <!-- <th>Delete category</th> -->
                    </tr>
                    <?php
                        include_once '../connection/connection.php';
                        $query="SELECT * FROM category";
                        $result=mysqli_query($db_con,$query);
                        $sn=0;
                        while($row=mysqli_fetch_assoc($result)){
                            $sn++;
                            ?>
                            <tr>
                                <td><?= $sn;?></td>
                                <td>
                                    <div class="product_cart_image">
                                        <img height="200vh" width="250vw" src="/SBstore/images/category/<?=$row['category_image']?>" alt="<?= $row['category_name']?>">
                                    </div>
                                </td>
                                <td><?= $row['category_name']?></td>
                                <td style="border: none;">
                                    <div class="delete_category">
                                        <form action="addcategory.php">
                                            <input type="hidden" name="category_id" value="<?= $row['category_id']?>">
                                            <input type="submit" value="Delete" name="delete_category">
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                    ?>
                </table>
            </div>
        
    </main>


    <?php include '/xampp/htdocs/SBstore/includes/footer.php';?>

</body>
</html>