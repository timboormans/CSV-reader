<?php

/**
 * Class is obsolete / superseded with PHP's the native str_getcsv since PHP5.
 *
 * For showcasing only.
 *
 * @author Tim Boormans
 * @copyright Direct Web Solutions
 * @date May 2010
 *
 * Class csv_sidn
 */
class csv_sidn {

    static function csv_charbychar($line) {

        $len = strlen($line);
        $arr = array();
        $column = '';
        $quotecount = 0;
        $totalquotes = 0;
        for($i = 0; $i < $len; $i++) {
            // current character
            $char = $line[$i];

            // scrape content
            if($char == '"') {
                // add quote
                $column .= $char;

                // raise quote counter
                if(strlen($column) == 0) {
                    $quotecount = 1;
                    $totalquotes = 1;

                } elseif($i == $len-1) {
                    // End of line detected (there is NO semicolon on the end of each line!)
                    // convert to real content and add to array
                    $column = substr($column, 1, -1);
                    $column = preg_replace('/("")/', '"', $column); // str_replace() will replace already replaced characters resulting into faulty results
                    $arr[] = $column;

                    // reset variables
                    $quotecount = 0;
                    $column = '';
                    $totalquotes = 0;

                } else {
                    // add 1 quote to the current count
                    $quotecount++;
                    $totalquotes++;
                }

            } elseif($char == ';') {
                // end of column
                $column_done = false;

                if(strlen($column) == 2) {
                    // empty column (only 2 quotes without content inside it)
                    $column_done = true;

                } elseif($quotecount % 2 == 0) {
                    // only innerquotes detected, end of column NOT found yet. So add it as innerstring content
                    $column .= $char;

                } elseif($quotecount % 2 == 1 && strlen($column)-1 >= 0 && $column[strlen($column)-1] == '"' && $totalquotes % 2 == 0) {
                    /*
                    End of column detected because:
                     - previous char was a doublequote
                     - before this semicolon, 1 doublequote had no escaping
                     - the total number of doublequotes in this column is dividable by 2 which means THIS semicolon is not a trick inside the column content
                    */
                    $column_done = true;

                }

                // start process from string to array-element
                if($column_done) {
                    // convert to real content and add to array
                    $column = substr($column, 1, -1);
                    $column = preg_replace('/("")/', '"', $column); // str_replace() will replace already replaced characters resulting into faulty results
                    $arr[] = $column;

                    // reset variables
                    $quotecount = 0;
                    $column = '';
                    $totalquotes = 0;
                }

            } else {
                // add character (which is not a quote)
                $column .= $char;

                // quotecount only interesting when an semicolon right behind a double quote
                $quotecount = 0;
            }
        }
        return $arr;
    }

}