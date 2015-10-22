<? 	include("includes/configuration.php");
	include("includes/functions/encryption.php");
	
	$user_id= $_SESSION['sess_tt_uid'];//Fetching the userid
	$getuserDetails = getUserDetails($user_id);//Fetching the user details according to the userid
	$res=mysql_query("SELECT * FROM `toon_users` where user_id='$user_id'");
	$row=mysql_fetch_array($res);
	$user = $_REQUEST['artist'];
	$product_id=$_REQUEST['product'];
	$sql_product="SELECT * FROM `toon_products` WHERE `product_id`='$product_id'";
	$rs_product = mysql_query($sql_product);
	$row_product=mysql_fetch_assoc($rs_product);
	$sql_instr = "SELECT * FROM `toon_static` WHERE static_id = 6";
	$res_instr = mysql_query($sql_instr);
	$row_instr = mysql_fetch_array($res_instr);
	
	if(isset($_POST) && $_POST['txtproduct_title']!='')
	{
		$turnaroundtime=$_POST["txt_turnaroundtime"];
		$product_price=floor($_POST["txt_wholesaleprice"]*2)+0.95;
		$whoel_sale_price=$_POST["txt_wholesaleprice"];
		if($product_id)
		{
			$sql_update="UPDATE `toon_products` SET `product_turnaroundtime`='$turnaroundtime', product_price = '$product_price',`product_wholesale_price`='$whoel_sale_price',`product_additionalCopy_price`='$product_price' WHERE product_id ='$product_id'";
			$update_promo=mysql_query($sql_update);
		}
		header("Location:artist_add_products.php?product=".$product_id."&artist=".$user);
	}
	if($getuserDetails['utype_id']==2)
	{
		include (DIR_INCLUDES.'artist_header.php');
	}
	else
	{
		include (DIR_INCLUDES.'header.php');
	}
?> 
<script type="text/javascript">
function valid()
{
	clear();
	var valid=true;
	var price_max;
	if(isNaN(document.getElementById("txt_turnaroundtime").value)||(document.getElementById("txt_turnaroundtime").value)=="")
	{      
		document.getElementById("turnaroundtime_div").style.display="block";
		valid=false;
	}
	if(document.getElementById("txtproduct_title").value == "Head & Bust")
	{
		price_max = 17.50;
	}
	if(document.getElementById("txtproduct_title").value == "Head & Body")
	{
		price_max = 20.00;
	}
	if(document.getElementById("txtproduct_title").value == "Head, Body & Background")
	{
		price_max = 30.00;
	}
	if((document.getElementById("txt_wholesaleprice").value==0.00)||(isNaN(document.getElementById("txt_wholesaleprice").value))||(document.getElementById("txt_wholesaleprice").value > price_max) )
	{      
		document.getElementById("error_wholesaleprice").style.display="block";
		document.getElementById("error_wholesaleprice_max").innerHTML="(Maximum of $"+ price_max+")";
		document.getElementById("error_wholesaleprice_max").style.display="block";
		valid=false;
	}
	if(valid==true)
	{
		document.artist_add_product.submit();	
	}
	return valid;
}
function clear()
{
	document.getElementById("turnaroundtime_div").style.display="none";
	document.getElementById("error_wholesaleprice").style.display="none";
	document.getElementById("error_wholesaleprice_max").style.display="none";
}
</script>
<link href="styles/style.css" rel="stylesheet" type="text/css" />
<div id="content">
<div class="height80"></div>
    <div style="height:20px;"></div>
    <div>
        <div class="buy_now_curvepadding" style="margin-left:160px;background-repeat:no-repeat"><img src="images/white_curve_top_left.gif" /></div>
        <div class="buy_now_white_curve_top_middle_strip profile_sttings_whiteCurve_middle_strip"></div>
        <div><img src="images/white_curve_top_right.gif" /></div>				
        <div class="price_white_curve_middle_border profile_sttings_middle_content" style="clear:both;">
            <form action="artist_add_products.php" method="post" name="artist_add_product">
              <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>      
                  <td align="center"valign="top"><table cellpadding="0" cellspacing="0" width="100%" class="table_border">
                       <tr class="table_titlebar">
                        <td class="main_heading" height="30" colspan="4"><?=$row_product['product_title']?></td>
                      </tr>
                      <tr>
                        <td width="1%">&nbsp;</td>
                        <td width="98%" align="center" >
                        <table cellpadding="4" cellspacing="0" width="70%" class="table_border">
                            <tr>
                              <td colspan="2">&nbsp;</td>
                              <td><div id="turnaroundtime_div" style="display:none" class="no_details_msg">Enter Turnaround Time </div>
                                <div id="error_wholesaleprice" style="display:none" class="no_details_msg">Enter a valid Wholesale Price</div>
                                <div id="error_wholesaleprice_max" style="display:none" class="no_details_msg"></div></td>
                            </tr>
                            <tr>
                              <td width="10%">&nbsp;</td>
                              <td width="40%" align="left" class="text_blue">Turn around time&nbsp;:<span style="color:#F00;">*</span></td>
                              <td width="50%" align="left" class="valid_char">
                                <? $turn_day=$row_product['product_turnaroundtime'];$expl_array=explode(" ",$turn_day); ?>
                                  <select name="txt_turnaroundtime" id="txt_turnaroundtime" style="width:40px;" onchange="return valid();">
                                    <option value="0">Select</option> 
                                    <option value="1" <? if($expl_array[0]==1){ ?> selected="selected"<? } ?>>1</option>
                                    <option value="2" <? if($expl_array[0]==2){ ?> selected="selected"<? } ?>>2</option>
                                    <option value="3" <? if($expl_array[0]==3){ ?> selected="selected"<? } ?>>3</option>
                                    <option value="4" <? if($expl_array[0]==4){ ?> selected="selected"<? } ?>>4</option>
                                    <option value="5" <? if($expl_array[0]==5){ ?> selected="selected"<? } ?>>5</option>
                                    <option value="6" <? if($expl_array[0]==6){ ?> selected="selected"<? } ?>>6</option>
                                    <option value="7" <? if($expl_array[0]==7){ ?> selected="selected"<? } ?>>7</option>
                                  </select><span style="color:#666;"> (Days)</span>
                                 </td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td align="left" class="text_blue">Wholesale Price&nbsp;:<span style="color:#F00;">*</span></td>
                              <td align="left"><input type="text" name="txt_wholesaleprice" id="txt_wholesaleprice" value="<?=number_format($row_product['product_wholesale_price'],2);?>" onchange="return valid();"/>
                                 </td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td align="left" class="text_blue">Product Price&nbsp;:</td>
                              <td align="left"><input type="text" name="txtprice" id="txtprice" value="<?=number_format($row_product['product_price'],2);?>" disabled="disabled"/></td>
               				</tr>
                            <tr>
                                <td align="left" height="10"></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td align="left">&nbsp;</td>
                              <td align="left" ><input type="button" name="back" value="Back to my pricing" onclick="window.location='listout_artist_products.php?artist=<?=$user?>'"/></td>
                            </tr>
                          </table></td>
                        <td width="1%">&nbsp;</td>
                      </tr>          
                    </table></td>
                </tr>
              </table>
              <input type="hidden" name="txtproduct_title" id="txtproduct_title" value="<?=$row_product['product_title']?>"/>
              <input type="hidden" name="artist" value="<?=$user;?>" />
              <input type="hidden" name="product" value="<?=$product_id;?>" />
            </form>	
            <?php if(!empty($row_instr['static_content'])) { ?>		
                <div class="text_blue" style="padding:20px 10px 10px;"><b style="text-decoration:underline;">Instructions : </b><br/><br/><?=$row_instr['static_content']?></div>
            <?php } ?>		
            <div class="clear_both">&nbsp;</div>
        </div>
    </div>	
    <div>
        <div class="buy_now_curvepadding profile_sttings_btm_curve"><img src="images/contact_btm_left_curve.gif" /></div>
        <div class="white_btm_middle_strip profile_sttings_whiteCurve_middle_strip"></div>
        <div class="curve_right_position"><img src="images/contact_btm_right_curve.gif" /></div>
    </div>

</div>
<div style="height:100px;">&nbsp;</div>
<? 
if($getuserDetails['utype_id']==2)
{
	include (DIR_INCLUDES.'artist_footer.php');
}
else
{
	include (DIR_INCLUDES.'footer.php') ;
} ?>