# SIDN DRS Report Reader
A PHP Class to parse DRS reports from the Dutch domain registry and convert them into an iterative array, to compute them into other digital systems.

### Requirements
* Nothing really, just PHP.

## Example
An example in it's most simple form:

```PHP
<?php
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
?>
```

###### Author notes
* Obsolete / superseded since PHP5.
* Published on GitHub for showcasing only.