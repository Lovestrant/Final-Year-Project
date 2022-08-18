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
  <p>Click Button to checkout: TOTAL-> <?php 
  
     //Calculate Total
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
  
  
  echo $sum; ?></p>

  <form action="cart.php" method="post">
    <!-- <button type="submit" name="checkout">Checkout</button> -->

  </form>


  <div id="smart-button-container">
    <div style="text-align: center"><label for="description"> </label><input type="text" name="descriptionInput" id="description" maxlength="127" value=""></div>
      <p id="descriptionError" style="visibility: hidden; color:red; text-align: center;">Please enter a description</p>
    <div style="text-align: center"><label for="amount">Total sum </label><input name="amountInput" type="number" id="amount" value="" ><span> USD</span></div>
      <p id="priceLabelError" style="visibility: hidden; color:red; text-align: center;">Please enter a price</p>
    <div id="invoiceidDiv" style="text-align: center; display: none;"><label for="invoiceid"> </label><input name="invoiceid" maxlength="127" type="text" id="invoiceid" value="" ></div>
      <p id="invoiceidError" style="visibility: hidden; color:red; text-align: center;">Please enter an Invoice ID</p>
    <div style="text-align: center; margin-top: 0.625rem;" id="paypal-button-container"></div>
  </div>
  <script src="https://www.paypal.com/sdk/js?client-id=sb&enable-funding=venmo&currency=USD" data-sdk-integration-source="button-factory"></script>
  <script>
  function initPayPalButton() {
    var description = document.querySelector('#smart-button-container #description');
    var amount = document.querySelector('#smart-button-container #amount');
    var descriptionError = document.querySelector('#smart-button-container #descriptionError');
    var priceError = document.querySelector('#smart-button-container #priceLabelError');
    var invoiceid = document.querySelector('#smart-button-container #invoiceid');
    var invoiceidError = document.querySelector('#smart-button-container #invoiceidError');
    var invoiceidDiv = document.querySelector('#smart-button-container #invoiceidDiv');

    var elArr = [description, amount];

    if (invoiceidDiv.firstChild.innerHTML.length > 1) {
      invoiceidDiv.style.display = "block";
    }

    var purchase_units = [];
    purchase_units[0] = {};
    purchase_units[0].amount = {};

    function validate(event) {
      return event.value.length > 0;
    }

    paypal.Buttons({
      style: {
        color: 'gold',
        shape: 'rect',
        label: 'buynow',
        layout: 'vertical',
        
      },

      onInit: function (data, actions) {
        actions.disable();

        if(invoiceidDiv.style.display === "block") {
          elArr.push(invoiceid);
        }

        elArr.forEach(function (item) {
          item.addEventListener('keyup', function (event) {
            var result = elArr.every(validate);
            if (result) {
              actions.enable();
            } else {
              actions.disable();
            }
          });
        });
      },

      onClick: function () {
        if (description.value.length < 1) {
          descriptionError.style.visibility = "visible";
        } else {
          descriptionError.style.visibility = "hidden";
        }

        if (amount.value.length < 1) {
          priceError.style.visibility = "visible";
        } else {
          priceError.style.visibility = "hidden";
        }

        if (invoiceid.value.length < 1 && invoiceidDiv.style.display === "block") {
          invoiceidError.style.visibility = "visible";
        } else {
          invoiceidError.style.visibility = "hidden";
        }

        purchase_units[0].description = description.value;
        purchase_units[0].amount.value = amount.value;

        if(invoiceid.value !== '') {
          purchase_units[0].invoice_id = invoiceid.value;
        }
      },

      createOrder: function (data, actions) {
        return actions.order.create({
          purchase_units: purchase_units,
        });
      },

      onApprove: function (data, actions) {
        return actions.order.capture().then(function (orderData) {

          // Full available details
          console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

          // Show a success message within this page, e.g.
          const element = document.getElementById('paypal-button-container');
          element.innerHTML = '';
          element.innerHTML = '<h3>Thank you for your payment!</h3>';

          // Or go to another URL:  actions.redirect('thank_you.html');
          
        });
      },

      onError: function (err) {
        console.log(err);
      }
    }).render('#paypal-button-container');
  }
  initPayPalButton();
  </script>
  </div>
</div> 

    </div>
    <br><br>


</div>

</div>
 
<div>
    
</body>
</html>