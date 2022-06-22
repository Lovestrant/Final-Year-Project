<?php
session_start();

//initializing input values
$fullname = $password = $passwordconfirm = $securitykeyConfirm = $securitykey =$phonenumber = '';

$errors = array("Err" => "", "passwordErr" => "", "success" => "");

include_once('db.php');


if(isset($_POST['submit'])){

    $fullname = mysqli_real_escape_string($con, $_POST['fullname']);
    $securitykeyConfirm = mysqli_real_escape_string($con, $_POST['securitykeyConfirm']);
    $securitykey = mysqli_real_escape_string($con, $_POST['securitykey']);
    $phonenumber = mysqli_real_escape_string($con, $_POST['phonenumber']);
   
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $passwordconfirm = mysqli_real_escape_string($con, $_POST['passwordconfirm']);
   
     
     if($password != $passwordconfirm || $securitykey != $securitykeyConfirm){
         $errors['passwordErr'] = "Password or security key with their confirmations does not match";
      
     }elseif(empty($fullname) || empty($securitykey)|| empty($securitykeyConfirm)||empty($password) || empty($passwordconfirm) || empty($phonenumber)){

        $errors['Err'] = "Fill all the fields.";
     }else{

        $sql1="SELECT * FROM authentication where phonenumber = '$phonenumber' Limit 1";
    
		$result= mysqli_query($con,$sql1);
		$queryResults= mysqli_num_rows($result);
		
		
        if($queryResults) {

            $errors['passwordErr'] = "A user with same phonenumber already exist.";
           // echo"<script>alert('A user with same phone number already exist. Try again with a different number.')</script>"; 
        }else{
           $password1 = md5($password);//encryption of password
           $securitykey2 = md5($securitykey);

            $sql = "INSERT INTO authentication (fullname, phonenumber,securitykey, password) VALUES ('$fullname', '$phonenumber','$securitykey2','$password1')";
		    $res = mysqli_query($con,$sql);
		
	
		if($res ==1){

        //set session variables
        $_SESSION['fullname'] = "$fullname";
        $_SESSION['phonenumber'] = "$phonenumber";
      

        $errors['success'] = "Registration successful. You are now logged in.";
		
           
      echo "
      <script>
              navigator.geolocation.getCurrentPosition(function(pos) {
                  var ab = pos.coords.latitude;
                  var ac = pos.coords.longitude;
                  window.open('mainpages/radius.php?lat=' + ab + '&long=' + ac, '_self')
              });
          
      </script>

      "; 
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
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <!--Bootstrap css Links -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!--Bootstrap JS Links -->
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

<script>
function adminLogin() {
    location.replace("home.php");
}

</script>


</head>
<body>
<div class="col-sm-12">
        <?php include_once('header1.php'); ?>
</div>

<div class = "container" id="headerbody">
<div class = "row" style='margin-top: -2%;'>

    <div class="row">
        <div class="col-sm-12">
            <p id="topparagraph" style="font-size: 20px; margin-top: 5px;">Create An Account:</p>
        </div>
    </div>

    <div class="row">
    <div class="col-sm-12" id="topparagraph">
            <form action="signup.php" method="post">

                <div><h5 style="color: red;"><?php echo $errors['Err']; ?></h5></div>

                <input  class="reginput" type="text" name = "fullname" placeholder ="Enter Full Name" value="<?php echo $fullname;?>"> <br><br>
            
                <input  class="passinput" type="number" name = "phonenumber" placeholder ="Phone Number" value="<?php echo $phonenumber;?>"> <br><br>
                <input  class="passinput" type="text" name = "securitykey" placeholder ="Set Security Key" value="<?php echo $securitykey;?>"> <br><br>
                <input  class="passinput" type="text" name = "securitykeyConfirm" placeholder ="Confirm Security Key" value="<?php echo $securitykeyConfirm;?>"> <br><br>
                
                <input  class="passinput" type="password" name = "password" placeholder ="Set password" value="<?php echo $password;?>"> <br><br>
                <input  class="passinput" type="password" name = "passwordconfirm" placeholder ="Repeat password" value="<?php echo $passwordconfirm;?>"> <br><br>
            
                <div><h3 style="color: red;"><?php echo $errors['passwordErr']; ?></h3></div>
                <div><h3 style="color: green;"><?php echo $errors['success']; ?></h3></div>

                <button name="submit" title="sign Up" >Sign Up</button>

            </form>
        </div>
    </div> <br> 


    <div class="row" id="topparagraph">
    <div class="col-sm-12" id ="bottomdiv">
         
        <a id="reset" href="index.php"> Go back to login page.</a>
        
    </div>
    </div>

</div>

</div>

</body>
</html>