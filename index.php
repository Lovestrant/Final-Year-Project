<?php
session_start();

$phonenumber=$regNo =$password = '';
$errors = array("phonenumberErr" => "", "success" => "");

// if(!$_SESSION['phonenumber']){
//     echo "<script>alert('Ensure you turn on location before Sign Up / Sign In');</script>";
// }

    //Requiring DB configs
    include_once('./FirebaseConfig/dbcon.php');

if(isset($_POST['submit'])){
    $_SESSION['LoginSuccess'] = "false"; 
    $ThePhonenumber = $_POST['phonenumber'];
    
    //Ensure Phonenumber has country code.
    if($ThePhonenumber[0] === "0") {
        $phonenumber = "+254".substr($ThePhonenumber,1, 9);
    }else if($ThePhonenumber[0] === "+") {
        $phonenumber = $ThePhonenumber;
    }

    $password = $_POST['password'];
    $password1 = md5($password); //encrypting password
    
       
        $ref_table ="authentication";
        $fetchData = $database->getReference($ref_table)->getValue();
    
        if($fetchData >0) {
            foreach($fetchData as $key =>$row){
                
                if($row['phonenumber'] == $phonenumber && $row['password'] == $password1) {
                    
                    if($row['status'] === 'blocked') {
                        $errors['phonenumberErr'] = "You got blocked by Admin, contact him at<br> Email: kemboilovestrant@gmail.com 
                        <br> or WhatsApp: +254791638771 <br> for feedback.";  

                        }else {

                            //set session variables
                            $_SESSION['fullname'] = $row['fullname'];
                            $_SESSION['phonenumber'] = $row['phonenumber'];
                            $_SESSION['email'] = $row['email'];
                    
                            //taking user to main page
                            $errors['success'] = "Login successful.";
                        
                            $_SESSION['LoginSuccess'] = "true";
                    
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

            if($_SESSION['LoginSuccess'] != "true" && $row['status'] != 'blocked'){
                $errors['phonenumberErr'] = "Wrong combinations. Fill your details correctly.";
            }else if($row['status'] == 'blocked') {
                $errors['phonenumberErr'] = "You got blocked by Admin, contact him at<br> <p style='color: green;'>Email: kemboilovestrant@gmail.com </p>
                <br> or <p style='color: green;'> WhatsApp: +254791638771 <br> for feedback. </p> <br>";    
            }
    
        } else{
            $errors['phonenumberErr'] = "you don't have an account. Create account";  
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

<!--Bootstrap css Links -->
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<!--Bootstrap JS Links -->
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

<!--Css link-->
<link rel="stylesheet" type="text/css" href="css/index.css">


</head>



<body>

<div class="col-sm-12">
        <?php include_once('header1.php'); ?>
</div>

<div class="container">
<div class = "row"  id="headerbody">

    <div class="row">
    <div class="col-sm-12">
        <br>
            <p id="topparagraph" style="font-size: 20px">Login to Location-Based E-commerce System:</p>
           
        </div>
    </div>
    <br><br>

    <div class="row">
    <div class="col-sm-12" id="topparagraph" style="text-align: center; font-style: bold; background: lightgrey;border-radius: 20px;">
            <form action="index.php" method="post">
                <br>
            <p  style="color: green;text-align:centre;">Ensure location is turned on before proceeding</p>
                <input class="reginput"  type="text" name ="phonenumber" placeholder="Enter your Phone Number" value="<?php echo $regNo;?>"><br><br>
                <input  class="passinput" type="password" name = "password" placeholder ="Enter password" value="<?php echo $password;?>"> <br><br>
            
            <!--Error display-->
            <div><h5 style="color: red;"><?php echo $errors['phonenumberErr']; ?></h5></div>
            <div><h5 style="color: green;"><?php echo $errors['success']; ?></h5></div>
            
                <button class='btn btn-success' style='width: auto;' type= "submit" name="submit" title="Login">Login</button>

            </form>

            <br>
    <div class="row" id="topparagraph" >
    <div class="col-sm-12" id ="bottomdiv">
            <a href="signup.php" id="register">Create A new Account</a><br><br>
            <a id="reset" href="reset.php">Forgot Password</a>
            <br>
    </div>
    </div>
        </div>
    </div>



</div>

</div>

    
</body>
</html>