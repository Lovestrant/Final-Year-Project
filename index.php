<?php
session_start();

$phonenumber =$password = '';
$errors = array("phonenumberErr" => "", "success" => "");

include_once('db.php');

if(isset($_POST['submit'])){
   
    $phonenumber = mysqli_real_escape_string($con, $_POST['phonenumber']);
    $password =  mysqli_real_escape_string($con, $_POST['password']);

    $password1 = md5($password); //encrypting password
    $sql1="SELECT * FROM authentication where  phonenumber = '$phonenumber' and password= '$password1' LIMIT 1";
  
    $result= mysqli_query($con,$sql1);
    $queryResults= mysqli_num_rows($result);
    
    if($queryResults) {

        //get latitude and longitude from user location


        //  $_SESSION['longitude'] = $longitude;
        //$_SESSION['latitude'] = $latitude;

        while($row = mysqli_fetch_assoc($result)) {

        //set session variables
        $_SESSION['fullname'] = $row['fullname'];
        $_SESSION['phonenumber'] = $row['phonenumber'];

        //taking user to main page
      //  $errors['success'] = "Login successful.";
      

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
    }else{
        $errors['phonenumberErr'] = "Wrong combinations. Fill your details correctly.";
     
       
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
</head>



<body>

<div class="col-sm-12">
        <?php include_once('header1.php'); ?>
</div>

<div class="container">
<div class = "row"  id="headerbody">

    <div class="row">
    <div class="col-sm-12">
            <p id="topparagraph" style="font-size: 25px">Login to Location-Based E-commerce System:</p>
        </div>
    </div>
    <br><br>

    <div class="row">
    <div class="col-sm-12" id="topparagraph">
            <form action="index.php" method="post">
                <input class="reginput" type="number" name ="phonenumber" placeholder="Enter your Phone Number" value="<?php echo $regNo;?>"><br><br>
                <input  class="passinput" type="password" name = "password" placeholder ="Enter password" value="<?php echo $password;?>"> <br><br>
            
            <!--Error display-->
            <div><h5 style="color: red;"><?php echo $errors['phonenumberErr']; ?></h5></div>
            <div><h5 style="color: green;"><?php echo $errors['success']; ?></h5></div>
            
                <button type= "submit" name="submit" title="Login">Login</button>

            </form>
        </div>
    </div>

    <br>
    <div class="row" id="topparagraph">
    <div class="col-sm-12" id ="bottomdiv">
            <a href="signup.php" id="register">Create A new Account</a><br><br>
            <a id="reset" href="reset.php">Forgot Password</a>
            
    </div>
    </div>

</div>

</div>

    
</body>
</html>