<?php
header("Content-Type: application/vnd.ms-excel");
//echo 'First Name' . "\t" . 'Last Name' . "\t" . 'Phone' . "\n";
//echo 'John' . "\t" . 'Doe' . "\t" . '555-5555' . "\n";
header("Content-disposition: attachment; filename=".rand()."spreadsheet.xls");
echo $_GET["data"];

?>