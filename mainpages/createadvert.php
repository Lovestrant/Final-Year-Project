<?php 
    session_start();

    //initializing values
    $accountname = $description = $price ="";

    //Requiring DB configs

    include_once('../FirebaseConfig/dbcon.php');

    //initializing errors array
    $errors = array("error" => "", "success" => "", "Err" => "");

    if (isset($_POST['createBiz'])) {


      //getting session variables
      $phonenumber = $_SESSION['phonenumber'];
      $description = $_POST['description'];
      $adtitle = $_POST['adtitle'];
      $price = $_POST['price'];
     // $picurl = $_FILES['file']['name']; 
      $accId = $_POST['hiddenid'];
      $payOption = $_POST['payOption'];
      

      $ref_table ="bizaccounts";
      $fetchData = $database->getReference($ref_table)->getValue();
  
      if($fetchData >0) {
          foreach($fetchData as $key =>$row){
            if($key === $accId) {
                $accountName = $row['accountName'];
                $Bizdescription = $row['description'];
                $location = $row['location'];
                $latitude = $_SESSION['latitude'];
                $longitude = $_SESSION['longitude'];
                $status = $row['status'];
                
                if($status == "blocked") {
                    $errors['Err'] = "
                 <h3 style='color: red;'>Oohps!! Your business Account Got blocked By Admin, 
                 You therefore can't create adverts</h3> <br> Contact Admin at <p style='color: green;'>Email: kemboilovestrant@gmail.com </p>
                 <br> or <p style='color: green;'> WhatsApp: +254791638771 <br> for feedback. </p> <br>
                 Chat with admin here <button  id='viewaccounts'><a href='admin.php'>Raise Issue to Admin</a></button>
                 <br><br>
                 ";

                }else{
                    if(!empty($description) && !empty($adtitle)) {
    
                        //Insert Data Into Folder Storage In Hosting Space
        
                        $picurl = $_FILES['file']['name'];
                        $tmp = $_FILES['file']['tmp_name'];
                        move_uploaded_file($tmp,"../files/adpics/adpics".$picurl);
                        //Second Ad pic upload
                        
                        $picurl2 = $_FILES['file2']['name'];
                        $tmp = $_FILES['file2']['tmp_name'];
                        move_uploaded_file($tmp,"../files/adpics/adpics".$picurl2);
        
                        //Insert Data Into firebase Realtime Database
                        
                        $postData = [
                            "phonenumber" => $phonenumber,
                            "id" => $accId,
                            "adtitle" => $adtitle,
                            "picurl" => $picurl,
                            "price" => $price,
                            "description" => $Bizdescription,
                            "location" => $location,
                            "longitude" => $longitude,
                            "latitude" => $latitude,
                            "picurl2" => $picurl2,
                            "accountName" => $accountName,
                            "email" => $_SESSION['email'],
                            "payOption" => $payOption
                        ];
                        
                        $ref_table = "Adverts";
                        $postRef = $database->getReference($ref_table)->push($postData);
                        
                    
                        if($postRef){
                    
                        $errors['success'] ="Ad Creation Success.";
                        //echo "<script>alert('Ad Creation Success.')</script>"; 
                        //echo "<script>location.replace('../mainpages/createadvert.php?acc_id=$accId');</script>"; 
                    
                        }
                        
                        }else{
                             $errors['error'] ="Fill all required fields and choose a ad picture.";
                           // echo "<script>alert('Fill all required fields and choose ad pictures if necessary.')</script>"; 
                           // echo "<script>location.replace('../mainpages/createadvert.php?acc_id=$accId');</script>"; 
                        }
                    
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
    <link rel="stylesheet" type="text/css" href="../css/bizaccounts.css">
    <!--Bootstrap css Links -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!--Bootstrap JS Links -->
    <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>

</head>



</head>
<body>
<div class = "container-fluid">
    <div class = "row">
    
        <div class="col-sm-12">
        <?php include_once('../header.php'); ?>
        </div>
            
    
    </div>


    <div class="row">

        <div class="col-sm-12" id="bizaccform">
      
        <h4>Create advert:</h4>
        <div><h5 style="color: red;"><?php echo $errors['Err']; ?></h5></div>
            <form  action="createadvert.php?acc_id=<?php echo $_GET['acc_id'];?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name= "hiddenid" value=<?php $id= $_GET['acc_id']; echo $id; ?>> <!-- Hidden input-->

            <input class="passinput" type ="text" name="adtitle" placeholder="Enter advert name" value="<?php echo $accountname; ?>"><br><br>
            <input class="passinput" type="text" name="description" placeholder="Enter advert Description"  value="<?php echo $description;?>"> <br><br>
            <input class="passinput" type="text" name="price" placeholder="Enter Price  (optional)" value="<?php echo $price; ?>"><br><br>
            
            <select name="payOption" id="cars" style="width: 200px;">
            <option value="NotMust">Pay on Delivery</option>
            <option value="mustpay">Must Pay before order</option>
            </select>
            <br><br>

           <label style="color: black;"> <input style="display: none;" type="file" name="file" accept="image/*" >Choose ad picture</label> <br><br>
           <label style="color: black;"> <input style="display: none;" type="file" name="file2" accept="image/*" >Choose ad picture 2 </label> 
            <br><br>
            
        <!--Error display-->
        <div><h5 style="color: red;"><?php echo $errors['error']; ?></h5></div>
        <div><h5 style="color: green;"><?php echo $errors['success']; ?></h5></div>

          <button name="createBiz">Create Advert</button>
        
            </form>
        </div>
    </div>
</div>




</body>
</html>