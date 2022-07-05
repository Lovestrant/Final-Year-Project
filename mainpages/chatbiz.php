<?php 
    session_start();


    include_once('../FirebaseConfig/dbcon.php'); 

    if (isset($_POST['submitChat'])) {


        //getting session variables
     
        $text = $_POST['chatsInput'];
        $phonenumber = $_SESSION['phonenumber'];
        $fullname = $_SESSION['fullname'];
        
        $messageId = $_POST['hiddenid'];
        $accId = $_POST['accid'];
        $chatId = $_POST['chatid'];

        $seller = $_POST['hiddenid'];
        $ref_table ="chats";
        $fetchData = $database->getReference($ref_table)->getValue();
    
        if($fetchData >0) {
            foreach($fetchData as $key =>$row){
                if( $key === $chatId) {
                    $ref_table ="chats";
                    $postData = [
                        "buyerPhonenumber" => $row['buyerPhonenumber'],
                        "fullname" => $fullname,
                        "sellerPhonenumber" => $phonenumber,
                        "accountName" => $row['accountName'],
                        "message" => $text,
                    ];
                    
                    
                    $postRef = $database->getReference($ref_table)->push($postData);
                    if($postRef) {
                        echo "<script>location.replace('../mainpages/chatbiz.php?messageId=$seller&acc_Id=$accId&chat_Id=$chatId');</script>"; 
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
        $accId = $_GET['acc_Id'];
        $chatId = $_GET['chat_Id'];

        $ref_table ="chats";
        $fetchData = $database->getReference($ref_table)->getValue();
      
          if($fetchData >0) {
              foreach($fetchData as $key =>$row){
      
                if($messageId === $row['buyerPhonenumber']&& $_GET['chat_Id'] === $key) {
                    //assign rows from database to variables
                $buyerPhonenumber = $row['buyerPhonenumber'];
                $accountName = $row['accountName'];
                $sellerPhonenumber = $phonenumber;
                $buyerfullname = $row['fullname'];

                echo"
                <div class='row'>
                <div class='col-sm-12' id='chatboxHeader'>
                    <h3 id='h3top'>".$buyerfullname."</h3>
                    <p id='ptop'>Phone: ".$buyerPhonenumber."</p>
                </div>

                ";
                }
                  $ref_table ="bizaccounts";
                  $fetchData = $database->getReference($ref_table)->getValue();
                  if($fetchData >0) {
                      foreach($fetchData as $key2 =>$TheRow){
                     if($TheRow['accountName'] === $row['accountName'] && $row['buyerPhonenumber'] === $messageId && $row['sellerPhonenumber'] === $phonenumber) {
                        echo "
                   
                        <div style='height: auto; width:auto; margin: 20px; padding: 10px;background-color: lightblue; margin-left:40%;
                         border-radius: 10px;'>
                         
                        
                         ".$row['message']."</div>
                      
                        ";

                     }

                      }
                    }
                }
            }
  

    ?>

</div>
          
    
        </div>
    
    </div>

  
    <div class="row" id="createText">
                <form action="chatbiz.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name= "hiddenid" value=<?php $id= $_GET['messageId']; echo $id; ?>> <!-- Hidden input-->
                <input type="hidden" name= "accid" value=<?php $id2= $_GET['acc_Id']; echo $id2; ?>> <!-- Hidden input-->
                <input type="hidden" name= "chatid" value=<?php $id= $_GET['chat_Id']; echo $id; ?>> <!-- Hidden input-->
                <p>
                <input id="chatinput" type="text" name="chatsInput" placeholder="Type message" required>
                <button name="submitChat" id="btnChat">Chat</button>
                </p>
                </form>
            </div>
  
</div>    

</body>
</html>