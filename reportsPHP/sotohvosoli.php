<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>سطوح وصولی</title>

</head>

<body>
<?php
$cycle='9507';
$province='14';
//dl("d:\php\ext\php_oci8_12c.dll");
	$conn = oci_connect("billuser","billing","billdata");

if (!$conn){
$e = oci_error();
  trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);

}
else{
	$fieldNames = explode('&', $_POST['fieldsNames']);
	$fieldsValues = explode( '&', $_POST['fieldsValues']);
	
	$fields = array();
	for( $i = 0; $i<sizeof($fieldNames); $i++){
		$fields[$fieldNames[$i]] = $fieldsValues[$i];
	}
	
	
	$year= $fields[ 'year' ];
	
	$cycle= $fields[ 'cycle' ];
	$province=$fields[ 'province' ];
	$province_name=$fields[ 'province_name' ];
	
	$query=sprintf("select * from  TAFKIKE_SOTOOHE_VOSOLI where cycle='%s%s' and province='%s'",$year,$cycle,$province);
	
$stid=oci_parse($conn,$query);
oci_execute($stid);




?>
<strong></strong>
<table width="40%" border="0" align="center" cellspacing="2" id="hor-minimalist-a" class="farsifont responstable">
<thead>
  <tr>
    <th colspan="4" align="center" valign="middle"  ><?php echo sprintf(" سطوح وصولی استان <strong>%s</strong> سال و دوره <strong>%s</strong>",$province_name,$year.$cycle);?></th>
  </tr>
  <tr>
	
    <th width="16%" align="center" valign="middle" >ردیف</th>
    <th width="42%" align="center" valign="middle" >بازه</th>
    <th width="16%" align="center" valign="middle" >تعداد</th>
    <th width="26%" align="center" valign="middle" >مبلغ</th>
	
  </tr>
</thead>  
  <?php
  while(($row = oci_fetch_row($stid))!= false){
$rowid=$row[0];
$range=$row[1];
//$province=$row[2];
$count=$row[3];
$amount=$row[4];
//$cycle=$row[5];



?>
  <tr>
    <td  align="right"><?php echo $rowid?></td>
    <td ><?php echo $range;?></td>
    <td ><?php echo $count;?></td>
    <td ><?php echo number_format($amount,0);?></td>
	
  </tr>
  <?php
  }
  ?>
  <tr>
    <td align="center" valign="middle" >جمع</td>
    <td align="center" valign="middle" >&nbsp;</td>
    <td align="center" valign="middle" >&nbsp;</td>
    <td align="center" valign="middle" >&nbsp;</td>
  </tr>
</table>
<?php

oci_free_statement($stid);
oci_close($conn);

}
?>

</body>
</html>