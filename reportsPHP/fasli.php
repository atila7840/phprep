<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>وصولی فصلی سرویس</title>
</head>

<body>
<?php

//input year,year,cycle,service 


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
	
	
	$yearinvoice= $fields[ 'yearinvoice' ];
	$yearpayment= $fields[ 'yearpayment' ];
	$cyclepayment= $fields[ 'cyclepayment' ];
	$service= $fields[ 'service' ];
	$service_name= $fields['service_name'];
	
	
		
	if ($service== 'VAS')	{$query=sprintf("select substr(S.BIL_CYCLE,6,4),S.PAYMENT_CYCLE,S.VAS_OPEN_AMOUNT,S.VAS_TOTAL_AMOUNT,
S.VAS_TOTAL_AMOUNT-S.VAS_OPEN_AMOUNT ,pay.VAS_OPEN_AMOUNT,
pay.VAS_TOTAL_AMOUNT,pay.VAS_TOTAL_AMOUNT-pay.VAS_OPEN_AMOUNT,
TT.VAS_TOTAL_AMOUNT
from VOSOLI_REPORT_SUMMARY_PAY_SALB s,VOSOLI_REPORT_SUMMARY_PAY_AC pay,VOSOLI_REPORT_SUMMARY_PAYMENT tt
where S.BIL_CYCLE like 'BILL_%s%%' and s.payment_cycle='Payment_%s%s' and S.BIL_CYCLE=PAY.BIL_CYCLE and TT.BIL_CYCLE = PAY.BIL_CYCLE and S.PAYMENT_CYCLE=PAY.PAYMENT_CYCLE and TT.PAYMENT_CYCLE = PAY.PAYMENT_CYCLE
order by 1",$yearinvoice,$yearpayment,$cyclepayment);
//echo $query;
}
	if ($service== 'LOCAL')	{$query=sprintf("select substr(S.BIL_CYCLE,6,4),S.PAYMENT_CYCLE,S.LOCAL_OPEN_AMOUNT,S.LOCAL_TOTAL_AMOUNT,
S.LOCAL_TOTAL_AMOUNT-S.LOCAL_OPEN_AMOUNT ,pay.LOCAL_OPEN_AMOUNT,
pay.LOCAL_TOTAL_AMOUNT,pay.LOCAL_TOTAL_AMOUNT-pay.LOCAL_OPEN_AMOUNT,
TT.LOCAL_TOTAL_AMOUNT
from VOSOLI_REPORT_SUMMARY_PAY_SALB s,VOSOLI_REPORT_SUMMARY_PAY_AC pay,VOSOLI_REPORT_SUMMARY_PAYMENT tt
where S.BIL_CYCLE like 'BILL_%s%%' and s.payment_cycle='Payment_%s%s' and S.BIL_CYCLE=PAY.BIL_CYCLE and TT.BIL_CYCLE = PAY.BIL_CYCLE and S.PAYMENT_CYCLE=PAY.PAYMENT_CYCLE and TT.PAYMENT_CYCLE = PAY.PAYMENT_CYCLE
order by 1",$yearinvoice,$yearpayment,$cyclepayment);

	}
	if ($service== 'INTERNATIONAL'){
		$query=sprintf("select substr(S.BIL_CYCLE,6,4),S.PAYMENT_CYCLE,S.INTERNATIONAL_OPEN_AMOUNT,S.BIL_TOTAL_INT, S.BIL_TOTAL_INT-S.INTERNATIONAL_OPEN_AMOUNT ,pay.INTERNATIONAL_OPEN_AMOUNT, pay.BIL_TOTAL_INT,pay.BIL_TOTAL_INT-pay.INTERNATIONAL_OPEN_AMOUNT, TT.BIL_TOTAL_INT from VOSOLI_REPORT_SUMMARY_PAY_SALB s,VOSOLI_REPORT_SUMMARY_PAY_AC pay,VOSOLI_REPORT_SUMMARY_PAYMENT TT where S.BIL_CYCLE like 'BILL_%s%%' and s.payment_cycle='Payment_%s%s' and S.BIL_CYCLE=PAY.BIL_CYCLE and TT.BIL_CYCLE = PAY.BIL_CYCLE and S.PAYMENT_CYCLE=PAY.PAYMENT_CYCLE and TT.PAYMENT_CYCLE = PAY.PAYMENT_CYCLE order by 1",$yearinvoice,$yearpayment,$cyclepayment);
	}
	if ($service== 'SMS'){
		$query=sprintf("select substr(S.BIL_CYCLE,6,4),S.PAYMENT_CYCLE,S.SMS_OPEN_AMOUNT,S.BIL_TOTAL_SMS, S.BIL_TOTAL_SMS-S.SMS_OPEN_AMOUNT ,pay.SMS_OPEN_AMOUNT, pay.BIL_TOTAL_SMS,pay.BIL_TOTAL_SMS-pay.SMS_OPEN_AMOUNT, TT.BIL_TOTAL_SMS from VOSOLI_REPORT_SUMMARY_PAY_SALB s,VOSOLI_REPORT_SUMMARY_PAY_AC pay,VOSOLI_REPORT_SUMMARY_PAYMENT TT where S.BIL_CYCLE like 'BILL_%s%%' and s.payment_cycle='Payment_%s%s' and S.BIL_CYCLE=PAY.BIL_CYCLE and TT.BIL_CYCLE = PAY.BIL_CYCLE and S.PAYMENT_CYCLE=PAY.PAYMENT_CYCLE and TT.PAYMENT_CYCLE = PAY.PAYMENT_CYCLE order by 1",$yearinvoice,$yearpayment,$cyclepayment);
	}
	if ($service== 'ROAM'){
		$query=sprintf("select substr(S.BIL_CYCLE,6,4),S.PAYMENT_CYCLE,S.INT_ROAM_OPEN_AMOUNT,S.BIL_TOTAL_ROAM, S.BIL_TOTAL_ROAM-S.INT_ROAM_OPEN_AMOUNT ,pay.INT_ROAM_OPEN_AMOUNT, pay.BIL_TOTAL_ROAM,pay.BIL_TOTAL_ROAM-pay.INT_ROAM_OPEN_AMOUNT, TT.BIL_TOTAL_ROAM from VOSOLI_REPORT_SUMMARY_PAY_SALB s,VOSOLI_REPORT_SUMMARY_PAY_AC pay,VOSOLI_REPORT_SUMMARY_PAYMENT TT where S.BIL_CYCLE like 'BILL_%s%%' and s.payment_cycle='Payment_%s%s' and S.BIL_CYCLE=PAY.BIL_CYCLE and TT.BIL_CYCLE = PAY.BIL_CYCLE and S.PAYMENT_CYCLE=PAY.PAYMENT_CYCLE and TT.PAYMENT_CYCLE = PAY.PAYMENT_CYCLE order by 1",$yearinvoice,$yearpayment,$cyclepayment);
	}
	if ($service== 'COSTS'){
		$query=sprintf("select substr(S.BIL_CYCLE,6,4),S.PAYMENT_CYCLE,S.COSTS_OPEN_AMOUNT,S.BIL_TOTAL_COSTS, S.BIL_TOTAL_COSTS-S.COSTS_OPEN_AMOUNT ,pay.COSTS_OPEN_AMOUNT, pay.BIL_TOTAL_COSTS,pay.BIL_TOTAL_COSTS-pay.COSTS_OPEN_AMOUNT, TT.BIL_TOTAL_COSTS from VOSOLI_REPORT_SUMMARY_PAY_SALB s,VOSOLI_REPORT_SUMMARY_PAY_AC pay,VOSOLI_REPORT_SUMMARY_PAYMENT TT where S.BIL_CYCLE like 'BILL_%s%%' and s.payment_cycle='Payment_%s%s' and S.BIL_CYCLE=PAY.BIL_CYCLE and TT.BIL_CYCLE = PAY.BIL_CYCLE and S.PAYMENT_CYCLE=PAY.PAYMENT_CYCLE and TT.PAYMENT_CYCLE = PAY.PAYMENT_CYCLE order by 1",$yearinvoice,$yearpayment,$cyclepayment);
	}	
	if ($service== 'SERVICES'){
		$query=sprintf("select substr(S.BIL_CYCLE,6,4),S.PAYMENT_CYCLE,S.SERVICES_OPEN_AMOUNT,S.BIL_TOTAL_SERVICES, S.BIL_TOTAL_SERVICES-S.SERVICES_OPEN_AMOUNT ,pay.SERVICES_OPEN_AMOUNT, pay.BIL_TOTAL_SERVICES,pay.BIL_TOTAL_SERVICES-pay.SERVICES_OPEN_AMOUNT, TT.BIL_TOTAL_SERVICES from VOSOLI_REPORT_SUMMARY_PAY_SALB s,VOSOLI_REPORT_SUMMARY_PAY_AC pay,VOSOLI_REPORT_SUMMARY_PAYMENT TT where S.BIL_CYCLE like 'BILL_%s%%' and s.payment_cycle='Payment_%s%s' and S.BIL_CYCLE=PAY.BIL_CYCLE and TT.BIL_CYCLE = PAY.BIL_CYCLE and S.PAYMENT_CYCLE=PAY.PAYMENT_CYCLE and TT.PAYMENT_CYCLE = PAY.PAYMENT_CYCLE order by 1",$yearinvoice,$yearpayment,$cyclepayment);
	}		
	if ($service== 'ABON'){
		$query=sprintf("select substr(S.BIL_CYCLE,6,4),S.PAYMENT_CYCLE,S.ABON_OPEN_AMOUNT,S.BIL_TOTAL_ABON, S.BIL_TOTAL_ABON-S.ABON_OPEN_AMOUNT ,pay.ABON_OPEN_AMOUNT, pay.BIL_TOTAL_ABON,pay.BIL_TOTAL_ABON-pay.ABON_OPEN_AMOUNT, TT.BIL_TOTAL_ABON from VOSOLI_REPORT_SUMMARY_PAY_SALB s,VOSOLI_REPORT_SUMMARY_PAY_AC pay,VOSOLI_REPORT_SUMMARY_PAYMENT TT where S.BIL_CYCLE like 'BILL_%s%%' and s.payment_cycle='Payment_%s%s' and S.BIL_CYCLE=PAY.BIL_CYCLE and TT.BIL_CYCLE = PAY.BIL_CYCLE and S.PAYMENT_CYCLE=PAY.PAYMENT_CYCLE and TT.PAYMENT_CYCLE = PAY.PAYMENT_CYCLE order by 1",$yearinvoice,$yearpayment,$cyclepayment);
	}		
			
	//echo $query;
	//سرویسecho $query;
$stid=oci_parse($conn,$query);
oci_execute($stid);




?>

<table width="60%" border="0" cellspacing="2" id="hor-minimalist-a" class="farsifont responstable">
<thead>
  <tr>
    <th colspan="6" align="center" valign="middle" ><span><?php echo sprintf("مبلغ کارکرد سرویس <strong>%s</strong> در سال <strong>%s</strong> به تفکیک وضعیت وصول تا آخر سال <strong>%s</strong> دوره <strong>%s</strong>",$service_name,$yearinvoice,$yearpayment,$cyclepayment);?></span> </td>
  </tr>
  <tr>
	
    <th rowspan="2" align="center" valign="middle" >دوره</th>
    <th rowspan="2" align="center" valign="middle" >کل مبلغ کارکرد</th>
    <th colspan="2" align="center" valign="middle" >مبلغ وصول شده</th>
    <th colspan="2" align="center" valign="middle" >مبلغ مانده</th>
	
  </tr>
  <tr>
    <th align="center" valign="middle" >وصول عادی</th>
    <th align="center" valign="middle" >وصول بعد از سلب</th>
    <th align="center" valign="middle" >مانده در بدهی</th>
    <th align="center" valign="middle" >مانده در سلب</th>
  </tr>
  </thead>
  <?php
  $sumnormalopen=0;
  $sumnormalclosed=0;
  $sumsalbopen=0;
  $sumsalbclosed=0;
  $suminvoice=0;
  
  while(($row = oci_fetch_row($stid))!= false){
$billcycle=$row[0];
$paymentcycle=$row[1];
$salbopen=$row[2];
$salbclosed=$row[4];
$normalopen=$row[5];
$normalclosed=$row[7];
$totalinvoice=$row[8];


$sumnormalopen=$sumnormalopen+$normalopen;
$sumnormalclosed=$sumnormalclosed+$normalclosed;
$sumsalbopen=$sumsalbopen+$salbopen;
$sumsalbclosed=$sumsalbclosed+$salbclosed;
$suminvoice=$suminvoice+$totalinvoice;


?>
  <tr>
    <td ><?php echo $billcycle;?></td>
    <td ><?php echo number_format($totalinvoice,0);?></td>
    <td ><?php echo number_format($normalclosed,0);?></td>
    <td ><?php echo number_format($salbclosed,0);?></td>
    <td ><?php echo number_format($normalopen,0);?></td>
    <td ><?php echo number_format($salbopen,0);?></td>
  </tr>
  <?php
  }
  
  function sumopeninvoice($sumsalbopen,$sumnormalopen,$suminvoice){
		if ($suminvoice==0) {return 0;}
		else {return ($sumsalbopen+$sumnormalopen)/$suminvoice*100;}

};

function sumcloseinvoice($sumsalbclosed,$sumnormalclosed,$suminvoice){
	if ($suminvoice==0) {return 0;}
		else {return ($sumsalbclosed+$sumnormalclosed)/$suminvoice*100;}
	
};
  ?>
  <tr>
	
    <td align="center" valign="middle" >جمع</td>
    <td align="center" valign="middle" ><?php echo number_format($suminvoice,0);?></td>
    <td align="center" valign="middle" ><?php echo number_format($sumnormalclosed,0);?></td>
    <td align="center" valign="middle" ><?php echo number_format($sumsalbclosed,0);?></td>
    <td align="center" valign="middle" ><?php echo number_format($sumnormalopen,0);?></td>
    <td align="center" valign="middle" ><?php echo number_format($sumsalbopen,0);?></td>
	
	
	
  </tr>
  <tr>
    <td colspan="2" align="center" valign="middle" >درصد</td>
    <td colspan="2" align="center" valign="middle" ><?php echo number_format(sumcloseinvoice($sumsalbclosed,$sumnormalclosed,$suminvoice),0);?></td>
    <td colspan="2" align="center" valign="middle" ><?php echo number_format(sumopeninvoice($sumsalbopen,$sumnormalopen,$suminvoice),0);?></td>
	
	
  </tr>
</table>
<?php

oci_free_statement($stid);
oci_close($conn);

}
?>

</body>
</html>