<?php 
session_start();

if(isset($_POST['SendMessage'])) {
    $message = $_POST['message'];


    $instance = '457202'; 
    $whatsapp_number = '254704707624'; // with country Code  
    $content = $message; 
   
    $url = "http://whatsappsms.domain.in/api/sendText?token=".$instance."&phone=".$whatsapp_number."&message=".urlencode($content)."";
    $ch = curl_init();
    // set url
    curl_setopt($ch, CURLOPT_URL,$url);
    //return the transfer as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_close($ch);


    // $data = [
    //     'phone' => '254791638771', // Receivers phone
    //     'template' => $message, // Template name
    //     'namespace' => 'namespace_of_template', // Namespace of template
    //     'language' =>  ['code' => 'en', 'policy' => 'deterministic'], // Language parameters
    // ];
    // $json = json_encode($data); // Encode data to JSON
    // // URL for request POST /message
    // $token = 'grTJioSoFqPu71IE';
    // $instanceId = '457202';
    // $url = "https://api.chat-api.com/instance{$instanceId}/sendTemplate?token={$token}";
    // // Make a POST request
    // $options = stream_context_create(['http' => [
    //         'method'  => 'POST',
    //         'header'  => 'Content-type: application/json',
    //         'content' => $json
    //     ]
    // ]);
    // // Send a request
    // $result = file_get_contents($url, false, $options);
    // print_r($result);
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
            <h3>Submit Your Issue to the Admin on WhatsApp:</h3>
            <a href="https://api.whatsapp.com/send?phone=254791638771"><button>Chat with Admin on WhatsApp</button></a>
            <!-- <form action="admin.php" method="post">
              <textarea style='width: 80%;' type="text" name="message" placeholder="Type Issue here" required></textarea> <br><br>
              <button name="SendMessage" class="btn-btn-success">Submit Issue Now</button>
            </form> -->
        </div>
    </div>
</div>
</body>
</html>