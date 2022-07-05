<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location-Based E-commerce System</title>

    <!--Css link-->
    <link rel="stylesheet" type="text/css" href="../css/bizaccounts.css">
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
  $accId = $_GET['acc_id'];

  $ref_table ="chats";
  $fetchData = $database->getReference($ref_table)->getValue();

    if($fetchData >0) {
        foreach($fetchData as $key1 =>$row){

            $ref_table ="bizaccounts";
            $fetchData = $database->getReference($ref_table)->getValue();
            if($fetchData >0) {
                foreach($fetchData as $key =>$TheRow){
                if($row['sellerPhonenumber'] == $phonenumber && $key === $_GET['acc_id'] && $TheRow['accountName'] === $row['accountName']) {

                    echo "
                            
                    <div style='margin-bottom: 5%;text-align:centre;'>
                   
                    <div style='text-transform: uppercase;color: green;margin-left:10%; text-align:centre;
                    margin-top: 4%;margin-bottom: 4%;'>
                    <h4>".$row['fullname']."</h4>
                    <p style='margin-top: -1%;'>".$row['buyerPhonenumber']."</p>
                    <div>
                   
                           
                    </div>
        
                    <div style='display:flex;margin-top: -1%;text-transform: none;margin-right: 10%;'>
                    <a href='chatbiz.php?messageId=".$row['buyerPhonenumber']."&acc_Id=".$_GET['acc_id']."&chat_Id=".$key1."'>
                    <p>".$row['message']."</p>
                    </a> 
                        
                       
                       
                    </div>
                  
                    
                    </div>
                    ";
        
                    }
                }
            }


        }
    }



?>

    </div>


</div>




</body>
</html>