<?php 
    session_start();

    //initializing values
    $accountname = $description = $price ="";

    include_once('../db.php');
    //Requiring DB configs

    include_once('../FirebaseConfig/dbcon.php');

    //initializing errors array
    $errors = array("error" => "", "success" => "");

    if (isset($_POST['createBiz'])) {


      //getting session variables
      $phonenumber = $_SESSION['phonenumber'];
      $description = mysqli_real_escape_string($con, $_POST['description']);
      $adtitle = mysqli_real_escape_string($con, $_POST['adtitle']);
      $price = mysqli_real_escape_string($con, $_POST['price']);
     // $picurl = $_FILES['file']['name'];
      $accId = $_POST['hiddenid'];

      $sql = "SELECT * FROM bizaccounts where id='$accId'";
      $data2= mysqli_query($con,$sql);
      $queryResults2= mysqli_num_rows($data2);
      

      
       if($queryResults2 >0) {
                 while($row = mysqli_fetch_assoc($data2)) {
              
                  $accountName = $row['accountName'];
                  $Bizdescription = $row['description'];
                  $location = $row['location'];
                  $latitude = $_SESSION['latitude'];
                  $longitude = $_SESSION['longitude'];

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
            ];
            
            $ref_table = "Adverts";
            $postRef = $database->getReference($ref_table)->push($postData);
            
        
            if($postRef){
        
             //$errors['success'] ="Ad Creation Success.";
             echo "<script>alert('Ad Creation Success.')</script>"; 
             echo "<script>location.replace('../mainpages/createadvert.php?acc_id=$accId');</script>"; 
         
             }
          
            }else{
                // $errors['error'] ="Fill all required fields and choose a ad picture.";
                 echo "<script>alert('Fill all required fields and choose ad pictures if necessary.')</script>"; 
                 echo "<script>location.replace('../mainpages/createadvert.php?acc_id=$accId');</script>"; 
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
            <form  action="createadvert.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name= "hiddenid" value=<?php $id= $_GET['acc_id']; echo $id; ?>> <!-- Hidden input-->

            <input class="passinput" type ="text" name="adtitle" placeholder="Enter advert name" value="<?php echo $accountname; ?>"><br><br>
            <input class="passinput" type="text" name="description" placeholder="Enter advert Description"  value="<?php echo $description;?>"> <br><br>
            <input class="passinput" type="text" name="price" placeholder="Enter Price  (optional)" value="<?php echo $price; ?>"><br><br>

           <input type="file" name="file" accept="image/*"> <br><br>
           <input type="file" name="file2" accept="image/*"> 
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