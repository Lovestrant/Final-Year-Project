<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location-Based Ecommerce System</title>

    <!--Css link-->
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <!--Bootstrap css Links -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!--Bootstrap JS Links -->
    <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>

</head>

    <script>
        function toProfile() {
            location.replace("profile.php");
        }


        function toRadius() {
            location.replace('radius.php?lat=' + <?php echo $_SESSION["latitude"] ?> + '&long=' + <?php echo $_SESSION["longitude"] ?>, '_self')
            
        }

    </script>
  

</head>
<body>
<div class = "container_fluid" id="headerbody1">
    <div class = "row">
        
        <div class ="col-sm-6">
        <h3 class="institution">Location-Based E-commerce System</h3>
        </div>

        <div class="col-sm-6">
        <h3 class="elearningLabel">Shop and advertise</h3>
        </div>

    </div>

    <div class = "row">
        <div class="col-sm-12">
        <h3 class="motto">Let's talk business.</h3>
        </div>
    </div>

<div class="col-sm-12" style="text-align: right; margin-right: 2%; margin-top: -2%;">
  
  <button id="radius" onClick = "toRadius()">Radius</button>
  <a href="profile.php"><button>Profile</button></a>
  
</div>
  
</div> 
</body>
</html>