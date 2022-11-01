<?php 
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>

    <!--Css link-->
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <!--Bootstrap css Links -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!--Bootstrap JS Links -->
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

</head>
<body>
<div class="col-sm-12">
        <?php include_once('../header.php'); ?>
</div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">

            <?php
            include_once('../FirebaseConfig/dbcon.php');  
            $buyerPhone = $_SESSION['phonenumber'];
            
            $ref_table ="Orders";
            $fetchData = $database->getReference($ref_table)->getValue();

            
            if($fetchData >0) {
                foreach($fetchData as $key =>$row){
                
                if($row['buyerPhone'] ===$buyerPhone){
                    $adtitle = $row['adtitle'];
                    $description = $row['description'];
                    $accountName = $row['accountName'];

                    echo "
                    <h1>$adtitle</h1>
                    <p>Description: $description</p>
                    </p>Seller: $accountName</p>
                    <hr>
                    ";  
                }
                }
            }
            
            ?>
            </div>
        </div>
    </div>

</body>
</html>