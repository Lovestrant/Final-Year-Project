<?php

    //Direct User to Google Maps
    $Glong = $_GET['sellerLong'];
    $GLat = $_GET['sellerLat'];

    echo"
    <iframe width='100%' height = '70%' src='https://maps.google.com/maps?q=$GLat,$Glong&output=embed'> </iframe>
    ";

?>