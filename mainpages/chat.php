<?php 
    session_start();



    if (isset($_POST['submitChat'])) {


        //getting session variables
     
        $text = mysqli_real_escape_string($con, $_POST['chatsInput']);
        $phonenumber = $_SESSION['phonenumber'];
        $fullname = $_SESSION['fullname'];
        
        $seller = $_POST['hiddenid'];


  
        $sql = "SELECT * FROM adverts where id='$seller'";
        $data2= mysqli_query($con,$sql);
        $queryResults2= mysqli_num_rows($data2);
        
  
        
         if($queryResults2 >0) {
                   while($row = mysqli_fetch_assoc($data2)) {
                
                    $accountName = $row['accountName'];
                    $sellerPhonenumber = $row['phonenumber'];
                    
                    $sql = "INSERT INTO chats(buyerPhonenumber,fullname,sellerPhonenumber,accountName,message) 
                    VALUES('$phonenumber','$fullname','$sellerPhonenumber','$accountName','$text');";

                    $res = mysqli_query($con,$sql);
                                        
                                    
                    if($res ==1){

                   
                    echo "<script>location.replace('../mainpages/chat.php?seller=$seller');</script>";    
                        
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
    <title>zero The market</title>

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
<div class='col-sm-6' id='chatboxBody'>
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
                <div class='row'>
                <div class='col-sm-12' id='chatboxHeader'>
                    <h3 id='h3top'>".$accountName."</h3>
                    <p id='ptop'>Phone: ".$sellerPhonenumber."</p>
                </div>
            
                ";

                $ref_table ="chats";
                $fetchData = $database->getReference($ref_table)->getValue(); 

                if($row['buyerPhonenumber'] === $phonenumber && $row['accountName'] === $accountName && $row['sellerPhonenumber'] === $sellerPhonenumber) {
                            
                    if($row['buyerPhonenumber']== $_SESSION['phonenumber'] && !$row['additional']){
                                     
                        echo "
                                    
                                    
                        <div style='height: auto; width:auto; margin: 20px; padding: 10px;background-color: lightblue; margin-left:40%;
                         border-radius: 10px;'>
                         
                        
                         ".$row['message']."</div>
                      
                    
                        ";
                    
                    }elseif($row['additional'] ==1){
                        echo "
                                    
                                    
                        <div style='height: auto; width:auto; margin-right: 40%; padding: 10px;background-color: lightgreen; 
                         border-radius: 10px; border-radius: 10px;margin-bottom: 10px; '>
                       
                         ".$row['message']."</div>
                      
                    
                        ";
                    
                    }else {

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
                <form action="chat.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name= "hiddenid" value=<?php $id= $_GET['seller']; echo $id; ?>> <!-- Hidden input-->
                <p>
                <input id="chatinput" type="text" name="chatsInput" placeholder="Type message" required>
                <button name="submitChat" id="btnChat">Chat</button>
                </p>
                </form>
            </div>
  
</div>    

</body>
</html>