<?php include('../../wp-load.php'); ?>
<!-- lavosoli  --> 
<div id="lavosoli" class="modal">

  
  <form name="inputselector" class="modal-content animate" >
  
    <!--<div class="imgcontainer"> -->
    <!--<div class="imgcontainer">
      <span onclick="document.getElementById('lavosoli').style.display='none'" class="close" title="Close Modal">&times;</span>
      
      <!--<img src="img_avatar2.png" alt="Avatar" class="avatar">
    </div>-->

    <div class="container">
		<p align="center"><label class="farsifont">آمار وصولی و ثبت نام</label></p>
		<div class=date_selctor>
			<img class="date_select_icon" id="start_date_btn" src="<?php echo home_url('images/cal.png'); ?>" />
			<input  placeholder="تاریخ شروع" name ="startdate" readonly id="start_date_input" type="text" class="farsifont form_field date_input required_child required" />
		</div>
      <!--<input type="text" placeholder="سال درآمدی را وارد نمایید" name="yearpayment" required> -->
		<div class=date_selctor>
			<img class="date_select_icon" id="end_date_btn" src="<?php echo home_url('images/cal.png'); ?>"/>
			<input  placeholder="تاریخ پایان" name ="enddate" readonly id="end_date_input" type="text" class="farsifont form_field date_input required_child required"  />
		</div> 
		
		
 
 <p>
 <script>
Calendar.setup({
	inputField:'start_date_input',
	button:'start_date_btn',
	ifFormat:'%Y/%m/%d',
	dateType	   : "jalali",
	weekNumbers    : false,
	langNumbers	: true
	
});
Calendar.setup({
	inputField:'end_date_input',
	button:'end_date_btn',
	ifFormat:'%Y/%m/%d',
	dateType	   : "jalali",
	weekNumbers    : false,
	langNumbers	: true
});
function checkprioritydates(stdate,endate){
	if (stdate.value>endate.value){
		alert ("تقدم تاریخ رعایت نشده است");
		inputselector.startdate.value="";
		
	}
return 0;	
};
</script>
 <select name="bank"  class="farsifont form_field required" id="bank"> 
 <option value="">بانک</option>
 <option value="all">کل بانکها</option>
 
 
 <?php

	$conn = oci_connect("billuser","billing","billdata","utf8");

if (!$conn){
$e = oci_error();

  trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);

}
else{
$query="select * from bank";


$stid=oci_parse($conn,$query);
oci_execute($stid);

//echo $query;
   while(($row = oci_fetch_row($stid))!= false){
	   ?>
       <option value="<?php echo $row[0];?>"><?php echo $row[4];?></option>
      <!--<label class="farsifont">دوره درآمدی</label>
      <!--<input type="text" placeholder="دوره درآمدی را وارد نمایید" name="cyclepayment" required> -->

 
<?php 

   }
   ?>
  </select>
  <input type="hidden" name="bank_name" id="bank_name" class="form_field">
   </p>
  <?php
oci_free_statement($stid);
oci_close($conn);

}
?>
          
  
      <button type="submit" target="../wordpress/service/reportsPHP/tafkikvosooli.php" class="farsifont btn" id="continue_form" onclick="Javascript:checkprioritydates(inputselector.startdate,inputselector.enddate)">ادامه</button>
      <!--<input type="checkbox" checked="checked"> Remember me-->
    </div>

    <!--<div class="container" style="background-color:#f1f1f1">
      <button type="button" class="cancelbtn" id="cancel_form">Cancel</button>
    </div> -->
  </form>
  
  <div><p id=message_box></p></div>
</div>
