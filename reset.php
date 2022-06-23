<?php
session_start();

$phonenumber = $securitykey = $password = $passwordconfirm = '';

$errors = array("passwordErr" => "", "success" =>"");

    //Requiring DB configs
include_once('./FirebaseConfig/dbcon.php');

if(isset($_POST['submit'])){

    
    $securitykey= $_POST['securitykey'];
    $phonenumber= $_POST['phonenumber'];
    $password= $_POST['password'];
    $passwordconfirm= $_POST['passwordconfirm'];

    if(empty($securitykey) || empty($phonenumber) || empty($password) || empty($passwordconfirm)) {
        $errors['passwordErr'] = "Fill all fields.";
    } 
        if(!($password == $passwordconfirm)){
            $errors['passwordErr'] = "Password doesn't match with its confirmation. Try again.";
            
        
        }elseif(($password == $passwordconfirm)){
            $securitykey1 = md5($securitykey);//Encrypting Security Key

            $ref_table ="authentication";
            $fetchData = $database->getReference($ref_table)->getValue();
        
            if($fetchData >0) {
                foreach($fetchData as $key =>$row){
                    if($row['phonenumber'] === $phonenumber && $row['securitykey'] === $securitykey1) {
                        
                $password1 = md5($password); //encryption of password

                //Update Table Password
                $uid = $key;
                $UpdateData = [
                    'fullname' => $row['fullname'],
                    'password' => $password1,
                    'phonenumber' => $row['phonenumber'],
                    'securitykey' => $row['securitykey'], 
              
                ];

                // Create a key for a new post
                $ref_table = 'authentication/'.$uid;
                 $queryResult = $database->getReference($ref_table)->update($UpdateData);
              
                if($queryResult >0) {

                //set session variables
                $_SESSION['fullname'] = $row['fullname'];
                $_SESSION['phonenumber'] = $row['phonenumber'];
                $errors['success'] ="Update successful. You are now logged in.";
            
                    echo "<script>location.replace('index.php')</script>"; 
                }else{
                    $errors['phonenumberErr'] = "Failed to update, try again later";
           
                }


            }else{

            $errors['phonenumberErr'] = "No user with those details in the system. Please try again. Ensure you fill your details correctly.";
           
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

<div class = "container" id="headerbody">

    <div class="row">
        <div class="col-sm-12">
            <p id="topparagraph" style="font-size: 20px; margin-top: 5px;">Reset Password:</p>
        </div>
    </div> <br>

    <div class="row" id="topparagraph">
        <div class="col-sm-12">
            <form action="reset.php" method="post">
            
                <input class="reginput" type="number" name ="phonenumber" placeholder="Enter your Phonenumber" value="<?php echo $phonenumber;?>"><br><br>
                <input  class="passinput" type="text" name = "securitykey" placeholder ="Enter your Security Key" value="<?php echo $securitykey;?>"> <br><br>
                <input  class="passinput" type="password" name = "password" placeholder ="Create new password" value="<?php echo $password;?>"> <br><br>
                <input  class="passinput" type="password" name = "passwordconfirm" placeholder ="Repeat password" value="<?php echo $passwordconfirm;?>"> <br><br>
                
                <!--Error display-->
                <div><h3 style="color: green;"><?php echo $errors['success']; ?></h3></div>
                <div><h3 style="color: red;"><?php echo $errors['passwordErr']; ?></h3></div>
                
                <button name="submit" title="sign Up" >Reset</button>

            </form>
        </div>
    </div> <br><br>


 <div class="row" id="topparagraph">
        <div class="col-sm-12" id ="bottomdiv">
            <a href="signup.php"> Register.</a> <br><br>
            <a id="reset" href="index.php"> Back to login page.</a>
            
        </div>
    </div>

</div>
 
</body>
</html>