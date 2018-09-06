<?php

/**
 * This script is obsolete / superseded with PHP's the native str_getcsv since PHP5. For showcasing only.
 */

// init
$csv_arr = array();

// iterate
$fp = fopen("drsreport.csv", "r");
if($fp) {
    while(!feof($fp)) {
        $line = trim(fgets($fp));
        if(strlen($line) > 0) {
            $csv_arr[] = csv_sidn::csv_charbychar($line);
        }
    }
    fclose($fp);
}

// do something with the result
print_r($csv_arr);
