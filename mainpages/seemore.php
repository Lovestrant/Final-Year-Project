<?php 
    session_start();

    include_once('../FirebaseConfig/dbcon.php');

    if(isset($_POST['BlockAccount'])) {
        $Thekey = $_POST['key'];
       
        $ref_table ="bizaccounts";
        $fetchData = $database->getReference($ref_table)->getValue();
       
        if($fetchData >0) {
            foreach($fetchData as $key =>$row){
           if($key == $Thekey) {
                    
            //Update Table Password
            $uid = $key;
            $UpdateData = [
                'accountName' => $row['accountName'],
                'description' => $row['description'],
                'location' => $row['location'],
                'phonenumber' => $row['phonenumber'],
                'profileurl' => $row['profileurl'],
                'status' => "blocked"
       
            ];
       
            // Create a key for a new post
            $ref_table = 'bizaccounts/'.$uid;
             $queryResult = $database->getReference($ref_table)->update($UpdateData);
             if($queryResult) {
                
       
            
             }
        }
       }
      }
    }


    if(isset($_POST['unBlockAccount'])) {
        $Thekey = $_POST['key'];
       
        $ref_table ="bizaccounts";
        $fetchData = $database->getReference($ref_table)->getValue();
       
        if($fetchData >0) {
            foreach($fetchData as $key =>$row){
           if($key == $Thekey) {
                    
            //Update Table Password
            $uid = $key;
            $UpdateData = [
                'accountName' => $row['accountName'],
                'description' => $row['description'],
                'location' => $row['location'],
                'phonenumber' => $row['phonenumber'],
                'profileurl' => $row['profileurl'],
                'status' => "Notblocked"
       
            ];
       
            // Create a key for a new post
            $ref_table = 'bizaccounts/'.$uid;
             $queryResult = $database->getReference($ref_table)->update($UpdateData);
             if($queryResult) {
                
       
            
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
    <?php 
            $id= $_GET['key'];
            $phone = $_GET['phone'];
            $email = $_GET['email'];
            $name = $_GET['name'];

            echo "
            <br><br>
            <h3 style='color: green;'>More Info on User: $name</h3>
            <h4 style='color: red;'>Business Accounts</h4>
            ";


                 $ref_table ="bizaccounts";
                 $fetchData = $database->getReference($ref_table)->getValue();
             
                 if($fetchData >0) {
                     foreach($fetchData as $key =>$row) {

                        if($row['status'] == 'blocked') {
                         $btn = "<button style='color:green;margin: 10px;' name='unBlockAccount'>UnBlock Account</button>";
                        }else{
                         $btn = "<button style='color:red;margin: 10px;' name='BlockAccount'>Block Account</button>";
                        }

                       if($row['phonenumber'] === $phone) {

                        $accountName = $row['accountName'];
                        $description = $row['description'];
                        $location = $row['location'];

                        echo"
                        <div><p>Account Name: $accountName</p></div>
                        <div><p>Description: $description</p></div>
                        <div><p>Location: $location</p></div>

                        <form action='seemore.php?key=$id&phone=$phone&email=$email&name=$name' method='post'>
                        <input type='hidden' value='$key' name='key'>
                        $btn
                        </form>

                        ";
                       }

                }
            }

                
            

    ?>
    </div>

</div>



</body>
</html>