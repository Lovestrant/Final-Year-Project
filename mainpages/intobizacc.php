<?php 
    session_start();

    $_SESSION['acc_id'] = $_GET['acc_id'];

    include_once('../db.php');
    //initializing errors array
    $errors = array("error" => "", "success" => "");

    $accId = $_GET['acc_id'];
    if (isset($_POST['updateProfile'])) {


    //getting session variables
    $phonenumber = $_SESSION['phonenumber'];
   
    $accId = $_POST['hiddenid'];


    $sql="SELECT * FROM bizaccounts where phonenumber='$phonenumber' and id = '$accId'";

        $data= mysqli_query($con,$sql);
        $queryResults= mysqli_num_rows($data);
        
        
        if($queryResults >0) {
          

              

                    $imgurl = $_FILES['file']['name'];
                    $tmp = $_FILES['file']['tmp_name'];
                    move_uploaded_file($tmp,"../files/bizprofiles/bizprofiles".$imgurl);

                    $sql = "UPDATE bizaccounts set profileurl = '$imgurl' where phonenumber= '$phonenumber' and id= '$accId'";
                    $res = mysqli_query($con,$sql);
                    
                
                    if($res ==1){
                
                    $errors['success'] ="Profile Updated Successfully.";
                    echo "<script>location.replace('../mainpages/intobizacc.php?acc_id=$accId');</script>";    
                        
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
    <title>Location-Based Ecommerce System</title>


    <!--Css link-->
    <link rel="stylesheet" type="text/css" href="../css/bizaccounts.css">
    <!--Bootstrap css Links -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!--Bootstrap JS Links -->
    <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>

<style>
.zoom2{
    width:45%;
    height:auto;
    transition: transform ease-in-out 0.3s;
    }
.zoom2:hover{
    transform: scale(1.5);
    text-align: center;
    justify-content: center;
    }
    .zoom{
    width:45%;
    height:auto;
    transition: transform ease-in-out 0.3s;
    }
.zoom:hover{
    transform: scale(1.1);
    text-align: center;
    justify-content: center;
    
    }
</style>




</head>
<body>
<div class = "container-fluid">
    <div class = "row">
    
        <div class="col-sm-12">
        <?php include_once('../header.php'); ?>
        </div>
            
    
    </div>

    <div class="row">
<div class = "row" style="margin-left: 5%;text-align: centre;">
 
        <button style="color: red; margin-top: 1%;"><a style="color: red;" href="viewaccounts.php">Back to Business Profiles</a></button>
  
    <?php 
    
    if($_SESSION['phonenumber']){



        include_once('../db.php');
          
        $phonenumber = $_SESSION['phonenumber'];
        $accId = $_GET['acc_id'];
      
    
            $sql="SELECT * FROM bizaccounts where phonenumber='$phonenumber' and id = '$accId'";

 
                   $data2= mysqli_query($con,$sql);
                   $queryResults2= mysqli_num_rows($data2);
                   
         
                   
                    if($queryResults2 >0) {
                              while($row = mysqli_fetch_assoc($data2)) {

                                $accountName = $row['accountName'];
                           
                                echo "  
                                <div>
                                    <h3 style='color: green;'>".$row['accountName']."</h3>
                                    <a href='createadvert.php?acc_id=$accId'><button style='color: red;'>Create Advert</button></a>
                                    <a href='vieworders.php?accountName=$accountName'><button style='color: blue;'>View Orders</button></a>
                                    </div>

                                <div style='margin-top: 3%; text-align:centre; margin-bottom: 5%;'>
                                <img src='../files/bizprofiles/bizprofiles".$row['profileurl']."' style = 'width: 20%;border-radius:100%; height:auto;'>
                                       
                                </div>
                              ";
                              
                            }
                        }
         }else{
            echo "<script>alert('Your Session has expired.You need to login again')</script>";
            echo "<script>location.replace('../index.php')</script>";
         }

                              
    ?>

<div class="row" style="margin: 3%;">
 <div class="col-sm-6">
    <form action = "intobizacc.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name= "hiddenid" value=<?php $id= $_GET['acc_id']; echo $id; ?>> <!-- Hidden input-->

        <input type="file" accept ="image/*" name="file"><br><br>
        <button name="updateProfile">Change Profile</button>
    </form>

    <div><h5 style="color: red;"><?php echo $errors['error']; ?></h5></div>
     <div><h5 style="color: green;"><?php echo $errors['success']; ?></h5></div>

 </div> 
 <br><br><br>
    
    <div class="col-sm-6">
        <p>This will change this accounts ads' cordinates to the current location; Cordinates determines your radius and who sees your ads. </p>
        <form action="intobizacc.php" method="post">
        <input type="hidden" name= "hiddenid" value=<?php $id= $_GET['acc_id']; echo $id; ?>> <!-- Hidden input-->
            <input type="hidden" name='lat' value="<?php $lat = $_SESSION['latitude']; echo $lat;?>">
            <input type="hidden" name='long' value="<?php $long = $_SESSION['longitude']; echo $long;?>">
            <button type="submit" name="changeLocation">Change All Ads' cordinates</button>
        </form>
  
    </div>



 </div>

 </div>

         <div class="container">
             <div class="row">
                 <div class="col-sm-12" id="ads">
                     <h2>This Account's Adverts:</h2>
     <?php 
    //Requiring DB configs

    include_once('../FirebaseConfig/dbcon.php');

        include_once('../db.php');
          
        $phonenumber = $_SESSION['phonenumber'];
        $accId = $_GET['acc_id'];
      
        $ref_table ="Adverts";
        $fetchData = $database->getReference($ref_table)->getValue();

        if($fetchData >0) {
            foreach($fetchData as $key =>$row){
                if($row['phonenumber'] === $phonenumber && $row['id'] === $accId) {
                    if(!$row['picurl'] && !$row['picurl2']){
                        echo "  
                        <div>
                            <h3 style='color: green;'>".$row['adtitle']."</h3>
                            
                        </div>

                        <div style='margin-top: 1%; text-align:centre; margin-bottom: 5%;'>
                        
                        <p style='color: black;font-size:20px;margin-left:5%;margin-right:5%; '>".$row['description']."</p>  
                        <p style='color: green;text-decoration:bold;font-size:20px; '>Price: ".$row['price']."</p>  
                        <div>
                        <a href='deletepage.php?postId=".$row['id']."'><button style='color: red;margin-right: 10%;'>Delete</button></a>
                        <a href='editpage.php?postId=".$row['id']."'><button>Edit</button></a>
                        </div>
                        <hr>
                        </div>

                       
                      ";

                        } elseif(!$row['picurl'] && $row['picurl2']){
                            echo "  
                        <div>
                            <h3 style='color: green;'>".$row['adtitle']."</h3>
                            
                        </div>

                        <div style='margin-top: 3%; text-align:centre; margin-bottom: 5%;'>
                        <img class='zoom' src='../files/adpics/adpics".$row['picurl2']."' style = 'width: 80%; height:auto;'>
                        <p style='color: black;font-size:20px;margin-left:5%;margin-right:5%; '>".$row['description']."</p>  
                        <p style='color: green;text-decoration:bold;font-size:20px; '>Price: ".$row['price']."</p>  
                        <div>
                        <a href='deletepage.php?postId=".$row['id']."'><button style='color: red;margin-right: 10%;'>Delete</button></a>
                        <a href='editpage.php?postId=".$row['id']."'><button>Edit</button></a>
                        </div>
                        <hr>
                        </div>

                       
                      ";
                        } elseif($row['picurl'] && !$row['picurl2']){
                            echo "  
                        <div>
                            <h3 style='color: green;'>".$row['adtitle']."</h3>
                            
                        </div>

                        <div style='margin-top: 3%; text-align:centre; margin-bottom: 5%;'>
                        <img class='zoom' src='../files/adpics/adpics".$row['picurl']."' style = 'width: 80%; height:auto;'>
                        <p style='color: black;font-size:20px;margin-left:5%;margin-right:5%; '>".$row['description']."</p>  
                        <p style='color: green;text-decoration:bold;font-size:20px; '>Price: ".$row['price']."</p>  
                        <div>
                        <a href='deletepage.php?postId=".$row['id']."'><button style='color: red;margin-right: 10%;'>Delete</button></a>
                        <a href='editpage.php?postId=".$row['id']."'><button>Edit</button></a>
                        </div>
                        <hr>
                        </div>

                       
                      ";
                        } elseif($row['picurl'] && $row['picurl2']){
                            echo "  
                        <div>
                            <h3 style='color: green;'>".$row['adtitle']."</h3>
                            
                        </div>

                        <div style='margin-top: 3%; text-align:centre; margin-bottom: 5%;'>
                        <img class='zoom2' src='../files/adpics/adpics".$row['picurl']."' style = 'width: 45%; height:auto;'>
                        <img class='zoom2' src='../files/adpics/adpics".$row['picurl2']."' style = 'width: 45%; height:auto;'>
                        <p style='color: black;font-size:20px;margin-left:5%;margin-right:5%; '>".$row['description']."</p>  
                        <p style='color: green;text-decoration:bold;font-size:20px; '>Price: ".$row['price']."</p>  
                        <div>
                        <a href='deletepage.php?postId=".$row['id']."'><button style='color: red;margin-right: 10%;'>Delete</button></a>
                        <a href='editpage.php?postId=".$row['id']."'><button>Edit</button></a>
                        </div>
                        <hr>
                        </div>

                       
                      ";

                        }
                }
                              
            }
        }
                             
    ?>
                    
                 </div>
             </div>
         </div>



</div>



</body>
</html>

<?php
include_once('../db.php');
    
    if (isset($_POST['changeLocation'])) {


        //getting session variables
      
        $lat = mysqli_real_escape_string($con, $_POST['lat']);
        $long = mysqli_real_escape_string($con, $_POST['long']);
      
     
        $postid = $_POST['hiddenid'];
  
  
              $sql = "UPDATE adverts set latitude = '$lat', longitude='$long' where accId='$postid'";
          
              $res = mysqli_query($con,$sql);
              
          
              if($res ==1){
          
               //$errors['success'] ="Ad Creation Success.";
               echo "<script>alert('All account's Ads Cordinates changed success.')</script>"; 
               echo "<script>location.replace('../mainpages/intobizacc.php?acc_id=$postid');</script>"; 
           
              }
           
            }

?>