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
<title>وصولی مجازی</title>
</head>

<body>
<?php
//$cycle='9507';

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
	
	
	$year= $fields[ 'year' ];
	
	$cycle= $fields[ 'cycle' ];
	$bank=$fields[ 'bank' ];
	$bankname=$fields[ 'bank_name' ];
	
	
if ($bank=='all') {
	$query=sprintf("select REPORT_UNCONFIRM_TOTAL.cycle,BANK.BANK_FA_NAME,PAYMENT_CHANNEL.PAYCHANNEL_FA_NAME,PAYMENT_TYPE.PAYTYPE_FA_NAME,REPORT_UNCONFIRM_TOTAL.amount
from REPORT_UNCONFIRM_TOTAL,BANK,PAYMENT_CHANNEL,PAYMENT_TYPE
where REPORT_UNCONFIRM_TOTAL.BANK_CODE=BANK.BANK_CODE1  
and REPORT_UNCONFIRM_TOTAL.CHANNEL_CODE=PAYMENT_CHANNEL.PAYCHANNEL_CODE
and REPORT_UNCONFIRM_TOTAL.PAYMENT_TYPE=PAYMENT_TYPE.PAYTYPE_CODE and REPORT_UNCONFIRM_TOTAL.cycle='%s%s' 
order by REPORT_UNCONFIRM_TOTAL.cycle,BANK.BANK_FA_NAME,PAYMENT_CHANNEL.PAYCHANNEL_FA_NAME,PAYMENT_TYPE.PAYTYPE_FA_NAME,REPORT_UNCONFIRM_TOTAL.amount",$year,$cycle);
}
else{
	$query=sprintf("select REPORT_UNCONFIRM_TOTAL.cycle,BANK.BANK_FA_NAME,PAYMENT_CHANNEL.PAYCHANNEL_FA_NAME,PAYMENT_TYPE.PAYTYPE_FA_NAME,REPORT_UNCONFIRM_TOTAL.amount
from REPORT_UNCONFIRM_TOTAL,BANK,PAYMENT_CHANNEL,PAYMENT_TYPE
where REPORT_UNCONFIRM_TOTAL.BANK_CODE=BANK.BANK_CODE1 and BANK.BANK_CODE1='%s' 
and REPORT_UNCONFIRM_TOTAL.CHANNEL_CODE=PAYMENT_CHANNEL.PAYCHANNEL_CODE
and REPORT_UNCONFIRM_TOTAL.PAYMENT_TYPE=PAYMENT_TYPE.PAYTYPE_CODE and REPORT_UNCONFIRM_TOTAL.cycle='%s%s' 
order by REPORT_UNCONFIRM_TOTAL.cycle,BANK.BANK_FA_NAME,PAYMENT_CHANNEL.PAYCHANNEL_FA_NAME,PAYMENT_TYPE.PAYTYPE_FA_NAME,REPORT_UNCONFIRM_TOTAL.amount",$bank,$year,$cycle);

}//echo $query;
$stid=oci_parse($conn,$query);
oci_execute($stid);




?>
<table width="48%" border="0" align="center" cellspacing="2" id="hor-minimalist-a" class="farsifont responstable">
  <tr>
    <td colspan="5" align="center" valign="middle" >وصولی مجازی</td>
  </tr>
  <tr>
	
    <td align="center" valign="middle" >دوره</td>
    <td align="center" valign="middle" >بانک</td>
    <td align="center" valign="middle" >درگاه</td>
    <td align="center" valign="middle" >نوع</td>
    <td align="center" valign="middle" >مبلغ </td>
	
  </tr>
  <?php
  $sumnormalopen=0;
  $sumnormalclosed=0;
  $sumsalbopen=0;
  $sumsalbclosed=0;
  $suminvoice=0;
  
  while(($row = oci_fetch_row($stid))!= false){
$billcycle=$row[0];
$bank=$row[1];
$channel=$row[2];
$type=$row[3];
$amount=$row[4];


/*$sumnormalopen=$sumnormalopen+$normalopen;
$sumnormalclosed=$sumnormalclosed+$normalclosed;
$sumsalbopen=$sumsalbopen+$salbopen;
$sumsalbclosed=$sumsalbclosed+$salbclosed;
$suminvoice=$suminvoice+$totalinvoice;
*/
?>
  <tr>
	
    <td ><div align="right"><?php echo $billcycle;?></div></td>
    <td ><div align="right"><?php echo $bank;?></div></td>
    <td ><div align="right"><?php echo $channel;?></div></td>
    <td ><div align="right"><?php echo $type;?></div></td>
    <td ><div align="left"><?php echo number_format($amount,0);?></div></td>
	
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
	
  </tr>
</table>
<?php

oci_free_statement($stid);
oci_close($conn);

}
?>

</body>
</html>