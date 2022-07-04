<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>zero The market</title>

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
        foreach($fetchData as $key =>$row){
            if($row['sellerPhonenumber'] == $phonenumber) {

            echo "
                    
            <div style='margin-bottom: 5%;text-align:centre;'>
           
            <div style='text-transform: uppercase;color: green;margin-left:10%; text-align:centre;
            margin-top: 4%;margin-bottom: 4%;'>
            <h4>".$row['fullname']."</h4>
            <p style='margin-top: -1%;'>".$row['buyerPhonenumber']."</p>
            <div>
           
                   
            </div>

            <div style='display:flex;margin-top: -1%;text-transform: none;margin-right: 10%;'>
            <a href='chatbiz.php?messageId=".$row['id']."'>
            <p>".$row['message']."</p>
            </a> 
                
               
               
            </div>
          
            
            </div>
            ";

            }
        }
    }


        if($queryResults2 >0) {
           while($row = mysqli_fetch_assoc($data2)) {
               echo "
               <h4 id='h4'>Messages to <label style='color:red;'>".$row['accountName']."</label> Business Accounts:</h4>
               ";

            $sellerPhonenumber = $row['phonenumber'];
            $accountName = $row['accountName'];

            $sql="SELECT * FROM chats where sellerPhonenumber= '$sellerPhonenumber' and accountName = '$accountName'  group by buyerPhonenumber";
            
            $data2= mysqli_query($con,$sql);
            $queryResults2= mysqli_num_rows($data2);


            

        if($queryResults2 >0) {
           while($row = mysqli_fetch_assoc($data2)) {
               




           }
        }
      
                   

                

          }
        }

?>

    </div>


</div>




</body>
</html>