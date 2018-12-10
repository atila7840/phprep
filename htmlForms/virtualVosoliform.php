<!-- lavosoli  --> 
<div id="lavosoli" class="modal">

  
  <form name="inputselector" class="modal-content animate" >
  
    <!--<div class="imgcontainer"> -->
    <!--<div class="imgcontainer">
      <span onclick="document.getElementById('lavosoli').style.display='none'" class="close" title="Close Modal">&times;</span>
      
      <!--<img src="img_avatar2.png" alt="Avatar" class="avatar">
    </div>-->

    <div class="container">
    <p align="center"><label class="farsifont">گزارش وصولی مجازی</label></p>
     
<p>      <!--<label class="farsifont">سال درآمدی</label> -->
<select name="year"  class="farsifont form_field required" id="year">
<option value="">سال</option>
  <option value="92">92</option>
  <option value="93">93</option>
  <option value="94">94</option>
  <option value="95">95</option>
  <option value="96">96</option>
</select>
</p>
      <!--<input type="text" placeholder="سال درآمدی را وارد نمایید" name="yearpayment" required> -->
<p>
      <!--<label class="farsifont">دوره درآمدی</label>
      <!--<input type="text" placeholder="دوره درآمدی را وارد نمایید" name="cyclepayment" required> -->
<select name="cycle"  class="farsifont form_field required" id="cycle">
<option value="">دوره</option>
  <option value="01">01</option>
  <option value="02">02</option>
  <option value="03">03</option>
  <option value="04">04</option>
  <option value="05">05</option>
  <option value="06">06</option>
  <option value="07">07</option>
  <option value="08">08</option>
  <option value="09">09</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
  </select>
 </p>
<p>
<select name="bank"  class="farsifont form_field required" id="bank"> 
 <option value="">بانک</option>
 <option value="all">کل بانکها</option>
 
 
 <?php

	$conn = oci_connect("billuser","billing","billdata",utf8);

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

 
<?php 

   }

   ?>
   
   
  </select></p>
<input type="hidden" name="bank_name" id="bank_name" class="form_field">
</p>
  <?php
oci_free_statement($stid);
oci_close($conn);

}
?>           
      <button type="submit" target="../wordpress/service/reportsPHP/virtualvosoli.php" class="farsifont btn" id="continue_form">ادامه</button>
      <!--<input type="checkbox" checked="checked"> Remember me-->
    </div>

    <!--<div class="container" style="background-color:#f1f1f1">
      <button type="button" class="cancelbtn" id="cancel_form">Cancel</button>
    </div> -->
  </form>
</div>