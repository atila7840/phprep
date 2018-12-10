
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>

<meta http-equiv="Content-Type" content="text/html" charset="utf-8"/>


</head>

<body contextmenu="return false">
<?php
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
	
	$province_name=  $fields[ 'province_name' ];
	$province=$fields['province'];	
	//echo "y1=".$_GET["y1"]." y2=".$_GET["y2"]." c2=".$_GET["c2"];
	//$year=$_GET["year"];
	//$year="93";
	
	//$cycle=$_GET["cycle"];
	//$cycle="01";
	//$province=""; //can select whole country
	
	
	if ($province=="all"){
		$query=sprintf("select 'all',
  sum(TEDADE_SOORATHESAB),
  sum(MOKALEMAT_DAGHIGHE),
  sum(ABONMAN),
  sum(MOKALEMAT)              ,
  sum(KHAREJEH)               ,
  sum(ROAMING)                ,
  sum(PAYAME_KOOTAH)          ,
  sum(PAYAME_SOTI)            ,
  sum(GPRS)                   ,
  sum(MMS)                    ,
  sum(SAYER_KHADAMAT)         ,
  sum(KHADAMATE_VIZHE)        ,
  sum(KHADAMATE_MOHTAVA)      ,
  sum(DORE)                   ,
  sum(TAKHFIFAT)              ,
  sum(DORE_MASHMOOL_MALIAT)   ,
  sum(MALIYAT)                ,
  sum(DORE_BA_MALIYAT)        ,
  sum(BEDEHI_PISHIN)          ,
  sum(DORE_BA_BEDEHI)         ,
  sum(BESTANKARI)             ,
  sum(MOAFFIYAT)              ,
  sum(KOMAKHAYE_MARDOMI)      ,
  sum(DARAMADE_OMOOMI_DOLAT)  ,
  sum(KASRE_HEZAR_RIAL)     ,
  sum(BESTANKARI_BAGHIMANDE),
  sum(GHABLE_PARDAKHT)
   from  DARAMADE_KOLE_KESHVAR where cycle='%s%s'",$year,$cycle);
	}
	else {	
	$query=sprintf("select * from DARAMADE_KOLE_KESHVAR where cycle ='%s%s' and province=%s",$year,$cycle,$province);
	}
	//echo $query;
$stid=oci_parse($conn,$query);
oci_execute($stid);

$row = oci_fetch_row($stid);
  
  $TEDADE_SOORATHESAB     =$row[1];
  $MOKALEMAT_DAGHIGHE     =$row[2];
  $ABONMAN                =$row[3];
  $MOKALEMAT              =$row[4];
  $KHAREJEH               =$row[5];
  $ROAMING                =$row[6];
  $PAYAME_KOOTAH          =$row[7];
  $PAYAME_SOTI            =$row[8];
  $GPRS                   =$row[9];
  $MMS                    =$row[10];
  $SAYER_KHADAMAT         =$row[11];
  $KHADAMATE_VIZHE        =$row[12];
  $KHADAMATE_MOHTAVA      =$row[13];
  $DORE                   =$row[14];
  $TAKHFIFAT              =$row[15];
  $DORE_MASHMOOL_MALIAT   =$row[16];
  $MALIYAT                =$row[17];
  $DORE_BA_MALIYAT        =$row[18];
  $BEDEHI_PISHIN          =$row[19];
  $DORE_BA_BEDEHI         =$row[20];
  $BESTANKARI             =$row[21];
  $MOAFFIYAT              =$row[22];
  $KOMAKHAYE_MARDOMI      =$row[23];
  $KASRE_HEZAR_RIAL       =$row[24];
  $BESTANKARI_BAGHIMANDE  =$row[25];
  $GHABLE_PARDAKHT        =$row[26];
//  $CYCLE                  =$row[27];
?>


<table width="45%" border="0" align="center" cellspacing="2" id="hor-minimalist-a" class="farsifont responstable">
<thead>
  <tr>
    <th colspan="3" align="center" valign="middle" >خلاصه درآمد نا خالص  کشور سال <strong><?php echo $year; ?></strong>دوره<strong><?php echo $cycle; ?></strong> حوزه <strong><?php echo $province_name; ?></strong>  </th>
  </tr>
  
  <tr>
	
    <th align="right" valign="middle" >نوع سرویس</th>
    <th><div align="center">مطالبات</div></th>
    <th ><div align="center">کسورات</div></th>
	
  </tr>
</thead> 
<tbody> 
  <tr>
	
	
    <td align="right" valign="middle"   >تعداد صورت حساب</td>
    <td align="left" ><?php echo number_format($TEDADE_SOORATHESAB);?></td>
    <td align="left" >&nbsp;</td>
	
	
  </tr>
  <tr>

    <td align="right" valign="middle"  >جمع کل مکالمات به دقیقه</td>
    <td align="left" ><?php echo number_format($MOKALEMAT_DAGHIGHE);?></td>
    <td align="left" >&nbsp;</td>
	
  </tr>
  <tr>

    <td align="right" valign="middle"  >آبونمان</td>
    <td align="left" ><?php echo number_format($ABONMAN);?></td>
    <td align="left" >&nbsp;</td>
	
  </tr>
  <tr>
    <td align="right" valign="middle" >تماس داخلی</td>
    <td align="left" ><?php echo number_format($MOKALEMAT);?></td>
    <td align="left" >&nbsp;</td>
  </tr>
  <tr>
	
    <td align="right" valign="middle" >مکالمه خارجه </td>
    <td align="left" ><?php echo number_format($KHAREJEH);?></td>
    <td align="left" >&nbsp;</td>
	
	
  </tr>
  <tr>
	
    <td align="right" valign="middle" >رومینگ بین الملل</td>
    <td align="left" ><?php echo number_format($ROAMING);?></td>
    <td align="left" >&nbsp;</td>
	
  </tr>
  <tr>
	
    <td align="right" valign="middle" >پیام متنی</td>
    <td align="left" ><?php echo number_format($PAYAME_KOOTAH);?></td>
    <td align="left" >&nbsp;</td>
	
  </tr>
  <tr>
	
    <td align="right" valign="middle" >پیام صوتی</td>
    <td align="left" ><?php echo number_format($PAYAME_SOTI);?></td>
    <td align="left" >&nbsp;</td>
	
  </tr>
  <tr>
    <td align="right" valign="middle" >GPRS</td>
    <td align="left" ><?php echo number_format($GPRS);?></td>
    <td align="left" >&nbsp;</td>
  </tr>
  <tr>
	
    <td align="right" valign="middle" >MMS</td>
    <td align="left" ><?php echo number_format($MMS);?></td>
    <td align="left" >&nbsp;</td>
	
  </tr>
  <tr>
	<td align="right" valign="middle" >سایر خدمات</td>
    <td align="left" ><?php echo number_format($SAYER_KHADAMAT);?></td>
    <td align="left" >&nbsp;</td>
	
  </tr>
  <tr>
	
    <td align="right" valign="middle" >خدمات ویژه</td>
    <td align="left" ><?php echo number_format($KHADAMATE_VIZHE);?></td>
    <td align="left" >&nbsp;</td>
	
  </tr>
  <tr>
	
    <td align="right" valign="middle" >خدمات مبتنی بر محتوا</td>
    <td align="left" ><?php echo number_format($KHADAMATE_MOHTAVA);?></td>
    <td height="30" align="left" >&nbsp;</td>
	
  </tr>
  <tr>
    <td align="right" valign="middle" >جمع صورت حساب دوره</td>
    <td align="left" ><?php echo number_format($DORE);?></td>
    <td align="left" >&nbsp;</td>
	
  </tr>
  <tr>
    <td align="right" valign="middle" >تخفیفات</td>
    <td align="left" >&nbsp;</td>
    <td align="left" ><?php echo number_format($TAKHFIFAT);?></td>
	
  </tr>  <tr>
	
    <td align="right" valign="middle" >جمع صورت حساب دوره مشمول مالیات و عوارض</td>
    <td align="left" ><?php echo number_format($DORE_MASHMOOL_MALIAT);?></td>
    <td align="left" >&nbsp;</td>
	
  </tr>  <tr>
	
    <td align="right" valign="middle" >جمع  مالیات وعوارض </td>
    <td align="left" ><?php echo number_format($MALIYAT);?></td>
    <td align="left" >&nbsp;</td>
	
  </tr>  <tr>
	
    <td align="right" valign="middle" >جمع صورت حساب دوره با احتساب  مالیات و عوارض</td>
    <td align="left" ><?php echo number_format($DORE_BA_MALIYAT);?></td>
    <td align="left" >&nbsp;</td>
	
  </tr>  <tr>
	
    <td align="right" valign="middle" >جمع بدهی پیشین</td>
    <td align="left" ><?php echo number_format($BEDEHI_PISHIN);?></td>
    <td align="left" >&nbsp;</td>
	
  </tr>  <tr>
	
    <td align="right" valign="middle" >جمع صورت حساب دوره با احتساب بدهی پیشین</td>
    <td align="left" ><?php echo number_format($DORE_BA_BEDEHI);?></td>
    <td align="left" >&nbsp;</td>
	
  </tr>  <tr>
	
    <td align="right" valign="middle" >جمع بستانکاری پیشین</td>
    <td align="left" >&nbsp;</td>
    <td align="left" ><?php echo number_format($BESTANKARI);?></td>
	
  </tr>  <tr>
	
    <td align="right" valign="middle" >جمع معافیت تلفنهای سرویس</td>
    <td align="left">&nbsp;</td>
    <td align="left" ><?php echo number_format($MOAFFIYAT);?></td>
	
  </tr>  <tr>
	
    <td align="right" valign="middle" >جمع کمکهای مردمی</td>
    <td align="left" ><?php echo number_format($KOMAKHAYE_MARDOMI);?></td>
    <td align="left" >&nbsp;</td>
	
  </tr>  <tr>
	
    <td align="right" valign="middle" >جمع درآمد عمومی دولت</td>
    <td align="left" ></td>
    <td align="left" >&nbsp;</td>
	
  </tr>  <tr>
	
    <td align="right" valign="middle" >کسرهزار ریال</td>
    <td align="left" >&nbsp;</td>
    <td align="left" ><?php echo number_format($KASRE_HEZAR_RIAL);?></td>
	
  </tr>  <tr>
	
    <td align="right" valign="middle" >جمع بستانکاری باقیمانده</td>
    <td align="left" >&nbsp;</td>
    <td align="left" ><?php echo number_format($BESTANKARI_BAGHIMANDE);?></td>
	
  </tr>  <tr>
    <td align="right" valign="middle" >جمع کل قابل پرداخت مشترک</td>
    <td align="left" ><?php echo number_format($GHABLE_PARDAKHT);?></td>
    <td align="left" >&nbsp;</td>
	
  </tr>  
  
  </tbody>
</table>

<?php

oci_free_statement($stid);
oci_close($conn);

}
?>


<script type="text/javascript">
function ExportToExcel(mytblId){
       var htmltable= document.getElementById('tbl1');
       var html = htmltable.outerHTML;
       window.open('data:application/vnd.ms-excel,' + encodeURIComponent(html));
	   
    }
	function showdate(){
    		
		//document.getElementById('demo').innerHTML=Date();	
		//window.open("www.yahoo.com");	
		}
</script>

</body>
</html>