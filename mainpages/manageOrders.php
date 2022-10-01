<?php 
session_start();
include_once('../FirebaseConfig/dbcon.php');  
     //remove from cart
     if(isset($_POST['ChangePayStatus'])){
      $productKey = $_POST['hiddenKey'];


      $ref_table ="Orders";
      $fetchData = $database->getReference($ref_table)->getValue();

      if($fetchData >0) {
          foreach($fetchData as $key =>$row){
            if($key === $productKey){
                $uid = $productKey;
                $UpdateData = [
                    "accountName" => $row['accountName'],
                    "adtitle" => $row['adtitle'],
                    "description" => $row['description'],
                    "id" => $row['id'],
                    "phonenumber" => $row['phonenumber'],
                    "picurl" => $row['picurl'],
                    "picurl2" => $row['picurl2'],
                    "price" => $row['price'],
                    "buyerPhone" => $row['buyerPhone'],
                    "payOption" => $row['payOption'],
                    "paid" => "Already Paid"
                ];
          
                // Create a key for a new post
                $ref_table = 'Orders/'.$uid;
                 $queryResult = $database->getReference($ref_table)->update($UpdateData);
              
                if($queryResult >0) {
                }
            }

          }
        }

   }

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Location-Based Ecommerce System</title>

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
<div class = "row"  id="headerbody">

    <div class="row">
    <div class="col-sm-12">
    <h3 style='color: green;'>Orders from Customers:</h3>
          <?php
           include_once('../FirebaseConfig/dbcon.php');
      
           $phonenumber = $_SESSION['phonenumber'];
    

           $ref_table ="Orders";
           $fetchData = $database->getReference($ref_table)->getValue();

           if($fetchData >0) {
               foreach($fetchData as $key =>$row){
                $accountName = $row['accountName'];
                $adtitle = $row['adtitle'];
                $description = $row['description'];
                $id = $row['id'];
                $SellerPhonenumber = $row['phonenumber'];
                $picurl = $row['picurl'];
                $picur2 = $row['picurl2'];
                $price = $row['price'];
                $buyerPhone = $row['buyerPhone'];
                $payOption = $row['payOption'];
                $paid = $row['paid'];

                if($payOption === "mustpay" && $paid === "Not Yet Paid") {
                  $btn = "<button name='ChangePayStatus'>SET STATUS TO PAID</button>";
                }else{
                 //Nothing
                 $btn = "";
                }
                

                 echo"
                 <h4>$accountName</h4>
                 <hp>$adtitle<h5>
                 <h5 style='color: green;'>Order id: $key<h5>
                 <p>$description</p>
                 <p>Seler Phone: $SellerPhonenumber</p>
                 <p>Buyer Phone: $buyerPhone</p>
                 <p>Pay option: $payOption</p>
               
                 <p style='color: red;'>Status: $paid</p>
                 <form action='manageOrders.php' method='post'>
                 <input type='hidden' value=$key name='hiddenKey'>
                 $btn
                 </form>
                 <hr>

                 ";
                    
                

               }
            }
          
          ?>  

    </div>


    </div>
    <br><br>


</div>

</div>
 
<div>
    
</body>
</html>