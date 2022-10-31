<?php 
    include '/xampp/htdocs/SBstore/includes/header.php';
    include_once '../connection/connection.php';
    if(empty($_SESSION['customer_id'])){
        header('location:/SBstore/customer/customerlogin.php');
    }
    if(isset($_POST['checkout'])){
        $cart_id=$_POST['cart_id'];
        $customers_name = $_POST['customers_name'];
        $contact_info = $_POST['contact_info'];
        $delivery_address = $_POST['delivery_address'];
        $quantity = $_POST['quantity'];
        $amount = $_POST['amount'];
        $payment = $_POST['payment'];
        $product_id = $_POST['product_id'];
        $seller_id = $_POST['seller_id'];
        $customer_id=$_SESSION['customer_id'];
        $left_quantity = $_POST['left_quantity'];
        if(!empty($customers_name) && !empty($contact_info) && !empty($delivery_address) &&!empty($payment) && $quantity!=0){
            $sql='INSERT INTO orders (customers_name,contact_info,delivery_address,quantity,amount,payment,product_id,seller_id,customer_id)
            VALUES ("'.$customers_name.'","'.$contact_info.'","'.$delivery_address.'","'.$quantity.'","'.$amount.'","'.$payment.'","'.$product_id.'","'.$seller_id.'","'.$customer_id.'")';
            if($result = mysqli_query($db_con,$sql)){
                $query4='SELECT totalproductordered	 FROM product WHERE product_id="'.$product_id.'"';
                if($result4=mysqli_query($db_con,$query4)){
                    $ordered=mysqli_fetch_array($result4);
                    $ordered_quantity=$ordered['totalproductordered']+$quantity;
                    $query3='UPDATE product SET product_quantity="'.$left_quantity.'", totalproductordered="'.$ordered_quantity.'" WHERE product_id="'.$product_id.'"';
                    if(mysqli_query($db_con,$query3)){
                        $query='DELETE FROM cart WHERE cart_id="'.$cart_id.'"';
                        if(mysqli_query($db_con,$query)){
                            header('location:/SBstore/index.php');
                        }
                        else{
                            echo "Error: ".mysqli_error($db_con);
                        }
                    }
                    else{
                        echo "Error: ".mysqli_error($db_con);
                    }
                }
                else{
                    echo "Error: ".mysqli_error($db_con);
                }
            }
            else{
                echo "Error: ".mysqli_error($db_con);
            }
        }
        else{
            echo "Empty fields";
        }
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CheckOut</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <main>

        <div id="checkoutproduct">
            <div id="checoutheading" style="color: darkblue;">
                Checkout
            </div>
            <?php
                if(isset($_POST['user_checkout'])){
                    $cart_id=$_POST['cart_id'];
                    $query="SELECT * FROM cart WHERE cart_id = '".$cart_id."'";
                    $result = mysqli_query($db_con,$query);
                    if($result){
                        while($cart_info=mysqli_fetch_array($result)){
                            $product_id=$cart_info['product_id'];
                            $query2="SELECT * FROM product WHERE product_id = '".$product_id."'";
                            $result2=mysqli_query($db_con,$query2);
                            if($result2){
                                $product=mysqli_fetch_array($result2);
                                $quantity=$cart_info['quantity'];
                                if($product['product_quantity']<$quantity){
                                    $quantity=$product['product_quantity'];
                                }
                                $price=$quantity*$product['product_price'];
                                $left_quantity=$product['product_quantity']-$quantity;
                
            ?>
            <form action="checkout.php" method="POST">
                <input type="text" id="customers_name" name="customers_name" placeholder="Enter your full Name"><br>
                <input type="text" id="contact_info" name="contact_info" placeholder="Enter your available phone number"><br>
                <input type="text" id="delivery_address" name="delivery_address" placeholder="Enter delivery Address"><br>
                
                <input type="number" name="quantity" id="quantity" onchange="total(<?= $product['product_price']?>)" value="<?=$quantity ?>" min="1" max="<?= $product['product_quantity']?>"><br>
                <label for="total_price"><b>Total Price: &emsp;</b>Rs.</label>
                <input type="money" readonly name="amount" id="amount" value="<?= $price?>"><br>


                <label for="payment">Enter your desired mode of payment:</label><br>
                <input type="radio" id="cod" name="payment" value="cod" checked>
                <label for="cod">Cash on delivery</label><br>
                <input type="radio" id="esewa" name="payment" value="esewa">
                <label for="esewa">Esewa</label><br>
                <input type="radio" id="khalti" name="payment" value="khalti">
                <label for="khalti">Khalti</label><br>
                <input type="radio" id="phonepay" name="payment" value="phonepay">
                <label for="khalti">Phone Pay</label><br>


                <input type="hidden" name="product_id" value="<?= $product['product_id']?>">
                <input type="hidden" name="seller_id" value="<?= $product['seller_id']?>">
                <input type="hidden" name="cart_id" value="<?= $cart_id?>">
                <input type="hidden" name="left_quantity" value="<?= $left_quantity?>">

                <input type="submit" name="checkout" id="checkout" value="Checkout">
            </form>
            
            <?php
                                
                            }
                        }
                    }
                }
            ?>
        </div>

    </main>

    
    <?php include '/xampp/htdocs/SBstore/includes/footer.php';?>
</body>
<script>
    function total(b){
        let a = document.getElementById('quantity').value;
        document.getElementById('amount').value = a*b;
    }
</script>
</html>