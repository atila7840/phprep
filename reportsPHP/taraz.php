<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--
 <script src="jquery.min.js"></script>
<script src="persianumber.js"></script>
<style type="text/css">
@import url("nazli/stylesheet.css");

.farsifont {
	font-family: nazli;
	}
</style>
-->
<title>تراز مالی مشترک</title>
</head>

<body>
<?php
//$cycle='9507';
$year="";
$cycle="";

//dl("d:\php\ext\php_oci8_12c.dll");
	$conn = oci_connect("billuser","billing","billdata","utf8");

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
	
	
	$MSISDN= $fields[ 'MSISDN' ];
	
	
	
	
	
	$query=sprintf("select * from TARAZ",$year,$cycle);
	//echo $query;
$stid=oci_parse($conn,$query);
oci_execute($stid);




?>
<table width="91%" border="0" align="center" cellspacing="2" id="hor-minimalist-a" class="farsifont responstable">
  <tr>
    <td colspan="6" align="center" valign="middle" >تراز مالی مشترک<?php  echo $MSISDN;?></td>
  </tr>
  <tr>
	
    <td width="19%" align="center" valign="middle" >شماره تراکنش</td>
    <td width="16%" align="center" valign="middle" >تاریخ</td>
    <td width="16%" align="center" valign="middle" >نوع تراکنش</td>
    <td width="13%" align="center" valign="middle" >مبلغ </td>
    <td width="18%" align="center" valign="middle" >قابل پرداخت </td>
    <td width="18%" align="center" valign="middle" >مبلغ باقیمانده</td>
	
  </tr>
  <?php
  $sumnormalopen=0;
  $sumnormalclosed=0;
  $sumsalbopen=0;
  $sumsalbclosed=0;
  $suminvoice=0;
  
  while(($row = oci_fetch_row($stid))!= false){
$transno=$row[0];
$transdate=$row[1];
$transtype=$row[2];
$transamount=$row[3];
$payable=$row[4];
$remained=$row[5];


/*$sumnormalopen=$sumnormalopen+$normalopen;
$sumnormalclosed=$sumnormalclosed+$normalclosed;
$sumsalbopen=$sumsalbopen+$salbopen;
$sumsalbclosed=$sumsalbclosed+$salbclosed;
$suminvoice=$suminvoice+$totalinvoice;
*/
?>
  <tr>
	
    <td ><div align="right"><?php echo $transno;?></div></td>
    <td ><div align="right"><?php echo $transdate;?></div></td>
    <td ><div align="right"><?php echo $transtype;?></div></td>
    <td ><div align="right"><?php echo $transamount;?></div></td>
    <td ><div align="left"><?php echo $payable;?></div></td>
    <td ><div align="left"><?php echo $remained;?></div></td>
	
  </tr>
  <?php
  }
  ?>
  <tr>
    <td align="center" valign="middle" >جمع</td>
    <td align="center" valign="middle" >&nbsp;</td>
    <td align="center" valign="middle" >&nbsp;</td>
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