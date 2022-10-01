<?php 
session_start();
include_once('../FirebaseConfig/dbcon.php');  
     //remove from cart
     if(isset($_POST['removefromcart'])){
      $buyerPhone = $_SESSION['phonenumber'];
      $productKey = $_POST['postid'];

      $ref_table ="cart";
      $fetchData = $database->getReference($ref_table)->getValue();

     
      if($fetchData >0) {
          foreach($fetchData as $key =>$row){
           if($row['buyerPhone'] === $buyerPhone){
              $ref_table = "cart/".$productKey;
              $DeleteQueryResult = $database->getReference($ref_table)->remove();
           }
          }
      }

   }



   if(isset($_POST['checkout'])){
    $payPhonenumber = $_SESSION['phonenumber'];

    $ref_table ="cart";
    $fetchData = $database->getReference($ref_table)->getValue();
    $amount = $_POST['totalPayable'];

    if($amount<1) {
       //Complete Order
       $ref_table ="cart";
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
    
               if($_SESSION['phonenumber'] ===$buyerPhone) {
                   $postData = [
                       "phonenumber" => $SellerPhonenumber,
                       "picurl" => $picurl,
                       "picurl2" => $picur2,
                       "price" => $price,
                       "accountName" => $accountName,
                       "adtitle" => $adtitle,
                       "description" => $description,
                       "id" => $id,
                       "buyerPhone" => $buyerPhone,
                       "payOption" => $payOption
                   ];
                   
                   $ref_table = "Orders";
                   $postRef = $database->getReference($ref_table)->push($postData);
       
                   if($postRef) {
                       $ref_table = "cart/".$key;
                       $DeleteQueryResult = $database->getReference($ref_table)->remove();
                   }
               }
   
   
           }
           echo "<script>alert('Order Made Successful, Thank you');</script>";
       }

    }else{
   
      if($fetchData >0) {
        foreach($fetchData as $key =>$row){
         if($row['buyerPhone'] === $payPhonenumber){
           
            
        $account_no='moneygame';
        if($amount>0){
        $url="https://tinypesa.com/api/v1/express/initialize";
        $data = array(
            'amount' => $amount,
            'msisdn' => $payPhonenumber,
            'account_no'=>$account_no
        );
        $headers = array(
          "Content-Type: application/x-www-form-urlencoded",
          "ApiKey: JPu4SGPCzVi"
        );
      
        $info=http_build_query($data);
        $curl=curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_POST,true);
        curl_setopt($curl,CURLOPT_POSTFIELDS,$info);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_HTTPHEADER,$headers);
        $resp  = curl_exec($curl);
        $msg_resp = json_decode($resp);
        if($msg_resp->success=='true'){
            echo"<script>alert('wait for stk push')</script>";
        }
        }
      
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
          <?php
           include_once('../FirebaseConfig/dbcon.php');
      
           $phonenumber = $_SESSION['phonenumber'];
           $theAccountName = $_GET['accountName'];

           $ref_table ="Orders";
           $fetchData = $database->getReference($ref_table)->getValue();
       
           echo "<h3 style='color: green;'>Your $theAccountName Orders:</h3>";
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


                
                if($_SESSION['phonenumber']===$SellerPhonenumber && $theAccountName === $accountName){
                 echo"
                 <h4>$accountName</h4>
                 <hp>$adtitle<h5>
                 <h5 style='color: green;'>Order id: $key<h5>
                 <p>$description</p>
                 <p>Seler Phone: $SellerPhonenumber</p>
                 <p>Buyer Phone: $buyerPhone</p>
                 <p>Pay option: $payOption</p>
               
                 <p style='color: red;'>Status: $paid</p>
                 <hr>

                 ";
                    
                }

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