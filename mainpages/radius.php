<?php 
    session_start();

    $_SESSION['longitude'] = $_GET['long'];
    $_SESSION['latitude'] = $_GET['lat'];
    include_once('../FirebaseConfig/dbcon.php');  
    //Add to cart
    if(isset($_POST['addtocart'])){
           
        $buyerPhone = $_SESSION['phonenumber'];
        $productKey = $_POST['productKey'];
        $lat = $_POST['latitude'];
        $long = $_POST['longitude'];
    
        $ref_table ="Adverts";
        $fetchData = $database->getReference($ref_table)->getValue();

       
        if($fetchData >0) {
            foreach($fetchData as $key =>$row){
            if($key===$productKey){
                $accountName = $row['accountName'];
                $adtitle = $row['adtitle'];
                $description = $row['description'];
                $id = $productKey;
                $SellerPhonenumber = $row['phonenumber'];
                $picurl = $row['picurl'];
                $picur2 = $row['picurl2'];
                $price = $row['price'];
                
                 
                $postData = [
                   "phonenumber" => $SellerPhonenumber,
                   "picurl" => $picurl,
                   "picurl2" => $picur2,
                   "price" => $price,
                   "accountName" => $accountName,
                   "adtitle" => $adtitle,
                   "description" => $description,
                   "id" => $id,
                   "buyerPhone" => $buyerPhone
               ];
               
               $ref_table = "cart";
               $postRef = $database->getReference($ref_table)->push($postData);
               
           
            //    if($postRef){
            //        //echo "<script>Success</script>";

                     
            // }else{
            // echo "<script>Failed</script>";
            // }   
            }        
    
            }
        }
     }

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
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location-Based Ecommerce System</title>

    <!--Css link-->
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <link rel="stylesheet" type="text/css" href="../css/home.css">
    <!--Bootstrap css Links -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!--Bootstrap JS Links -->
    <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>

<style>
.zoom2{
    width:45%;
    height:auto;
    transition: transform ease-in-out 0.3s;
    }
.zoom2:hover{
    transform: scale(1.5);
    text-align: center;
    justify-content: center;
    }
    .zoom{
    width:45%;
    height:auto;
    transition: transform ease-in-out 0.3s;
    }
.zoom:hover{
    transform: scale(1.1);
    text-align: center;
    justify-content: center;
    
    }
</style>

<script>
    function resetCoordinates () { 
        navigator.geolocation.getCurrentPosition(function(pos) {
                                var ab = pos.coords.latitude;
                                var ac = pos.coords.longitude;
                                window.open('../mainpages/radius.php?lat=' + ab + '&long=' + ac, '_self')
                            }); 
    }
    setInterval(resetCoordinates, 300000);
</script>

</head>
<body>
<div class = "container-fluid">
    <div class = "row">
    
        <div class="col-sm-12">
        <?php include_once('../header.php'); ?>
        </div>
            
    
    </div>

    <div class="row">
<div class = "row" style="margin-left: 4%;">
    <p>Hello <?php $fullname = $_SESSION['fullname']; echo "<label style='color: red;font-size: 20px;'> $fullname</label>"; ?></p>

  <p style='color:purple;'>Ads within your radius(3KM):</p>
    </div>

<div class="container" id="homebody">
   <?php 

if($_SESSION['phonenumber']){

    include_once('../FirebaseConfig/dbcon.php');
      
    $phonenumber = $_SESSION['phonenumber'];
  
    $ref_table ="Adverts";
    $fetchData = $database->getReference($ref_table)->getValue();

    if($fetchData >0) {
    foreach($fetchData as $key =>$row){
    //latitude and longitude
    $latitude = $_SESSION['latitude'] = $_GET['lat'];
    $longitude = $_SESSION['longitude'] = $_GET['long'];

    $sellerLongitude = $row['longitude'];
    $sellerLatitude = $row['latitude'];
    //calculate distance between seller and buyer in session
    include_once('distanceAlgo.php');

    $dist = calculateDistance($sellerLatitude, $sellerLongitude, $latitude, $longitude);
    if($dist < 3){

        $ref_table2 ="cart";
        $fetchData2 = $database->getReference($ref_table2)->getValue();
        //Default Look of the button
         $btn ="<button name='addtocart' id='viewaccounts' style='color: purple;'>Add to the cart</button>";
         $HiddenInput = "";
         if($fetchData2 >0){
            foreach($fetchData2 as $key2 =>$therow){
                if($therow['id']===$key && $therow['buyerPhone']===$phonenumber){
                   $HiddenInput= "<input type='hidden' name='postid' value='$key2'>";
                  //Change color of button whenever it is already in cart
                    $btn= "<button name='removefromcart'id='viewaccounts' style='color: red;'>Remove from Cart</button>";
             
                    
                }
            }
         }
      
         if($row['phonenumber'] !=$phonenumber) {
            if(!$row['picurl'] && !$row['picurl2']){
                echo "  
                <div>
                <h2 style='color: red;text-align:centre;'>".$row['accountName']."</h2>
                <label style='color: blue;'>Seller is about ".round($dist,2)."</label>". " KM from you. 
                
                <button style='color: red;' name='getGoogleLocation'><a href='findSeller.php?sellerLong=".$row['longitude']."&sellerLat=".$row['latitude']."'>Find Seller on G-Maps</button>
                
                <h3 style='color: green;'>".$row['adtitle']."</h3>
    
    
                </div>
    
                <div style='margin-top: 1%; text-align:centre; margin-bottom: 5%;'>
               
                <p style='color: black;font-size:20px; margin-top:5%;margin-right:5%;'>".$row['description']."</p>  
                <p style='color: green;text-decoration:bold;font-size:20px; '>Price: ".$row['price']."</p>  
                <div style='display: flex;text-align:centre;'>
                <a href='chat.php?seller=".$key."'><button style='color: grey;margin-right: 10%;' id='viewaccounts'>Chat With Seller</button></a>
               
                <form action='radius.php?lat=".$latitude."&long=".$longitude."' method='post'>
                <input type='hidden' name='latitude' value='$latitude'>
                <input type='hidden' name='longitude' value='$longitude'>
                <input type='hidden' name='productKey' value='$key'>
                $HiddenInput
                $btn
             
                </form>
    
                </div>
                <hr>
                </div>
    
               
              ";
    
            } elseif(!$row['picurl'] && $row['picurl2']){
                echo "  
                <div>
                <h2 style='color: red;'>".$row['accountName']."</h2>
                <label style='color: blue;'>Seller is about ".round($dist,2)."</label>". " KM from you. 
                
                <button style='color: red;' name='getGoogleLocation'><a href='findSeller.php?sellerLong=".$row['longitude']."&sellerLat=".$row['latitude']."'></a>Find Seller on G-Maps</button>
                
                <h3 style='color: green;'>".$row['adtitle']."</h3>
                    
                </div>
    
                <div style='margin-top: 3%; text-align:centre; margin-bottom: 5%;'>
                <img class='zoom' src='../files/adpics/adpics".$row['picurl2']."' style = 'width: 80%; height:auto;'>
                <p style='color: black;font-size:20px; margin-left:5%;margin-right:5%;'>".$row['description']."</p>  
                <p style='color: green;text-decoration:bold;font-size:20px; '>Price: ".$row['price']."</p>  
                <div style='display: flex;text-align:centre;'>
                <a href='chat.php?seller=".$row['id']."'><button style='color: grey;margin-right: 10%;' id='viewaccounts'>Chat With Seller</button></a>
               
                <form action='radius.php?lat=".$latitude."&long=".$longitude."' method='post'>
                <input type='hidden' name='latitude' value='$latitude'>
                <input type='hidden' name='longitude' value='$longitude'>
                <input type='hidden' name='productKey' value='$key'>
                $HiddenInput
                $btn
             
                </form>  
    
                </div>
                <hr>
                </div>
    
               
              ";
            } elseif($row['picurl'] && !$row['picurl2']){
                echo "  
                <div>
                <h2 style='color: red;'>".$row['accountName']."</h2>
                <label style='color: blue;'>Seller is about ".round($dist,2)."</label>". " KM from you. 
               
                <button style='color: red;' name='getGoogleLocation'><a href='findSeller.php?sellerLong=".$row['longitude']."&sellerLat=".$row['latitude']."'></a>Find Seller on G-Maps</button>   
               
                <h3 style='color: green;'>".$row['adtitle']."</h3>
                    
                </div>
    
                <div style='margin-top: 3%; text-align:centre; margin-bottom: 5%;'>
                <img class='zoom' src='../files/adpics/adpics".$row['picurl']."' style = 'width: 80%; height:auto;'>
                <p style='color: black;font-size:20px; margin-left:5%;margin-right:5%;'>".$row['description']."</p>  
                <p style='color: green;text-decoration:bold;font-size:20px; '>Price: ".$row['price']."</p>  
                <div style='display: flex;text-align:centre;'>
                <a href='chat.php?seller=".$row['id']."'><button style='color: grey;margin-right: 10%;' id='viewaccounts'>Chat With Seller</button></a>
                
                <form action='radius.php?lat=".$latitude."&long=".$longitude."' method='post'>
                <input type='hidden' name='latitude' value='$latitude'>
                <input type='hidden' name='longitude' value='$longitude'>
                <input type='hidden' name='productKey' value='$key'>
                $HiddenInput
                $btn
             
                </form>
                </div>
                <hr>
                </div>
    
               
              ";
    
            } elseif($row['picurl'] && $row['picurl2']) {
                echo "  
                <div>
                <h2 style='color: red;'>".$row['accountName']."</h2>
                <label style='color: blue;'>Seller is about ".round($dist,2)."</label>". " KM from you. 
          
    
                <button style='color: red;' name='getGoogleLocation'><a href='findSeller.php?sellerLong=".$row['longitude']."&sellerLat=".$row['latitude']."'></a>Find Seller on G-Maps</button>
    
                
                <h3 style='color: green;'>".$row['adtitle']."</h3>
                    
                </div>
    
                <div style='margin-top: 3%; text-align:centre; margin-bottom: 5%;'>
                <img class='zoom2' src='../files/adpics/adpics".$row['picurl']."' style = 'width: 45%; height:auto;'>
                <img class='zoom2' src='../files/adpics/adpics".$row['picurl2']."' style = 'width: 45%; height:auto;'>
                <p style='color: black;font-size:20px; margin-left:5%;margin-right:5%;'>".$row['description']."</p>  
                <p style='color: green;text-decoration:bold;font-size:20px; '>Price: ".$row['price']."</p>  
                <div>
    
                <div style='display: flex;text-align:centre;'>
                <a href='chat.php?seller=".$row['id']."'><button style='color: grey;'  id='viewaccounts'>Chat With Seller</button></a>
               
               <form action='radius.php?lat=".$latitude."&long=".$longitude."' method='post'>
                    <input type='hidden' name='latitude' value='$latitude'>
                    <input type='hidden' name='longitude' value='$longitude'>
                    <input type='hidden' name='productKey' value='$key'>
                    $HiddenInput
                    $btn
                 
               </form>
               </div>
                </div>
                <hr>
                </div>
    
               
              ";
            }
         }else{
            if(!$row['picurl'] && !$row['picurl2']){
                echo "  
                <div>
                <h2 style='color: red;text-align:centre;'>".$row['accountName']."</h2>
                <label style='color: blue;'>Seller is about ".round($dist,2)."</label>". " KM from you. 
                
                <button style='color: red;' name='getGoogleLocation'><a href='findSeller.php?sellerLong=".$row['longitude']."&sellerLat=".$row['latitude']."'></a>Find Seller on G-Maps</button>
                
                <h3 style='color: green;'>".$row['adtitle']."</h3>
    
    
                </div>
    
                <div style='margin-top: 1%; text-align:centre; margin-bottom: 2%;'>
               
                <p style='color: black;font-size:20px; margin-top:5%;margin-right:5%;'>".$row['description']."</p>  
                <p style='color: green;text-decoration:bold;font-size:20px; '>Price: ".$row['price']."</p>  
                <div>
                </div>
                </div>
                 <h2 style='color:green; '>Your own advert</h2>
        
                <hr>
    
               
              ";
    
            } elseif(!$row['picurl'] && $row['picurl2']){
                echo "  
                <div>
                <h2 style='color: red;'>".$row['accountName']."</h2>
                <label style='color: blue;'>Seller is about ".round($dist,2)."</label>". " KM from you. 
                
                <button style='color: red;' name='getGoogleLocation'><a href='findSeller.php?sellerLong=".$row['longitude']."&sellerLat=".$row['latitude']."'></a>Find Seller on G-Maps</button>
                
                <h3 style='color: green;'>".$row['adtitle']."</h3>
                    
                </div>
    
                <div style='margin-top: 3%; text-align:centre; margin-bottom: 2%;'>
                <img class='zoom' src='../files/adpics/adpics".$row['picurl2']."' style = 'width: 80%; height:auto;'>
                <p style='color: black;font-size:20px; margin-left:5%;margin-right:5%;'>".$row['description']."</p>  
                <p style='color: green;text-decoration:bold;font-size:20px; '>Price: ".$row['price']."</p>  
                <div style='display: flex;text-align:centre;'>
                <div>
                </div>
                </div>
                 <h2 style='color:green; '>Your own advert</h2>
        
                <hr>
    
               
              ";
            } elseif($row['picurl'] && !$row['picurl2']){
                echo "  
                <div>
                <h2 style='color: red;'>".$row['accountName']."</h2>
                <label style='color: blue;'>Seller is about ".round($dist,2)."</label>". " KM from you. 
               
                <button style='color: red;' name='getGoogleLocation'><a href='findSeller.php?sellerLong=".$row['longitude']."&sellerLat=".$row['latitude']."'></a>Find Seller on G-Maps</button>   
               
                <h3 style='color: green;'>".$row['adtitle']."</h3>
                    
                </div>
    
                <div style='margin-top: 3%; text-align:centre; margin-bottom: 2%;'>
                <img class='zoom' src='../files/adpics/adpics".$row['picurl']."' style = 'width: 80%; height:auto;'>
                <p style='color: black;font-size:20px; margin-left:5%;margin-right:5%;'>".$row['description']."</p>  
                <p style='color: green;text-decoration:bold;font-size:20px; '>Price: ".$row['price']."</p>  
                <div>
                </div>
                </div>
                 <h2 style='color:green; '>Your own advert</h2>
        
                <hr>
    
               
              ";
    
            } elseif($row['picurl'] && $row['picurl2']) {
                echo "  
                <div>
                <h2 style='color: red;'>".$row['accountName']."</h2>
                <label style='color: blue;'>Seller is about ".round($dist,2)."</label>". " KM from you. 
          
    
                <button style='color: red;' name='getGoogleLocation'><a href='findSeller.php?sellerLong=".$row['longitude']."&sellerLat=".$row['latitude']."'></a>Find Seller on G-Maps</button>
    
                
                <h3 style='color: green;'>".$row['adtitle']."</h3>
                    
                </div>
    
                <div style='margin-top: 3%; text-align:centre; margin-bottom: 2%;'>
                <img class='zoom2' src='../files/adpics/adpics".$row['picurl']."' style = 'width: 45%; height:auto;'>
                <img class='zoom2' src='../files/adpics/adpics".$row['picurl2']."' style = 'width: 45%; height:auto;'>
                <p style='color: black;font-size:20px; margin-left:5%;margin-right:5%;'>".$row['description']."</p>  
                <p style='color: green;text-decoration:bold;font-size:20px; '>Price: ".$row['price']."</p>  
                <div>
                </div>
                </div>
                 <h2 style='color:green; '>Your own advert</h2>
        
                <hr>
                   
              ";
            }
         }


        
    }


}
}

    }else{
        echo "<script>alert('Your Session has expired.You need to login again')</script>";
        echo "<script>location.replace('../index.php')</script>";
    }

                      
     ?>
       
   </div>

</body>
</html>

