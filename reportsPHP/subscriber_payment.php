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
<title>رویت وصولیهای یک مشترک</title>
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
	$MSISDN='9124501098';
	
	
	
	$query=sprintf("select * from PAYMENT_TRANSACTION_SUBSCRIBER where pay_msisdn='%s'",$MSISDN);
	//echo $query;
$stid=oci_parse($conn,$query);
oci_execute($stid);




?>
<table width="91%" border="0" align="center" cellspacing="2" id="hor-minimalist-a" class="farsifont responstable">
<thead> 
 <tr>
  <th colspan="22" align="center" valign="middle" >وصولیهای مشترک</th>
  </tr>
  <tr>
 	
    <th width="19%" align="center" valign="middle" >MSISDN</th>
    <th width="16%" align="center" valign="middle" >مبلغ</th>
    <th width="16%" align="center" valign="middle" >تاریخ پرداخت</th>
    <th width="13%" align="center" valign="middle" >تاریخ ارسال </th>
    <th width="18%" align="center" valign="middle" >تاریخ اعمال</th>
    <th width="18%" align="center" valign="middle" >تاریخ دوره</th>
	<th width="18%" align="center" valign="middle" >نوع وصولی</th>
	<th width="18%" align="center" valign="middle" >درگاه</th>
	<th width="18%" align="center" valign="middle" >کد بانک 1</th>
	<th width="18%" align="center" valign="middle" >کد بانک 2</th>                                
	<th width="18%" align="center" valign="middle" >کد شعبه</th>    
	<th width="18%" align="center" valign="middle" >کد مرجع</th>    
	<th width="18%" align="center" valign="middle" >شناسه قبض</th>
	<th width="18%" align="center" valign="middle" >شناسه پرداخت</th>
	<th width="18%" align="center" valign="middle" >نام فایل</th>
	<th width="18%" align="center" valign="middle" >شماره سند</th>
	<th width="18%" align="center" valign="middle" >شناسه گروه</th>
	<th width="18%" align="center" valign="middle" >نام کاربر</th>
	<th width="18%" align="center" valign="middle" >IP</th>
	<th width="18%" align="center" valign="middle" >کد استان</th>
	<th width="18%" align="center" valign="middle" >وضعیت وصولی</th>
	<th width="18%" align="center" valign="middle" >وضعیت</th>
 	
  </tr>
</thead>
  <?php
  $sumnormalopen=0;
  $sumnormalclosed=0;
  $sumsalbopen=0;
  $sumsalbclosed=0;
  $suminvoice=0;
  
  while(($row = oci_fetch_row($stid))!= false){
  $PAY_MSISDN        =$row[0];
  $PAY_AMOUNT        =$row[1];
  $PAY_PAY_DATE      =$row[2];
  $PAY_SEND_DATE     =$row[3];
  $PAY_APPLY_DATE    =$row[4];
  $PAY_CYCLE_DATE    =$row[5];
  $PAY_PAYMENT_TYPE  =$row[6];
  $PAY_CHANNEL_CODE  =$row[7];
  $PAY_BANK_CODE1    =$row[8];
  $PAY_BANK_CODE2    =$row[9];
  $PAY_BRANCH_CODE   =$row[10];
  $PAY_REF_CODE      =$row[11];
  $PAY_BILID         =$row[12];
  $PAY_PAYID         =$row[13];
  $PAY_FILENAME      =$row[14];
  $PAY_DOC_NO        =$row[15];
  $PAY_GROUPID       =$row[16];
  $PAY_USERID        =$row[17];
  $PAY_IP            =$row[18];
  $PAY_PROV_CODE     =$row[19];
  $PAY_STATUS        =$row[20];
  $STATUS            =$row[21];


/*$sumnormalopen=$sumnormalopen+$normalopen;
$sumnormalclosed=$sumnormalclosed+$normalclosed;
$sumsalbopen=$sumsalbopen+$salbopen;
$sumsalbclosed=$sumsalbclosed+$salbclosed;
$suminvoice=$suminvoice+$totalinvoice;
*/
?>
  <tr>

	
    <td ><div align="right"><?php echo $MSISDN;?></div></td>
    <td ><div align="right"><?php echo $PAY_AMOUNT;?></div></td>
    <td ><div align="right"><?php echo $PAY_PAY_DATE;?></div></td>
    <td ><div align="right"><?php echo $PAY_SEND_DATE;?></div></td>
    <td ><div align="left"><?php echo $PAY_APPLY_DATE;?></div></td>
    <td ><div align="left"><?php echo $PAY_CYCLE_DATE;?></div></td>
    <td ><div align="left"><?php echo $PAY_PAYMENT_TYPE;?></div></td>
    <td ><div align="left"><?php echo $PAY_CHANNEL_CODE;?></div></td>
    <td ><div align="left"><?php echo $PAY_BANK_CODE1;?></div></td>
    <td ><div align="left"><?php echo $PAY_BANK_CODE2;?></div></td>
    <td ><div align="left"><?php echo $PAY_BRANCH_CODE;?></div></td>
    <td ><div align="left"><?php echo $PAY_REF_CODE;?></div></td>
    <td ><div align="left"><?php echo $PAY_BILID;?></div></td>
    <td ><div align="left"><?php echo $PAY_PAYID;?></div></td>
    <td ><div align="left"><?php echo $PAY_FILENAME;?></div></td>
    <td ><div align="left"><?php echo $PAY_DOC_NO;?></div></td>
    <td ><div align="left"><?php echo $PAY_GROUPID;?></div></td>
    <td ><div align="left"><?php echo $PAY_USERID;?></div></td>
    <td ><div align="left"><?php echo $PAY_IP;?></div></td>
    <td ><div align="left"><?php echo $PAY_PROV_CODE;?></div></td>
    <td ><div align="left"><?php echo $PAY_STATUS;?></div></td>
    <td ><div align="left"><?php echo $STATUS;?></div></td>
	
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
    <td align="center" valign="middle" >&nbsp;</td>
    <td align="center" valign="middle" >&nbsp;</td>
    <td align="center" valign="middle" >&nbsp;</td>
    <td align="center" valign="middle" >&nbsp;</td>
    <td align="center" valign="middle" >&nbsp;</td>
    <td align="center" valign="middle" >&nbsp;</td>
    <td align="center" valign="middle" >&nbsp;</td>
    <td align="center" valign="middle" >&nbsp;</td>
    <td align="center" valign="middle" >&nbsp;</td>
    <td align="center" valign="middle" >&nbsp;</td>
    <td align="center" valign="middle" >&nbsp;</td>
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