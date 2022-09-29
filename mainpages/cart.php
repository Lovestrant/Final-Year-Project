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
    $buyerPhone = $_SESSION['phonenumber'];
   

    $ref_table ="cart";
    $fetchData = $database->getReference($ref_table)->getValue();
    $sum = 0;
   
    if($fetchData >0) {
        foreach($fetchData as $key =>$row){
         if($row['buyerPhone'] === $buyerPhone){
          $sum += $row['price'];
         }
        }
    }

 }


 if(isset($_POST['checkout'])){

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

                $totalPayable =0.00;

                if($_SESSION['phonenumber']===$buyerPhone && $payOption === "mustpay"){
                  $totalPayable += $price;
                }
                
                
                if($_SESSION['phonenumber']===$buyerPhone){
                    if(!$row['picurl'] && !$row['picurl2'] ){
                        echo "  
                        <div>
                        <h2 style='color: red;text-align:centre;'>".$row['accountName']."</h2>
    
                        <h3 style='color: green;'>".$row['adtitle']."</h3>
            
            
                        </div>
            
                        <div style='margin-top: 1%; text-align:centre; margin-bottom: 5%;'>
                       
                        <p style='color: black;font-size:20px; margin-top:5%;margin-right:5%;'>".$row['description']."</p>  
                        <p style='color: green;text-decoration:bold;font-size:20px; '>Price: ".$row['price']."</p>  
    
                        <form action='cart.php' method='post'>
        
                        <input type='hidden' name='postid' value='$key'>

                        <button name='removefromcart' style='color: red;'>Remove from Cart</button>
                        
                        </form>

                        <hr>
                        </div>
            
                       
                      ";
            
                    } elseif(!$row['picurl'] && $row['picurl2']){
                        echo "  
                        <div>
                        <h2 style='color: red;'>".$row['accountName']."</h2>
      
                        <h3 style='color: green;'>".$row['adtitle']."</h3>
                            
                        </div>
            
                        <div style='margin-top: 3%; text-align:centre; margin-bottom: 5%;'>
                        <img class='zoom' src='../files/adpics/adpics".$row['picurl2']."' style = 'width: 80%; height:auto;'>
                        <p style='color: black;font-size:20px; margin-left:5%;margin-right:5%;'>".$row['description']."</p>  
                        <p style='color: green;text-decoration:bold;font-size:20px; '>Price: ".$row['price']."</p>  
            
                        <form action='cart.php' method='post'>
        
                        <input type='hidden' name='postid' value='$key'>

                        <button name='removefromcart' style='color: red;'>Remove from Cart</button>
                        
                        </form>

                        <hr>
                        </div>
            
                       
                      ";
                    } elseif($row['picurl'] && !$row['picurl2']){
                        echo "  
                        <div>
                        <h2 style='color: red;'>".$row['accountName']."</h2>
        
                        <h3 style='color: green;'>".$row['adtitle']."</h3>
                            
                        </div>
            
                        <div style='margin-top: 3%; text-align:centre; margin-bottom: 5%;'>
                        <img class='zoom' src='../files/adpics/adpics".$row['picurl']."' style = 'width: 80%; height:auto;'>
                        <p style='color: black;font-size:20px; margin-left:5%;margin-right:5%;'>".$row['description']."</p>  
                        <p style='color: green;text-decoration:bold;font-size:20px; '>Price: ".$row['price']."</p>  
    
                        <form action='cart.php' method='post'>
        
                        <input type='hidden' name='postid' value='$key'>

                        <button name='removefromcart' style='color: red;'>Remove from Cart</button>
                        
                        </form>

                        <hr>
                        </div>
            
                       
                      ";
            
                    } elseif($row['picurl'] && $row['picurl2']) {
                        echo "  
                        <div>
                        <h2 style='color: red;'>".$row['accountName']."</h2>
                    
                        <h3 style='color: green;'>".$row['adtitle']."</h3>
                            
                        </div>
            
                        <div style='margin-top: 3%; text-align:centre; margin-bottom: 5%;'>
                        <img class='zoom2' src='../files/adpics/adpics".$row['picurl']."' style = 'width: 45%; height:auto;'>
                        <img class='zoom2' src='../files/adpics/adpics".$row['picurl2']."' style = 'width: 45%; height:auto;'>
                        <p style='color: black;font-size:20px; margin-left:5%;margin-right:5%;'>".$row['description']."</p>  
                        <p style='color: green;text-decoration:bold;font-size:20px; '>Price: ".$row['price']."</p>  
                        <form action='cart.php' method='post'>
        
                        <input type='hidden' name='postid' value='$key'>

                        <button name='removefromcart' style='color: red;'>Remove from Cart</button>
                        
                        </form>
                        <hr>
                        </div>
            
                       
                      ";
                    }
                }

               }
            }
          
          ?>  

    </div>
<div class="container">
<div class="row">
  <div class="col-sm-12">
    <h4>Amount that you must pay = <?php echo $totalPayable;?> KES</h4>

     <form action="cart.php" method="post">
      <input type="hidden" value='<?php echo $totalPayable;?>' name="totalPayable">
      <button name='checkout'>PAY AND COMPLETE ORDER NOW</button>
     </form>
  </div>
</div> 

    </div>
    <br><br>


</div>

</div>
 
<div>
    
</body>
</html>