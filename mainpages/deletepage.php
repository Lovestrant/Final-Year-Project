<?php 
    session_start();

  
    //initializing errors array
    $errors = array("error" => "", "success" => "");
    include_once('../FirebaseConfig/dbcon.php');


    if(isset($_POST['deletepost'])){


    $postid = $_POST['hiddenid'];


    $ref_table = "Adverts/".$postid;
    $DeleteQueryResult = $database->getReference($ref_table)->remove();
    
    if($DeleteQueryResult >0) {
        //$errors['sucess'] ="Post Deleted successfully.";
        echo "<script>alert('Post Deleted successfully.')</script>";
        echo "<script>location.replace('../mainpages/deletepage.php?postId=$postid')</script>";
    }else{
        echo "<script>alert('Deleation Failed.')</script>";
        echo "<script>location.replace('../mainpages/deletepage.php?postId=$postid')</script>";
    }
    
    
    }
    
    
    ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location-Based E-Commerce System</title>

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
<div class = "row" style="margin-left: 5%;text-align: centre;">

<div class="container">
             <div class="row">
                 <div class="col-sm-12" >
                     <h2 style='color: red;'>Be sure Before you delete:</h2>
     <?php 




          
        $phonenumber = $_SESSION['phonenumber'];
        $postId = $_GET['postId'];
      
        $ref_table ="Adverts";
        $fetchData = $database->getReference($ref_table)->getValue();
    
        if($fetchData >0) {
            foreach($fetchData as $key =>$row){
                if($row['phonenumber'] === $phonenumber && $key === $postId) {
                
                    if(!$row['picurl'] && !$row['picurl2']){
                        echo "  
                        <div>
                            <h3 style='color: green;'>".$row['adtitle']."</h3>
                            
                        </div>
    
                        <div style='margin-top: 1%; text-align:centre; margin-bottom: 5%;'>
                        
                        <p style='color: black;font-size:20px; '>".$row['description']."</p>  
                        <p style='color: green;text-decoration:bold;font-size:20px; '>Price: ".$row['price']."</p>  
    
                        <hr>
                        </div>
    
                        
                        ";
    
                    } elseif(!$row['picurl'] && $row['picurl2']){
                        echo "  
                        <div>
                            <h3 style='color: green;'>".$row['adtitle']."</h3>
                            
                        </div>
    
                        <div style='margin-top: 3%; text-align:centre; margin-bottom: 5%;'>
                        <img src='../files/adpics/adpics".$row['picurl2']."' style = 'width: 80%; height:auto;'>
                        <p style='color: black;font-size:20px; '>".$row['description']."</p>  
                        <p style='color: green;text-decoration:bold;font-size:20px; '>Price: ".$row['price']."</p>  
    
                        <hr>
                        </div>
    
                        
                        ";
    
                    } elseif($row['picurl'] && !$row['picurl2']){
                        echo "  
                        <div>
                            <h3 style='color: green;'>".$row['adtitle']."</h3>
                            
                        </div>
    
                        <div style='margin-top: 3%; text-align:centre; margin-bottom: 5%;'>
                        <img src='../files/adpics/adpics".$row['picurl']."' style = 'width: 80%; height:auto;'>
                        <p style='color: black;font-size:20px; '>".$row['description']."</p>  
                        <p style='color: green;text-decoration:bold;font-size:20px; '>Price: ".$row['price']."</p>  
    
                        <hr>
                        </div>
    
                        
                        ";
    
                    } elseif($row['picurl'] && $row['picurl2']){
                        echo "  
                        <div>
                            <h3 style='color: green;'>".$row['adtitle']."</h3>
                            
                        </div>
    
                        <div style='margin-top: 3%; text-align:centre; margin-bottom: 5%;'>
                        <img src='../files/adpics/adpics".$row['picurl']."' style = 'width: 40%; height:auto;'>
                        <img src='../files/adpics/adpics".$row['picurl2']."' style = 'width: 40%; height:auto;'>
                        <p style='color: black;font-size:20px; '>".$row['description']."</p>  
                        <p style='color: green;text-decoration:bold;font-size:20px; '>Price: ".$row['price']."</p>  
    
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

<div class="row" style="margin: 3%;">
 <div class="col-sm-12">
    <form action = "deletepage.php" method="post">
    <input type="hidden" name= "hiddenid" value=<?php $id= $_GET['postId']; echo $id; ?>> <!-- Hidden input-->

     <button name="deletepost" style="background-color: red;color:white;">Delete Above Post</button>
    </form>

    <div><h5 style="color: red;"><?php echo $errors['error']; ?></h5></div>
     <div><h5 style="color: green;"><?php echo $errors['success']; ?></h5></div>

 </div> 

 </div>

 </div>







</div>



</body>
</html>