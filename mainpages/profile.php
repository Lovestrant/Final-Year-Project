<?php 
    session_start();

    include_once('../db.php');
    //initializing errors array
    $errors = array("error" => "", "success" => "");

    if (isset($_POST['updateProfile'])) {

    //getting session variables
    $phonenumber = $_SESSION['phonenumber'];


        $sql="SELECT * FROM authentication where phonenumber='$phonenumber'";

        $data= mysqli_query($con,$sql);
        $queryResults= mysqli_num_rows($data);
        
        if($queryResults >0) {
          
            $imgurl = $_FILES['file']['name'];
            $tmp = $_FILES['file']['tmp_name'];
            move_uploaded_file($tmp,"../files/profiles/profiles".$imgurl);

            $sql = "UPDATE authentication set imgurl = '$imgurl' where phonenumber= '$phonenumber'";
            $res = mysqli_query($con,$sql);
            
            if($res ==1){
        
            $errors['success'] ="Profile Updated Successfully.";
                                
              }
                   
            }else{
                $errors['error'] ="No such User.";
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
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <!--Bootstrap css Links -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!--Bootstrap JS Links -->
    <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>

</head>



</head>
<body>
<div class="col-sm-12">
    <?php include_once('../header.php'); ?>
</div>

<div class = "container"> 

    <div class="row">
<div class = "row" style="margin-left: 5%;margin-top: 2%;text-align:center;">
  
    <?php 
    
    if($_SESSION['phonenumber']){



        include_once('../db.php');
          
        $phonenumber = $_SESSION['phonenumber'];
      
    
            $sql="SELECT * FROM authentication where phonenumber='$phonenumber'";

 
                   $data2= mysqli_query($con,$sql);
                   $queryResults2= mysqli_num_rows($data2);
                   
         
                   
                    if($queryResults2 >0) {
                              while($row = mysqli_fetch_assoc($data2)) {
                           
                                if(empty($row['imgurl'])) {
                                    $TheDefaultLink = "DefaultIMG.PNG";
                                    echo "  
                                    <div style='margin-top: 5%; text-align:centre; margin-bottom: 5%;'>
                                    <img src='../files/profiles/".$TheDefaultLink."' style = 'width: 20%;border-radius:100%; height:auto;'>
                                        
                                  ";
                                  
                                }else{
                                    echo "  
                                    <div style='margin-top: 5%; text-align:centre; margin-bottom: 5%;'>
                                    <img src='../files/profiles/profiles".$row['imgurl']."' style = 'width: 20%;border-radius:100%; height:auto;'>
                                        
                                  ";
                                  
                                }

                            }
                        }
         }else{
            echo "<script>alert('Your Session has expired.You need to login again')</script>";
            echo "<script>location.replace('../index.php')</script>";
         }

                              
    ?>

<div class="row" style="margin: 3%;" style="text-align: centre; width: 100px;">
 <div class="col-sm-12">
    <form action = "profile.php" method="post" enctype="multipart/form-data">

        <input type="file" accept ="image/*" name="file" style="text-align: centre;"><br><br>
        <button name="updateProfile">Change Profile</button>
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
     <div class="col-sm-4">
      <button style="color: grey;margin-bottom: 2%;" id="viewaccounts"><a href="viewmessages.php"  id="viewaccounts">Personal Messages</a></button>
      </div>
    <div class="col-sm-4">
    <a href="businessAccount.php">
    <button style="color: green;margin-bottom: 2%;">Create new Business Account</button>
    </a>

    </div>

      <div class="col-sm-4">
      <button  id="viewaccounts"><a href="viewaccounts.php"  id="viewaccounts">See your Business Accounts</a></button>
      </div>

</div>


    <div style="text-align: left; margin-bottom:3%;padding: 1%;"> <br><br>
<form action="../logout.php">
<button style="color:red;">Log Out</button>
</form>
</div>


</div>


</div>



</body>
</html>