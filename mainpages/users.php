<?php 
session_start();
//Requiring DB configs
include_once('../FirebaseConfig/dbcon.php');


if(isset($_POST['BlockUser'])) {
 $Thekey = $_POST['key'];

 $ref_table ="authentication";
 $fetchData = $database->getReference($ref_table)->getValue();

 if($fetchData >0) {
     foreach($fetchData as $key =>$row){
    if($key == $Thekey) {
             
     //Update Table Password
     $uid = $key;
     $UpdateData = [
         'email' => $row['email'],
         'fullname' => $row['fullname'],
         'password' => $row['password'],
         'phonenumber' => $row['phonenumber'],
         'securitykey' => $row['securitykey'],
         'status' => "blocked"

     ];

     // Create a key for a new post
     $ref_table = 'authentication/'.$uid;
      $queryResult = $database->getReference($ref_table)->update($UpdateData);
      if($queryResult) {
         //$errors['success'] ="Ad Creation Success.";

     
      }
 }

}
}
}

if(isset($_POST['unBlockUser'])) {
$Thekey = $_POST['key'];

 $ref_table ="authentication";
 $fetchData = $database->getReference($ref_table)->getValue();

 if($fetchData >0) {
     foreach($fetchData as $key =>$row){
    if($key == $Thekey) {
             
     //Update Table Password
     $uid = $key;
     $UpdateData = [
         'email' => $row['email'],
         'fullname' => $row['fullname'],
         'password' => $row['password'],
         'phonenumber' => $row['phonenumber'],
         'securitykey' => $row['securitykey'],
         'status' => "Notblocked"

     ];

     // Create a key for a new post
     $ref_table = 'authentication/'.$uid;
      $queryResult = $database->getReference($ref_table)->update($UpdateData);
      if($queryResult) {
         //$errors['success'] ="Ad Creation Success.";

     
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
    <title>Document</title>

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

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <br><br>
            <a href='manageOrders.php'><button>MANAGE ORDERS</button></a>
            <br><br>
            <h3>All Users in the system:</h3>
            <?php 
            
            $ref_table ="authentication";
            $fetchData = $database->getReference($ref_table)->getValue();
        
            if($fetchData >0) {
                foreach($fetchData as $key =>$row) {
                 $phone = $row['phonenumber'];
                 $email = $row['email'];
                 $name = $row['fullname'];

                 if($row['status'] == 'blocked') {
                    $blockBtn = "<button style='color:green;margin: 10px;' name='unBlockUser'>UnBlock User</button>";
                 }else {
                    $blockBtn = "<button style='color:red;margin: 10px;' name='BlockUser'>Block User</button>";
                 }
                 
                 echo "
                 <div><p>Name: $name</p></div>
                 <div><p>Phone: $phone</p></div>
                 <div><p>Email: $email</p></div>

                 <div class='row'>
                 <p>
                 <form action='users.php' method='post'>
                 <input type='hidden' value='$key' name='key'>
                 $blockBtn
                 </form>
                 </p>
                 <a href='seemore.php?key=$key&phone=$phone&email=$email&name=$name'><button style='color:blue;margin: 10px;' name='seeMore'>See more Info</button></a>
                 </div>
                 <hr>

                 ";
                }
            }
            
            ?>
        </div>
    </div>
</div>
</body>
</html>