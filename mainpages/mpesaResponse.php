<?php
session_start();

include_once('../FirebaseConfig/dbcon.php');

header('content-Type:application/json');
$callresp=file_get_contents('php://input');
$file="stkTinypesaResponse.json";
$log=fopen($file,"a");
fwrite($log,$callresp);
fclose($log);
$callcontent=json_decode($callresp);
$resultcode = $callcontent->Body->stkCallback->ResultCode;
$amount = $callcontent->Body->stkCallback->CallbackMetadata->Item[0]->Value;
$phonenumber = $callcontent->Body->stkCallback->CallbackMetadata->Item[4]->Value;

//$callres=$amount.'-'.$resultcode.'-'.$phonenumber;
if($resultcode==0){
    //What happens If response Is success


    $ref_table ="cart";
    $fetchData = $database->getReference($ref_table)->getValue();

    if($fetchData >0) {
        foreach($fetchData as $key =>$row){

            $accountName = $row['accountName'];
            $adtitle = $row['adtitle'];
            $description = $row['description'];
            $id = $row['id'];
            $SellerPhonenumber = $row['phonenumber'];
            $picurl = $row['picurl'];
            $picur2 = $row['picurl2'];
            $price = $row['price'];
            $buyerPhone = $row['buyerPhone'];
            $payOption = $row['payOption'];
 
            if("+".$phonenumber ===$buyerPhone) {
                $postData = [
                    "phonenumber" => $SellerPhonenumber,
                    "picurl" => $picurl,
                    "picurl2" => $picur2,
                    "price" => $price,
                    "accountName" => $accountName,
                    "adtitle" => $adtitle,
                    "description" => $description,
                    "id" => $id,
                    "buyerPhone" => $buyerPhone,
                    "payOption" => $payOption
                ];
                
                $ref_table = "Orders";
                $postRef = $database->getReference($ref_table)->push($postData);
    
                if($postRef) {
                    $ref_table = "cart/".$key;
                    $DeleteQueryResult = $database->getReference($ref_table)->remove();
                }
            
  
        }

        }
        echo "<script>alert('Order Made Successful, Thank you');</script>";
    }
}




?>