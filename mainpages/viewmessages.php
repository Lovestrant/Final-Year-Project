<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location-Based E-Commerce System</title>

    <!--Css link-->
    <link rel="stylesheet" type="text/css" href="../css/bizacc.css">
    <!--Bootstrap css Links -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!--Bootstrap JS Links -->
    <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>

</head>



</head>
<body>
<div class = "container-fluid">
    <div class = "row">
    
        <div class="col-sm-12">
        <?php include_once('../header.php'); ?>
        </div>
            
    
    </div>

    <div class="col-sm-12">
       
<?php

include_once('../FirebaseConfig/dbcon.php');

  $phonenumber = $_SESSION['phonenumber'];
  $fullname = $_SESSION['fullname'];


  $ref_table ="chats";
  $fetchData = $database->getReference($ref_table)->getValue();

    if($fetchData >0) {
        foreach($fetchData as $key =>$row){

         if($row['buyerPhonenumber'] === $phonenumber) {
            echo "
                    
            <div style='margin-bottom: 5%;text-align:centre;'>
           
            <div style='text-transform: uppercase;color: green;margin-left:10%; text-align:centre;
            margin-top: 4%;margin-bottom: 4%;'>
            <h4>".$row['fullname']."</h4>
            <p style='margin-top: -1%;'>".$row['sellerPhonenumber']."</p>
            <div>
           
                   
            </div>

            <div style='display:flex;margin-top: -1%;text-transform: none;margin-right: 10%;
            background-color: lightgreen; padding:0.5%;border-radius:10px;'>
            <a href='chatprofile.php?messageId=".$row['sellerPhonenumber']."&Thekey=".$key."'>
            <p>".$row['message']."</p>
            </a> 
                
               
               
            </div>
          
            
            </div>
            ";
         }
           
        }
    }
           
?>

    </div>


</div>




</body>
</html>