
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>

<meta http-equiv="Content-Type" content="text/html" charset="utf-8"/>

<title>لاوصولی</title>

</head>

<body contextmenu="return false">
<?php
function convertToEnglish($string) {
    $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
    $num = range(0, 9);
    return str_replace($persian, $num, $string);
}
//dl("d:\php\ext\php_oci8_12c.dll");
	$conn = oci_connect("billuser","billing","billdata");

if (!$conn){
$e = oci_error();
  trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);

}
else{
  // parameters from url
	$fieldNames = explode('&', $_POST['fieldsNames']);
	$fieldsValues = explode( '&', $_POST['fieldsValues']);

	$fields = array();
	for( $i = 0; $i<sizeof($fieldNames); $i++){
		$fields[$fieldNames[$i]] = $fieldsValues[$i];
	}


	$yearinvoice= $fields[ 'yearinvoice' ];
	$yearpayment= $fields[ 'yearpayment' ];
	$cyclepayment= $fields[ 'cyclepayment' ];

	$query=sprintf("select sum(D.ABON_OPEN_AMOUNT),sum(D.BIL_TOTAL_ABON),sum(D.LOCAL_OPEN_AMOUNT),sum(D.LOCAL_TOTAL_AMOUNT),sum(D.SMS_OPEN_AMOUNT),sum(D.BIL_TOTAL_SMS),sum(D.MMS_OPEN_AMOUNT),sum(D.BIL_TOTAL_MMS),sum(D.VAS_OPEN_AMOUNT),sum(d.vas_total_amount),sum(D.INTERNATIONAL_OPEN_AMOUNT),sum(D.BIL_TOTAL_INT),sum(D.INT_ROAM_OPEN_AMOUNT),sum(D.BIL_TOTAL_ROAM),sum(D.SERVICES_OPEN_AMOUNT),sum(D.BIL_TOTAL_SERVICES),sum(D.COSTS_OPEN_AMOUNT),sum(D.BIL_TOTAL_COSTS),sum(D.CHARITY_OPEN_AMOUNT),sum(D.BIL_TOTAL_CHARITY) from billuser.VOSOLI_REPORT_SUMMARY_PAYMENT d where d.PAYMENT_CYCLE='Payment_%s%s' and substr(d.BIL_CYCLE,6,2)='%s'",$yearpayment,$cyclepayment,$yearinvoice);
	//echo $query;
$stid=oci_parse($conn,$query);
oci_execute($stid);
$numrecords=oci_num_rows($stid);
//if ($numrecords>0){
$row = oci_fetch_row($stid);
$total_services=10;

$abon_open=$row[0];
$abon_total=$row[1];
if ($abon_total==0) {--$total_services;}

$local_open=$row[2];
$local_total=$row[3];
if ($local_total==0) {--$total_services;}

$sms_open=$row[4];
$sms_total=$row[5];
if ($sms_total==0) {--$total_services;}


$mms_open=$row[6];
$mms_total=$row[7];
if ($mms_total==0) {--$total_services;}

$vas_open=$row[8];
$vas_total=$row[9];
if ($vas_total==0) {--$total_services;}

$int_open=$row[10];
$int_total=$row[11];
if ($int_total==0) {--$total_services;}


$roam_open=$row[12];
$roam_total=$row[13];
if ($roam_total==0) {--$total_services;}


$services_open=$row[14];
$services_total=$row[15];
if ($services_total==0) {--$total_services;}

$costs_open=$row[16];
$costs_total=$row[17];
if ($costs_total==0) {--$total_services;}


$charity_open=$row[18];
$charity_total=$row[19];
if ($charity_total==0) {--$total_services;}


$sum_total=$abon_total+$local_total+$sms_total+$mms_total+$vas_total+$int_total+$roam_total+$services_total+$costs_total+$charity_total;
$sum_open=$abon_open+$local_open+$sms_open+$mms_open+$vas_open+$int_open+$roam_open+$services_open+$costs_open+$charity_open;
if ($sum_total==0){
	$rate_abon_total=0;
	$rate_local_total=0;
	$rate_sms_total=0;
	$rate_mms_total=0;
	$rate_vas_total=0;
	$rate_roam_total=0;
	$rate_int_total=0;
	$rate_services_total=0;
	$rate_costs_total=0;
	$rate_charity_total=0;

}
else {
$rate_abon_total=$abon_total/$sum_total*100;
$rate_local_total=$local_total/$sum_total*100;
$rate_sms_total=$sms_total/$sum_total*100;
$rate_mms_total=$mms_total/$sum_total*100;
$rate_vas_total=$vas_total/$sum_total*100;
$rate_roam_total=$roam_total/$sum_total*100;
$rate_int_total=$int_total/$sum_total*100;
$rate_services_total=$services_total/$sum_total*100;
$rate_costs_total=$costs_total/$sum_total*100;
$rate_charity_total=$charity_total/$sum_total*100;
}

$sum_rate=$rate_abon_total+$rate_local_total+$rate_sms_total+$rate_mms_total+$rate_int_total+$rate_services_total+$rate_roam_total+$rate_vas_total+$rate_costs_total+$rate_charity_total;

$payment_abon=$abon_total-$abon_open;
$payment_local=$local_total-$local_open;
$payment_sms=$sms_total-$sms_open;
$payment_mms=$mms_total-$mms_open;
$payment_int=$int_total-$int_open;
$payment_roam=$roam_total-$roam_open;
$payment_vas=$vas_total-$vas_open;
$payment_services=$services_total-$services_open;
$payment_costs=$costs_total-$costs_open;
$payment_charity=$charity_total-$charity_open;

$sum_payment=$payment_abon+$payment_local+$payment_sms+$payment_mms+$payment_int+$payment_roam+$payment_vas+$payment_services+$payment_costs+$payment_charity;

if ($sum_payment==0){
	$rate_payment_abon=0;
	$rate_payment_local=0;
	$rate_payment_sms=0;
	$rate_payment_mms=0;
	$rate_payment_int=0;
	$rate_payment_roam=0;
	$rate_payment_vas=0;
	$rate_payment_services=0;
	$rate_payment_costs=0;
	$rate_payment_charity=0;
}
else {
	$rate_payment_abon=$payment_abon/$sum_payment*100;
	$rate_payment_local=$payment_local/$sum_payment*100;
	$rate_payment_sms=$payment_sms/$sum_payment*100;
	$rate_payment_mms=$payment_mms/$sum_payment*100;
	$rate_payment_int=$payment_int/$sum_payment*100;
	$rate_payment_roam=$payment_roam/$sum_payment*100;
	$rate_payment_vas=$payment_vas/$sum_payment*100;
	$rate_payment_services=$payment_services/$sum_payment*100;
	$rate_payment_costs=$payment_costs/$sum_payment*100;
	$rate_payment_charity=$payment_charity/$sum_payment*100;
}
$sum_rate_payment=$rate_payment_abon+$rate_payment_local+$rate_payment_sms+$rate_payment_mms+$rate_payment_int+$rate_payment_roam+$rate_payment_vas+$rate_payment_costs+$rate_payment_services+$rate_payment_charity;

if ($abon_total==0){$rate_totaltopayment_abon=0;}
else {
$rate_totaltopayment_abon=$payment_abon/$abon_total*100;
}
if ($local_total==0) {$rate_totaltopayment_local=0;}
else {
$rate_totaltopayment_local=$payment_local/$local_total*100;}
if ($sms_total==0) {$rate_totaltopayment_sms=0;}
else {
$rate_totaltopayment_sms=$payment_sms/$sms_total*100;
}
if ($mms_total==0){$rate_totaltopayment_mms=0;}
else {
$rate_totaltopayment_mms=$payment_mms/$mms_total*100;
}

if ($int_total==0) {$rate_totaltopayment_int=0;}
else {
$rate_totaltopayment_int=$payment_int/$int_total*100;
}
if ($roam_total==0) {$rate_totaltopayment_roam=0;}
else {
$rate_totaltopayment_roam=$payment_roam/$roam_total*100;
}
if ($vas_total==0) {$rate_totaltopayment_vas=0;}
else{
$rate_totaltopayment_vas=$payment_vas/$vas_total*100;
}
if ($services_total==0) {$rate_totaltopayment_services=0;}
else {
$rate_totaltopayment_services=$payment_services/$services_total*100;
}
if ($costs_total==0) {$rate_totaltopayment_costs=0;}
else {
$rate_totaltopayment_costs=$payment_costs/$costs_total*100;}
if ($charity_total==0) {$rate_totaltopayment_charity=0;}
else {
$rate_totaltopayment_charity=$payment_charity/$charity_total*100;}


$sum_rate_totaltopayment=($rate_totaltopayment_abon+$rate_totaltopayment_local+$rate_totaltopayment_sms+$rate_totaltopayment_mms+$rate_totaltopayment_int+$rate_totaltopayment_roam+$rate_totaltopayment_vas+$rate_totaltopayment_services+$rate_totaltopayment_costs+$rate_totaltopayment_charity)/$total_services;

if ($sum_open==0){
	$rate_opentototal_abon=0;
	$rate_opentototal_local=0;
	$rate_opentototal_sms=0;
	$rate_opentototal_mms=0;
	$rate_opentototal_int=0;
	$rate_opentototal_roam=0;
	$rate_opentototal_vas=0;
	$rate_opentototal_services=0;
	$rate_opentototal_costs=0;
	$rate_opentototal_charity=0;
}
else {
	$rate_opentototal_abon=$abon_open/$sum_open*100;
	$rate_opentototal_local=$local_open/$sum_open*100;
	$rate_opentototal_sms=$sms_open/$sum_open*100;
	$rate_opentototal_mms=$mms_open/$sum_open*100;
	$rate_opentototal_int=$int_open/$sum_open*100;
	$rate_opentototal_roam=$roam_open/$sum_open*100;
	$rate_opentototal_vas=$vas_open/$sum_open*100;
	$rate_opentototal_services=$services_open/$sum_open*100;
	$rate_opentototal_costs=$costs_open/$sum_open*100;
	$rate_opentototal_charity=$charity_open/$sum_open*100;
}

$sum_opentototal=($rate_opentototal_abon+$rate_opentototal_local+$rate_opentototal_sms+$rate_opentototal_mms+$rate_opentototal_int+$rate_opentototal_roam+$rate_opentototal_vas+$rate_opentototal_services+$rate_opentototal_costs+$rate_opentototal_charity);

if ($abon_total==0){$rate_opentoinvoice_abon=0;}
else {
$rate_opentoinvoice_abon=$abon_open/$abon_total*100;
}
if ($local_total==0) {$rate_opentoinvoice_local=0;}
else {
$rate_opentoinvoice_local=$local_open/$local_total*100;
}
if ($sms_total==0){$rate_opentoinvoice_sms=0;}
else{
$rate_opentoinvoice_sms=$sms_open/$sms_total*100;
}
if ($mms_total==0) {$rate_opentoinvoice_mms=0;}
else {
$rate_opentoinvoice_mms=$mms_open/$mms_total*100;
}
if ($int_total==0) {$rate_opentoinvoice_int=0;}
else {
$rate_opentoinvoice_int=$int_open/$int_total*100;
}
if ($roam_total==0) {$rate_opentoinvoice_roam=0;}
else {
$rate_opentoinvoice_roam=$roam_open/$roam_total*100;
}
if ($vas_total==0) {$rate_opentoinvoice_vas=0;}
else {
$rate_opentoinvoice_vas=$vas_open/$vas_total*100;
}
if ($services_total==0) {$rate_opentoinvoice_services=0;}
else {
$rate_opentoinvoice_services=$services_open/$services_total*100;
}
if ($costs_total==0) {$rate_opentoinvoice_costs=0;}
else {
$rate_opentoinvoice_costs=$costs_open/$costs_total*100;
}

if ($charity_total==0) {$rate_opentoinvoice_charity=0;}
else {
$rate_opentoinvoice_charity=$charity_open/$charity_total*100;
}

$sum_avg_opentoinvoice=($rate_opentoinvoice_abon+$rate_opentoinvoice_local+$rate_opentoinvoice_sms+$rate_opentoinvoice_mms+$rate_opentoinvoice_int+$rate_opentoinvoice_roam+$rate_opentoinvoice_vas+$rate_opentoinvoice_services+$rate_opentoinvoice_costs+$rate_opentoinvoice_charity)/$total_services;


//while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
//    echo "<tr>\n";
//    foreach ($row as $item) {
//        echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;")  . "</td>\n";
//    }
//    echo "</tr>\n";

//echo "</table>\n";

?>
<div style='width:80%;margin:auto;' >
<div class=tab_toolbar>
	<i class="fa fa-refresh toolbar_icon toolbar_refresh" ></i>
	<i class="fa fa-download toolbar_icon toolbar_export" id = "exporttoexcel"  table_name="hor-minimalist-a" file_name="lavosoli" sheet_name="lavosoli"></i>
	<i class="fa fa-repeat toolbar_icon toolbar_repeat"></i>
	<i class="fa fa-envelope toolbar_icon" ></i>
	<i class="fa fa-print toolbar_icon"></i>
</div>
<table  border="0" cellspacing="2" id="hor-minimalist-a" class="farsifont responstable">

  <thead>
  <tr>
    <th colspan="9" align="center" valign="middle" >
     <?php echo sprintf("مبلغ کارکرد سرویس های مختلف در سال <strong>%s</strong> به تفکیک وصول آن تا سال <strong>%s</strong> دوره  <strong>%s</strong>",$yearinvoice,$yearpayment,$cyclepayment); ?>
	</th>
  </tr>

  <tr  >
    <th ><div align="center" valign="middle" >نوع سرویس</div></th>
    <th ><div align="center">مبلغ کل صدوری</div></th>
    <th ><div align="center">درصد از کل صدوری</div></th>
    <th ><div align="center">مبلغ کل وصولی</div></th>
    <th ><div align="center">درصد از کل وصولی</div></th>
    <th ><div align="center">درصد وصولی به صدوری</div></th>
    <th ><div align="center">مبلغ مانده</div></th>
    <th ><div align="center">درصد به کل بدهی پیشین</div></th>
    <th ><div align="center">درصد مانده به صدوری</div></th>
	</tr>
  </thead>
  <tbody class=scroll_section>
  <tr>
    <td align="right" valign="middle" >آبونمان</td>
    <td align="left" ><?php echo number_format($abon_total);?></td>
    <td align="left" ><?php echo number_format($rate_abon_total,2,".",",");?> </td>
    <td align="left" ><?php echo number_format($payment_abon);?></td>
    <td align="left" ><?php echo number_format($rate_payment_abon,2,".",",");?></td>
    <td align="left" ><?php echo number_format($rate_totaltopayment_abon,2,".",",");?></td>
    <td align="left" ><?php echo number_format($abon_open);?></td>
    <td align="left" ><?php echo number_format($rate_opentototal_abon,2,".",",");?></td>
    <td align="center" ><?php echo number_format($rate_opentoinvoice_abon,2,".",",");?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">تماس داخلی</td>
    <td align="left" ><?php echo number_format($local_total);?></td>
    <td align="left" ><?php echo number_format($rate_local_total,2,".",",");?> </td>
    <td align="left" ><?php echo number_format($payment_local);?></td>
    <td align="left" ><?php echo number_format($rate_payment_local,2,".",",");?></td>
    <td align="left" ><?php echo number_format($rate_totaltopayment_local,2,".",",");?></td>
    <td align="left" ><?php echo number_format($local_open);?></td>
    <td align="left" ><?php echo number_format($rate_opentototal_local,2,".",",");?></td>
    <td align="center" ><?php echo number_format($rate_opentoinvoice_local,2,".",",");?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">پیام متنی</td>
    <td align="left" ><?php echo number_format($sms_total);?></td>
    <td align="left" ><?php echo number_format($rate_sms_total,2,".",",");?> </td>
    <td align="left" ><?php echo number_format($payment_sms);?></td>
    <td align="left" ><?php echo number_format($rate_payment_sms,2,".",",");?></td>
    <td align="left" ><?php echo number_format($rate_totaltopayment_sms,2,".",",");?></td>
    <td align="left" ><?php echo number_format($sms_open);?></td>
    <td align="left" ><?php echo number_format($rate_opentototal_sms,2,".",",");?></td>
    <td align="center" ><?php echo number_format($rate_opentoinvoice_sms,2,".",",");?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">پیام چند رسانه ای</td>
    <td align="left" ><?php echo number_format($mms_total);?></td>
    <td align="left" ><?php echo number_format($rate_mms_total,2,".",",");?> </td>
    <td align="left" ><?php echo number_format($payment_mms);?></td>
    <td align="left" ><?php echo number_format($rate_payment_mms,2,".",",");?></td>
    <td align="left" ><?php echo number_format($rate_totaltopayment_mms,2,".",",");?></td>
    <td align="left" ><?php echo number_format($mms_open);?></td>
    <td align="left" ><?php echo number_format($rate_opentototal_mms,2,".",",");?></td>
    <td align="center" ><?php echo number_format($rate_opentoinvoice_mms,2,".",",");?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">خدمات </td>
    <td align="left" ><?php echo number_format($services_total);?></td>
    <td align="left" ><?php echo number_format($rate_services_total,2,".",",");?> </td>
    <td align="left" ><?php echo number_format($payment_services);?></td>
    <td align="left" ><?php echo number_format($rate_payment_services,2,".",",");?></td>
    <td align="left" ><?php echo number_format($rate_totaltopayment_services,2,".",",");?></td>
    <td align="left" ><?php echo number_format($services_open);?></td>
    <td align="left" ><?php echo number_format($rate_opentototal_services,2,".",",");?></td>
    <td align="center" ><?php echo number_format($rate_opentoinvoice_services,2,".",",");?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">مکالمه خارجه </td>
    <td align="left" ><?php echo number_format($int_total);?></td>
    <td align="left" ><?php echo number_format($rate_int_total,2,".",",");?> </td>
    <td align="left" ><?php echo number_format($payment_int);?></td>
    <td align="left" ><?php echo number_format($rate_payment_int,2,".",",");?></td>
    <td align="left" ><?php echo number_format($rate_totaltopayment_int,2,".",",");?></td>
    <td align="left" ><?php echo number_format($int_open);?></td>
    <td align="left" ><?php echo number_format($rate_opentototal_int,2,".",",");?></td>
    <td align="center" ><?php echo number_format($rate_opentoinvoice_int,2,".",",");?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">بسته ها</td>
    <td align="left" ><?php echo number_format($costs_total);?></td>
    <td align="left" ><?php echo number_format($rate_costs_total,2,".",",");?> </td>
    <td align="left" ><?php echo number_format($payment_costs);?></td>
    <td align="left" ><?php echo number_format($rate_payment_costs,2,".",",");?></td>
    <td align="left" ><?php echo number_format($rate_totaltopayment_costs,2,".",",");?></td>
    <td align="left" ><?php echo number_format($costs_open);?></td>
    <td align="left" ><?php echo number_format($rate_opentototal_costs,2,".",",");?></td>
    <td align="center" ><?php echo number_format($rate_opentoinvoice_costs,2,".",",");?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">رومینگ بین الملل</td>
    <td align="left" ><?php echo number_format($roam_total);?></td>
    <td align="left" ><?php echo number_format($rate_roam_total,2,".",",");?></td>
    <td align="left" ><?php echo number_format($payment_roam);?></td>
    <td align="left" ><?php echo number_format($rate_payment_roam,2,".",",");?></td>
    <td align="left" ><?php echo number_format($rate_totaltopayment_roam,2,".",",");?></td>
    <td align="left" ><?php echo number_format($roam_open);?></td>
    <td align="left" ><?php echo number_format($rate_opentototal_roam,2,".",",");?></td>
    <td align="center" ><?php echo number_format($rate_opentoinvoice_roam,2,".",",");?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">ارزش افزوده</td>
    <td align="left" ><?php echo number_format($vas_total);?></td>
    <td align="left" ><?php echo number_format($rate_vas_total,2,".",",");?></td>
    <td align="left" ><?php echo number_format($payment_vas);?></td>
    <td align="left" ><?php echo number_format($rate_payment_vas,2,".",",");?></td>
    <td align="left" ><?php echo number_format($rate_totaltopayment_vas,2,".",",");?></td>
    <td align="left" ><?php echo number_format($vas_open);?></td>
    <td align="left" ><?php echo number_format($rate_opentototal_vas,2,".",",");?></td>
    <td align="center" ><?php echo number_format($rate_opentoinvoice_vas,2,".",",");?></td>
  </tr>
  <tr>
	<td align="right" valign="middle">جمع آوری وجوه</td>
    <td align="left" ><?php echo number_format($charity_total);?></td>
    <td align="left" ><?php echo number_format($rate_charity_total,2,".",",");?></td>
    <td align="left" ><?php echo number_format($payment_charity);?></td>
    <td align="left" ><?php echo number_format($rate_payment_charity,2,".",",");?></td>
    <td align="left" ><?php echo number_format($rate_totaltopayment_charity,2,".",",");?></td>
    <td align="left" ><?php echo number_format($charity_open);?></td>
    <td align="left" ><?php echo number_format($rate_opentototal_charity,2,".",",");?></td>
    <td align="center" ><?php echo number_format($rate_opentoinvoice_charity,2,".",",");?></td>
  </tr>

  <tr>
	<td  align="right" valign="middle">جمع کل</td>
    <td align="left" ><?php echo number_format($sum_total);?></td>
    <td align="left" ><?php echo number_format($sum_rate);?></td>
    <td align="left" ><?php echo number_format($sum_payment);?></td>
    <td align="left" ><?php echo number_format($sum_rate_payment);?></td>
    <td align="left" ><?php echo number_format($sum_rate_totaltopayment);?></td>
    <td align="left" ><?php echo number_format($sum_open);?></td>
    <td align="left" ><?php echo number_format($sum_opentototal);?></td>
    <td align="center" ><?php echo number_format($sum_avg_opentoinvoice);?></td>
  </tr>

  </tbody>
</table>
</div>

<?php
//}
//else
//{
//	echo "no record found";

//}
oci_free_statement($stid);
oci_close($conn);

}
?>

<form action="creatingexcel.php" method="get" name="excel">
<!--<input name="export" type="submit" value="export to excel" />-->
</form>
<!--<button id = "exporttoexcel"> export2</button>-->
<p id="demo"> </p>
</body>
</html>
