<?php 
    session_start();

    include_once('../FirebaseConfig/dbcon.php');

    if (isset($_POST['submitChat'])) {


        //getting session variables
     
        $text = $_POST['chatsInput'];
        $phonenumber = $_SESSION['phonenumber'];
        $fullname = $_SESSION['fullname'];
        
        $seller = $_POST['hiddenid'];
        $ref_table ="bizaccounts";
        $fetchData = $database->getReference($ref_table)->getValue();
    
        if($fetchData >0) {
            foreach($fetchData as $key =>$row){
                if($row['phonenumber'] === $seller) {
                    $ref_table ="chats";
                    $postData = [
                        "buyerPhonenumber" => $phonenumber,
                        "fullname" => $fullname,
                        "sellerPhonenumber" => $row['phonenumber'],
                        "accountName" => $row['accountName'],
                        "message" => $text,
                    ];
                    
                    
                    $postRef = $database->getReference($ref_table)->push($postData);
                    if($postRef) {
                        echo "<script>location.replace('../mainpages/chatprofile.php?messageId=$seller');</script>"; 
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
    <title>Location-Based E-commerce System</title>

    <!--Css link-->
    <link rel="stylesheet" type="text/css" href="../css/chat.css">
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

<div class="container" id="chatbox">
<div class='col-sm-12' id='chatboxBody'>
    <?php  

include_once('../FirebaseConfig/dbcon.php'); 
              
        
        $phonenumber = $_SESSION['phonenumber'];
        $fullname = $_SESSION['fullname'];

        
        $messageId = $_GET['messageId'];
  
        $ref_table ="chats";
        $fetchData = $database->getReference($ref_table)->getValue();
      
          if($fetchData >0 ) {
            

              foreach($fetchData as $key =>$row) {
                //assign rows from database to variables

                $buyerPhonenumber = $row['buyerPhonenumber'];
                $accountName = $row['accountName'];
                $sellerPhonenumber = $row['sellerPhonenumber'];
                $buyerfullname = $row['fullname'];

                if($row['buyerPhonenumber'] === $phonenumber && $row['sellerPhonenumber']=== $messageId && $key == $_GET['Thekey']) {
                    echo"
                    <div class='row'>
                    <div class='col-sm-12' id='chatboxHeader'>
                        <h3 id='h3top'>".$buyerfullname."</h3>
                        <p id='ptop'>Phone: ".$buyerPhonenumber."</p>
                    </div>
                    
                    ";
                }


               if($row['buyerPhonenumber'] === $phonenumber && $row['sellerPhonenumber']=== $messageId) {
                //assign rows from database to variables

                $buyerPhonenumber = $row['buyerPhonenumber'];
                $accountName = $row['accountName'];
                $sellerPhonenumber = $row['sellerPhonenumber'];
                $buyerfullname = $row['fullname'];

                if($row['buyerPhonenumber'] == $_SESSION['phonenumber']){
                               
          
                    echo "
                                             
                    <div style='height: auto; width:auto; margin: 20px; padding: 10px;background-color: lightblue; margin-left:40%;
                     border-radius: 10px;'>
                     
                    
                     ".$row['message']."</div>
                  
                
                    ";
                
                }else{
                    echo "
                                
                                
                    <div style='height: auto; width:auto; margin-right: 40%; padding: 10px;background-color: lightgreen; 
                     border-radius: 10px; border-radius: 10px;margin-bottom:10px; '>
                   
                    <div>".$row['message']."</div>
                  
                    </div> 
                    ";
                
                }
               }
            }
        }


    ?>

</div>
          
    
        </div>
    
    </div>

  
    <div class="row" id="createText">
                <form action="chatprofile.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name= "hiddenid" value=<?php $id= $_GET['messageId']; echo $id; ?>> <!-- Hidden input-->
                <p>
                <input id="chatinput" type="text" name="chatsInput" placeholder="Type message" required>
                <button name="submitChat" id="btnChat">Chat</button>
                </p>
                </form>
            </div>
  
</div>    

</body>
</html>