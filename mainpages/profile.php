<?php 
    session_start();

    $_SESSION['windowTabbed'] = "Profile";
    include_once('../FirebaseConfig/dbcon.php');
    //initializing errors array
    $errors = array("error" => "", "success" => "");

    if (isset($_POST['updateProfile'])) {

            //getting session variables
    $phonenumber = $_SESSION['phonenumber'];

        $ref_table ="profilePictures";
        $fetchData = $database->getReference($ref_table)->getValue();
        if($fetchData >0) {
            foreach($fetchData as $key =>$row){
                if($row['phonenumber'] == $phonenumber) { 

                $imgurl = $_FILES['file']['name'];
                $tmp = $_FILES['file']['tmp_name'];
                move_uploaded_file($tmp,"../files/profiles/profiles".$imgurl);

                $uid = $key;
                $UpdateData = [
                    "imgurl" => $imgurl,
                    'phonenumber' => $row['phonenumber'],
               
              
                ];

                $postData = [
                
                    "phonenumber" => $phonenumber,
                    "imgurl" => $imgurl,
                
                ];
                

                // Create a key for a new post
                $ref_table = 'profilePictures/'.$uid;
                 $queryResult = $database->getReference($ref_table)->update($UpdateData);
              
                if($queryResult) {
                    $errors['success'] ="Profile Updated Successfully.";
                }else {
                    $errors['error'] ="Failed, Try again later";
                }
            } 
          }
        } else {

            $imgurl = $_FILES['file']['name'];
            $tmp = $_FILES['file']['tmp_name'];
            move_uploaded_file($tmp,"../files/profiles/profiles".$imgurl);
        
            $postData = [
             
                "phonenumber" => $phonenumber,
                "imgurl" => $imgurl,
               
            ];
            
        
            $postRef = $database->getReference($ref_table)->push($postData);
        
            if($postRef) {
                $errors['success'] ="Profile Updated Successfully.";
            }else {
                $errors['error'] ="Failed, Try again later";
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
    <link rel="stylesheet" type="text/css" href="../css/home.css">
    <!--Bootstrap css Links -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!--Bootstrap JS Links -->
    <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>


</head>
<body>
<div class="col-sm-12">
    <?php include_once('../header.php'); ?>
</div>

<div class = "container"> 

    <div class="row">
<div class = "row" style="margin-left: 5%;margin-top: 4%;text-align:center;">
  
    <?php 
    
    if($_SESSION['phonenumber']){



  include_once('../FirebaseConfig/dbcon.php');
          
        $phonenumber = $_SESSION['phonenumber'];
      
        $ref_table ="profilePictures";
        $fetchData = $database->getReference($ref_table)->getValue();
    
        if($fetchData >0) {
            foreach($fetchData as $key =>$row){
                if($row['phonenumber'] === $phonenumber) {

                    echo "  
                    <div style='margin-top: 5%; text-align:centre; margin-bottom: 5%;'>
                    <img src='../files/profiles/profiles".$row['imgurl']."' style = 'width: 20%;border-radius:100%; height:auto;'>
                        
                    ";
                      
                    
                }else {
                    $TheDefaultLink = "DefaultIMG.PNG";
                    echo "  
                    <div style='margin-top: 5%; text-align:centre; margin-bottom: 5%;'>
                    <img src='../files/profiles/".$TheDefaultLink."' style = 'width: 20%;border-radius:100%; height:auto;'>

                  ";
                  
                }
            }
        }else {
            $TheDefaultLink = "DefaultIMG.PNG";
            echo "  
            <div style='margin-top: 5%; text-align:centre; margin-bottom: 5%;'>
            <img src='../files/profiles/".$TheDefaultLink."' style = 'width: 20%;border-radius:100%; height:auto;'>

          ";
          
        }
                   
         } else{
            echo "<script>alert('Your Session has expired.You need to login again')</script>";
            echo "<script>location.replace('../index.php')</script>";
         }

                              
    ?>

<div class="row" style="margin: 3%;" style="text-align: centre; width: 100px;">
 <div class="col-sm-12">
    <form action = "profile.php" method="post" enctype="multipart/form-data">

        <label style="color: black;"> <input style="display: none;" type="file" name="file" accept="image/*" >Choose Profile picture</label> <br><br>
        <button name="updateProfile" class='btn btn-warning'>Change Profile</button>
    </form>

    <div><h5 style="color: red;"><?php echo $errors['error']; ?></h5></div>
     <div><h5 style="color: green;"><?php echo $errors['success']; ?></h5></div>

 </div> 

 </div>


<div class="row">
 <div class="col-sm-12" style="margin-bottom: 1%;">
     <?php echo" 
       <p>Full name: <label style='color:red;'>".$_SESSION['fullname']."</label></p>
        <p> PhoneNumber: <label style='color:red;'>".$phonenumber."</label></p>
      <br>
     "; ?>
  </div>
  
 </div>

<div class="row">
     <div class="col-sm-3">
      <button style="color: grey;margin-bottom: 2%;" id="viewaccounts" class='btn btn-info'><a href="viewmessages.php"  id="viewaccounts">Personal Messages</a></button>
      </div>
    <div class="col-sm-3">
    <a href="businessAccount.php" >
    <button id="viewaccounts" style="color: green;margin-bottom: 2%;" class='btn btn-secondary'>Create Business Account</button>
    </a>

    </div>

      <div class="col-sm-3">
      <button id="viewaccounts"  class='btn btn-warning'><a href="viewaccounts.php" >Your Business Accounts</a></button>
      </div>
     
      <div class="col-sm-3">
      <button id="viewaccounts"  class='btn btn-secondary'><a href="myorders.php" >Your Orders</a></button>
      </div>
       

</div>
<div style="text-align: centre; margin-bottom:3%;padding: 1%;"> <br><br>

<?php 
 
 if($_SESSION['phonenumber'] != "+254791638771") {
   echo "
   <button  id='viewaccounts' class='btn btn-success'><a href='admin.php'>Raise Issue to Admin</a></button>
   ";
 }

 
  if($_SESSION['phonenumber'] === "+254791638771") {
    echo "
    <div class='container'>
    <button  id='viewaccounts' class='btn btn-success'><a href='users.php'>ADMIN PANEL</a></button>
    </div>
    ";
  }
 
 ?>
</div>


<div style="text-align: centre; margin-bottom:3%;padding: 1%;"> <br><br>
<form action="../logout.php">
<button style="color:white;" class="btn btn-danger">Log Out</button>
</form>
</div>


</div>


</div>



</body>
</html>