<?php 
    session_start();

    include_once('../FirebaseConfig/dbcon.php');

    if (isset($_POST['submitChat'])) {


        //getting session variables
     
        $text = $_POST['chatsInput'];
        $phonenumber = $_SESSION['phonenumber'];
        $fullname = $_SESSION['fullname'];
        
        $seller = $_POST['hiddenid'];
        $ref_table ="Adverts";
        $fetchData = $database->getReference($ref_table)->getValue();
    
        if($fetchData >0) {
            foreach($fetchData as $key =>$row){
                if($row['id'] === $seller) {
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

                        $receiver = $row['email'];
                        $message = "You have a message from $fullname phone number: $phonenumber. <br> 
                        Go to www.locationbasedecommerce.xyz to view it.";
                        $subject = "Message From potential customer";
                       $messageSent = $_SESSION['messageSent'];

                        if($messageSent != "Message Sent") {
                            mail($receiver,$subject,$message);
                            $_SESSION['messageSent'] = "Message Sent";
                        }
                    
                        echo "<script>location.replace('../mainpages/chat.php?seller=$seller');</script>"; 
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
    <!--Bootstrap css Links -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!--Bootstrap JS Links -->
    <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
    
    <!--Jquery links-->
    <script
            src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous">
    </script>

    <!--Emojis links-->
        <script src="../js/emojionearea.min.js"></script>
        <script src="../js/emojionearea.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/emojionearea.min.css">


    <script>
	
    $(document).ready(function () {
        $('#chatinput').emojioneArea({
            pickerPosition: "top"
            
        
        })
    })
    
</script>


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
        
    $phonenumber = $_SESSION['phonenumber'];
    $fullname = $_SESSION['fullname'];

    $seller = $_GET['seller'];  
    include_once('../FirebaseConfig/dbcon.php');
            
    $phonenumber = $_SESSION['phonenumber'];

    $ref_table ="Adverts";
    $fetchData = $database->getReference($ref_table)->getValue();

    if($fetchData >0) {
        foreach($fetchData as $key =>$row){
            if($row['id'] === $seller) {
                  //assign rows from database to variables
                $accountName = $row['accountName'];
                $sellerPhonenumber = $row['phonenumber'];

                echo"
                <div class='row'  style='display: sticky; margin-top: 10px;'>
                <div class='col-sm-12' id='chatboxHeader'>
                    <h3 id='h3top'>".$accountName."</h3>
                    <p id='ptop'>Phone: ".$sellerPhonenumber."</p>
                </div>
            
                ";

                $ref_table ="chats";
                $fetchData = $database->getReference($ref_table)->getValue(); 

                if($fetchData >0) {
                    foreach($fetchData as $key =>$row){
                if($row['buyerPhonenumber'] === $phonenumber && $row['accountName'] === $accountName && $row['sellerPhonenumber'] === $sellerPhonenumber) {
                            
                    if($row['buyerPhonenumber']=== $_SESSION['phonenumber']){
                                     
                        echo "
                                    
                                    
                        <div style='height: auto; width:auto; margin: 20px; padding: 10px;background-color: lightblue; margin-left:40%;
                         border-radius: 10px;'>
                         
                        
                         ".$row['message']."</div>
                      
                    
                        ";
                    
                    }else{
                        echo "
                                    
                                    
                        <div style='height: auto; width:auto; margin-right: 40%; padding: 10px;background-color: lightgreen; 
                         border-radius: 10px; border-radius: 10px;margin-bottom: 10px; '>
                       
                         ".$row['message']."</div>
                      
                    
                        ";
                    
                    }
                }
            }
        }
    }

}
}

    ?>

</div>
          
    
        </div>
    
    </div>

  
    <div class="container" id="createText">
                <form action="chat.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name= "hiddenid" value=<?php $id= $_GET['seller']; echo $id; ?>> <!-- Hidden input-->
                <p>
                <input style="display: none;margin-top: 1%;" id="chatinput" type="text" name="chatsInput" placeholder="Type message" required>
                <button name="submitChat" id="btnChat" style="width: 90%;height:2%; margin: 1%;">Chat</button>
                </p>
                </form>
            </div>
  
</div>    

</body>
</html>