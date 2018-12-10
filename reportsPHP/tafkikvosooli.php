<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>تفکیک وصولی</title>
</head>

<body>
<?php
/*function convertToEnglish($string) {
    $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
    $num = range(0, 9);
    return str_replace($persian, $num, $string);
} */
//$startdate='1393/05/01';
//$enddate='1395/10/23';
//$bank='7';
//select sum(COUNT), sum(AMOUNT) from amar_vosoli_sabtenam_main where pay_date>='950501' and pay_date<='950505';

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
	
	
	$startdate= convertToEnglish( $fields[ 'startdate' ]);
	$enddate= convertToEnglish($fields[ 'enddate' ]);
	//$startdate= convertToEnglish(str_replace("/", "", $fields[ 'startdate' ]));
	//$enddate= convertToEnglish(str_replace("/", "",$fields[ 'enddate' ]));
	$bank= convertToEnglish($fields[ 'bank' ]);
	$bank_name = $fields['bank_name'];
	
	if ($bank=="all"){
	
	$query=sprintf("select PAY_TYPE ,sum(TEDAD), sum(MABLAGH) from amar_vosoli_sabtenam_main where  PAY_SEND_DATE>='%s' and PAY_SEND_DATE<='%s' group by PAY_TYPE order by 1", $startdate, $enddate);
	}
	
	else {
		$query=sprintf("select PAY_TYPE ,sum(TEDAD), sum(MABLAGH) from amar_vosoli_sabtenam_main where PAY_BANK_CODE1='%s' and PAY_SEND_DATE>='%s' and PAY_SEND_DATE<='%s' group by PAY_TYPE order by 1", $bank, $startdate, $enddate);
	}
	//echo $query;
//$query2="select sum(COUNT) from amar_vosoli_sabtenam_main where pay_date>='930501' and pay_date<='950603'";	
	
$stid=oci_parse($conn,$query);
oci_execute($stid);

//$stid2=oci_parse($conn,$query2);
//oci_execute($stid2);
//$result=oci_fetch_row($stid2);

?>
<table width="50%" border="0" align="center" cellspacing="2" id="hor-minimalist-a" class="farsifont responstable">
  <tr>
    <td colspan="4" align="center" valign="middle" ><?php echo sprintf("تفکیک سطوح وصولی و ثبت نام بانک %s از تاریخ %s تا تاریخ %s",$bank_name,$startdate, $enddate);?></td>
  </tr>
  <tr>

     <td width="33%" align="center" valign="middle" >نوع وصولی</td>
	 <td width="24%" align="center" valign="middle" >تعداد</td>
	 <td width="43%" align="center" valign="middle" >مبلغ</td>
	 
  </tr>
  <?php
  
$sum_count=0;
$sum_ammount=0;
  
  
  while(($row = oci_fetch_row($stid))!= false){
$amount=$row[2];
$count=$row[1];
$range=$row[0];

if ($range=="KARKARD") {
 $range2="کارکرد";
}
if ($range=="KHARIDE GOOSHI") {
 $range2="خرید گوشی";
}
if ($range=="SABTE_NAME") {
 $range2="ثبت نام";
}
if ($range=="SYS_FOROSH_AGHSAT") {
 $range2="فروش اقساطی سیستم";
}
if ($range=="SYS_FOROOSH_NAGHDI") {
 $range2="فروش نقدی سیستم";
}

$sum_ammount=$amount+$sum_ammount;
$sum_count=$count+$sum_count;

?>
  <tr>
	
    <td align="right" valign="center" ><?php echo $range2;?></td>
    <td ><?php echo number_format ($count);?></td>
    <td ><?php echo number_format ($amount);?></td>
	
  </tr>
  <?php
  $range2='';
  }
  
  ?>
  <tr>
	
    <td align="center" valign="middle" >جمع</td>
    <td align="left" ><?php echo number_format($sum_count);?></td>
    <td align="left" ><?php echo number_format($sum_ammount);?></td>
	
  </tr>
</table>
<p>
  <?php

oci_free_statement($stid);
oci_close($conn);

}
?>
  
  
  <?php
//$startdate='930501';
//$enddate='950503';
//$bankid='14';

	$conn = oci_connect("billuser","billing","billdata","utf8");

if (!$conn){
$e = oci_error();
  trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);

}
else{
	
	if ($bank=="all"){
	$query=sprintf("select pay_amount, sum(COUNT), sum(sum_amount) from AMAR_VOSOLI_SABTENAM_DETAIL where apply_date>='%s' and apply_date<='%s' group by pay_amount order by 1", $startdate, $enddate);
	}
	
	else {
		$query=sprintf("select pay_amount, sum(COUNT), sum(sum_amount) from AMAR_VOSOLI_SABTENAM_DETAIL where apply_date>='%s' and apply_date<='%s' and PAY_BANK_CODE1='%s'group by pay_amount order by 1", $startdate, $enddate, $bank);
	}
	
	//echo $query;
$stid=oci_parse($conn,$query);
oci_execute($stid);



?>
</p>
<p>&nbsp; </p>
<table width="30%" border="0" align="center" cellspacing="2" id="hor-minimalist-a" class="farsifont responstable">
  <tr>
    <td colspan="4" align="center" valign="middle" ><?php echo sprintf("تفکیک سطوح  ثبت نام بانک %s از تاریخ %s تا تاریخ %s",$bank_name,$startdate, $enddate);?></td>
  </tr>
  <tr>
	
     <td width="33%" align="center" valign="middle" >نوع ثبت نام</td>
     <td width="24%" align="center" valign="middle" >تعداد</td>
     <td width="43%" align="center" valign="middle" >مبلغ</td>
	 
  </tr>
  <?php
$sum_count=0;
$sum_ammount=0;
  
  while(($row = oci_fetch_row($stid))!= false){
$amount=$row[2];
$count=$row[1];
$range=$row[0];
//$cycle=$row[5];
//$ammount_sum=0
//$count_sum=0
$sum_ammount=$amount+$sum_ammount;
$sum_count=$count+$sum_count;

?>
  <tr>
	
    <td align="right" valign="center" ><?php echo $range;?></td>
    <td ><?php echo number_format ($count);?></td>
    <td ><?php echo number_format ($amount);?></td>
	
  </tr>
  <?php
  }
  ?>
  <tr>
	
    <td align="center" valign="middle" >جمع</td>
    <td align="left" ><?php echo number_format($sum_count);?></td>
    <td align="left" ><?php echo number_format($sum_ammount);?></td>
	
  </tr>
</table>
<?php

oci_free_statement($stid);
oci_close($conn);

}
?>


</body>
</html>

<?php
function convertToEnglish($string) {
    $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
    $num = range(0, 9);
    return str_replace($persian, $num, $string);
}
?>