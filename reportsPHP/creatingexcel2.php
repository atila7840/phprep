<?php
require_once "Writer.php";

// We give the path to our file here
$workbook=new Spreadsheet_Excel_Writer('test.xls');

$worksheet=&$workbook->addWorksheet('My first worksheet');

$worksheet->write(0,0,'Name');
$worksheet->write(0,1,'Age');
$worksheet->write(1,0,'John Smith');
$worksheet->write(1,1,30);
$worksheet->write(2,0,'Johann Schmidt');
$worksheet->write(2,1,31);
$worksheet->write(3,0,'Juan Herrera');
$worksheet->write(3,1,32);

// We still need to explicitly close the workbook
$workbook->close();
?>