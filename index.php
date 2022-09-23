<?php
session_start();

$phonenumber=$regNo =$password = '';
$errors = array("phonenumberErr" => "", "success" => "");


    //Requiring DB configs
    include_once('./FirebaseConfig/dbcon.php');

if(isset($_POST['submit'])){
    $_SESSION['LoginSuccess'] = "false"; 
    $phonenumber = $_POST['phonenumber'];
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
                <input class="reginput" type="text" name ="phonenumber" placeholder="Enter your Phone Number" value="<?php echo $regNo;?>"><br><br>
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