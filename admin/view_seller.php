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
            <h1 style="margin: 5vh 5vw; color:#5eb85a;">Seller Info table</h1>
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
                    <th>Citizenship Number</th>
                    <th>Bank Account</th>
                </tr>
                <?php
                    function calculateage($dob){
                        $birthdate= new DateTime($dob);
                        $today =  new DateTime('today');
                        $age = $birthdate->diff($today)->y;
                        return $age;
                    }
                    $sql = 'SELECT * FROM seller';
                    if($result = mysqli_query($db_con,$sql)){
                        $sn=0;
                        foreach($result as $row){
                            $sn++;
                            $age=calculateage($row['seller_dob']);
                ?>
                <tr>
                    <td><?= $sn?></td>
                    <td><?= $row['seller_name']?></td>
                    <td><?= $age?></td>
                    <td><?= $row['seller_email']?></td>
                    <td><?= $row['seller_contact']?></td>
                    <td><?= $row['seller_address']?></td>
                    <td><?= $row['seller_citizenshipno']?></td>
                    <td><?= $row['seller_bank_account_no']?></td>
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