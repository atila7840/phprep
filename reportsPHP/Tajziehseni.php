<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>

<meta http-equiv="Content-Type" content="text/html" charset="utf-8"/>

<title>تجزیه سنی</title>

</head>

<body contextmenu="return false">
<?php
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
	
	
	$year=$fields["year"];
	$cycle=$fields["cycle"];
	$province=$fields["province"];
	$province_name=$fields["province_name"];
	//$province='0';
	//$year='95';
	//$cycle='09';
	

//select TAJZIYE_SENNI_MAIN_TABLE.*,(select PROV_FA_NAME from province where TAJZIYE_SENNI_MAIN_TABLE.PROVINCE_CODE=PROVINCE.PROV_CODE) from TAJZIYE_SENNI_MAIN_TABLE where PROVINCE_CODE='0' and bil_cycle>='9404' order by bil_cycle;	
	if ($province=="all"){
		$query=sprintf("select 'all','payment',BIL_CYCLE,'prov',sum(HAGHIGHI),sum(HOGHOOGHI),sum(TEST_FANNI),sum(HAMEGANI),sum(ROOSTAI),sum(GOROOHDAR),sum(DASTOORI),sum(TOTAL),sum(PERCENTAGE),sum(DEBT)from  TAJZIYE_SENNI_MAIN_TABLE where payment_cycle='%s%s'group by BIL_CYCLE order by BIL_CYCLE",$year,$cycle);

$query2=sprintf("select sum(total) from TAJZIYE_SENNI_MAIN_TABLE where payment_cycle='%s%s'",$year,$cycle);
	}
	else {
			
$query=sprintf("select * from TAJZIYE_SENNI_MAIN_TABLE where PROVINCE_CODE='%s' and payment_cycle='%s%s' order by bil_cycle",$province,$year,$cycle);

$query2=sprintf("select sum(total) from TAJZIYE_SENNI_MAIN_TABLE where PROVINCE_CODE='%s' and payment_cycle='%s%s'",$province,$year,$cycle);
	}
	
$stid=oci_parse($conn,$query);
oci_execute($stid);

$stid2=oci_parse($conn,$query2);
oci_execute($stid2);

$row=oci_fetch_row($stid2);
$final_sum=$row[0];
//echo $final_sum;

//$table_id = 'tajzieSeni'.date('l');
?>
<div style='width:80%;margin:auto;' >
<div class=tab_toolbar>
	<i class="fa fa-refresh toolbar_icon toolbar_refresh" ></i>
	<i class="fa fa-download toolbar_icon toolbar_export" id = "exporttoexcel"  table_name="hor-minimalist-a" file_name="tajziehseni" sheet_name="tajziehseni"></i>
	<i class="fa fa-repeat toolbar_icon toolbar_repeat"></i>
	<i class="fa fa-envelope toolbar_icon" ></i>
	<i class="fa fa-print toolbar_icon"></i>
</div>
   <table width="85%" border="0" align="center" cellspacing="2" id="hor-minimalist-a" class="farsifont responstable">
  <tr>
    <td colspan="12" align="center" valign="middle" >
    <?php echo sprintf("گزارش تفکیک بدهی براساس سنوات بدهی-تجزیه سنی از سال دوره <strong>%s%s</strong> استان <strong>%s</strong> ",$year,$cycle,$province_name); ?></td>


  </tr>

  <tr  >
	
    <td width="9%" rowspan="2" align="center">بدهی باقیمانده ازسال و دوره</td>
    <td colspan="2" align="center" >مشترکین عادی</td>
    <td width="10%" rowspan="2" align="center" >تست فنی</td>
    <td width="6%" rowspan="2" align="center" >همگانی</td>
    <td width="6%" rowspan="2" align="center" >روستایی</td>
    <td width="6%" rowspan="2" align="center" >گروه دار</td>
    <td width="6%" rowspan="2" align="center" >دستوری</td>
    <td width="11%" rowspan="2" align="center" >جمع کل_ریال</td>
    <td width="7%" rowspan="2" align="center" >درصد به جمع کل</td>
    <td width="14%" rowspan="2" align="center" >کاهش بدهي نسبت به دوره قبل </td>
   
  </tr>
  <tr>
    <td width="14%" align="center" >حقیقی</td>
    <td width="11%" height="25" align="center" >حقوقی</td>
	
    </tr>
<?php

$sum_haghighi=0;
$sum_hoghooghi=0;
$sum_test=0;
$sum_hamegani=0;
$sum_roostai=0;
$sum_group=0;
$sum_dastoori=0;
$sum_sum=0;
$sum_rate=0;
$old=0;
$new=0;

while (($row = oci_fetch_row($stid)) != false) {

$bill_cycle=$row[2];
$haghighi_sub=$row[4];
$hoghooghi_sub=$row[5];
$test_fani=$row[6];
$hamegani=$row[7];
$roostai=$row[8];
$group=$row[9];
$dastoori=$row[10];
$sum_total=$row[11];
$reduce_debt=$row[13];
//$new=$sum_total;
//$old=$new;
$rate_to_total=($sum_total/$final_sum)*100;

$sum_haghighi=$sum_haghighi+$haghighi_sub;
$sum_hoghooghi=$sum_hoghooghi+$hoghooghi_sub;
$sum_test=$sum_test+$test_fani;
$sum_hamegani=$sum_hamegani+$hamegani;
$sum_roostai=$sum_roostai+$roostai;
$sum_group=$sum_group+$group;
$sum_dastoori=$sum_dastoori+$dastoori;
$sum_sum=$sum_sum+$sum_total;
$sum_rate=$sum_rate+$rate_to_total;


?>

  <tr>
	
    <td align="left" ><?php echo $bill_cycle;?></td>
    <td align="left" ><?php echo number_format($haghighi_sub);?></td>
    <td align="left" ><?php echo number_format($hoghooghi_sub);?></td>
    <td align="left" ><?php echo number_format($test_fani);?> </td>
    <td align="left" ><?php echo number_format($hamegani);?></td>
    <td align="left" ><?php echo number_format($roostai);?></td>
    <td align="left" ><?php echo number_format($group);?></td>
    <td align="left" ><?php echo number_format($dastoori);?></td>
    <td align="left" ><?php echo number_format($sum_total);?></td>
    <td align="left" ><?php echo number_format ($rate_to_total,2),'%';?></td>
    <td align="left" ><?php echo number_format($reduce_debt);?></td>
    
  </tr>
 <?php
}
?>

   <tr>
	
    <td align="right" valign="middle" >جمع کل</td>
    <td align="left" ><?php echo number_format($sum_haghighi);?></td>
    <td align="left" ><?php echo number_format($sum_hoghooghi);?></td>
    <td align="left" ><?php echo number_format($sum_test);?></td>
    <td align="left" ><?php echo number_format($sum_hamegani);?></td>
    <td align="left" ><?php echo number_format($sum_roostai);?></td>
    <td align="left" ><?php echo number_format($sum_group);?></td>
    <td align="left" ><?php echo number_format($sum_dastoori);?></td>
    <td align="left" ><?php echo number_format($sum_sum);?></td>
    <td align="left" ><?php echo number_format($sum_rate,0),'%';?></td>
    <td align="center" valign="middle" >__</td>
 
    </tr>
  
</table>

<?php

oci_free_statement($stid);
oci_free_statement($stid2);
oci_close($conn);

}
?>



<button id = "exporttoexcel"  table_name="hor-minimalist-a" file_name="tajziehseni"> export2</button>


<p id="demo"> </p>
</body>
</html>