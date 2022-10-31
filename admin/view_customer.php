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
            <h1 style="margin: 5vh 5vw; color:#5eb85a;">Customer Info table</h1>
        </div>
        <div class="admin_table">
            <table>
                <tr>
                    <th>Sn</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Address</th>
                </tr>
                <?php
                    function calculateage($dob){
                        $birthdate= new DateTime($dob);
                        $today =  new DateTime('today');
                        $age = $birthdate->diff($today)->y;
                        return $age;
                    }
                    $sql = 'SELECT * FROM customer';
                    if($result = mysqli_query($db_con,$sql)){
                        $sn=0;
                        foreach($result as $row){
                            $sn++;
                            $age=calculateage($row['customer_dob']);
                ?>
                <tr>
                    <td><?= $sn?></td>
                    <td><?= $row['customer_name']?></td>
                    <td><?= $age?></td>
                    <td><?= $row['customer_email']?></td>
                    <td><?= $row['customer_contact']?></td>
                    <td><?= $row['customer_address']?></td>
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