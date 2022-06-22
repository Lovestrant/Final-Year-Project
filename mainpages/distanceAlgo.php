<?php 

 function calculateDistance($lat1,$long1,$lat2,$long2){
        $pi80 = M_PI / 180;
        $lat1 *= $pi80;
        $lat2 *= $pi80;
        $long1 *= $pi80;
        $long2 *= $pi80;
        $r = 6372.797; //Avarage earth radius
        $dlat = $lat2 - $lat1;
        $dlon = $long2 - $long1;
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) *sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $km = $r * $c;
        return $km;
    }

?>