<?php

define('SAVE_FEED_LOCATION','var/export/gothamcigars.csv');
$keyword = $_GET['coupon'];
$row = 1;
if (($handle = fopen(SAVE_FEED_LOCATION, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        
        for ($c=0; $c < $num; $c++) {
            if ( strpos($data[$c], $keyword) !== FALSE )
			 echo $keyword;
        }
    }
    fclose($handle);
}
else echo "error";
?>