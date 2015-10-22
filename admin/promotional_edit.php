<?
	include('includes/configuration.php');
	$promo_id=$_REQUEST['promo_id'];
	if(isset($_POST['submit']))
	{
		$protype=$_POST['protype'];
		$pro_pdt_type=$_POST['pro_pdt_type'];
		$promocode=$_POST["txtprom_code"];
		$promo_discount=$_POST["txtprom_discount"];
		$promo_expiry=$_POST["pass_date"];
		if($_POST['web_display'])
		{
			$web_display=$_POST['web_display'];
		}
		else
		{
			$web_display=0;
		}
		$txtprom_amount=$_POST["txtprom_amount"];
		if($promo_id)
		{
		$sql_update="UPDATE `toon_promo` SET `promo_code`='$promocode',`promo_discount`='$promo_discount',`promo_amount`='$txtprom_amount',`promo_type`='$protype',`promo_display`='$web_display',`promo_product_type`='$pro_pdt_type',`promo_expiry`='$promo_expiry' WHERE `promo_id`='$promo_id'";	
		$update_promo=mysql_query($sql_update);
		}
		else
		{
		$sql_insert=mysql_query("insert into 	`toon_promo`(`promo_code`,`promo_discount`,`promo_amount`,`promo_type`,`promo_display`,`promo_product_type`,`promo_expiry`)values('$promocode','$promo_discount','$txtprom_amount','$protype','$web_display','$pro_pdt_type','$promo_expiry')");
		}
		header("Location:promotional_codes.php");
	}
	$sql_promo="SELECT * FROM `toon_promo` WHERE `promo_id`='$promo_id'";
	$rs_promo = mysql_query($sql_promo);
	$row_promo=mysql_fetch_assoc($rs_promo);
	
	include ('includes/header.php');
?>
<script type="text/javascript">
function valid()
{
	clear();
	var valid=true;
		if(document.getElementById("txtprom_code").value=="")
    	{      
		 		document.getElementById("code_div").style.display="block";
				valid=false;
     	}
		if((document.getElementById("txtprom_discount").value=="")||(isNaN(document.getElementById("txtprom_discount").value)))
    	{      
		 		document.getElementById("discount_div").style.display="block";
				valid=false;
     	 		
		}
	 	if(document.getElementById("pass_date").value=="")
   		{
     			document.getElementById("expiry_div").style.display="block";
	 			valid=false;
    	}
		
		return valid;
}
function clear()
{
		document.getElementById("code_div").style.display="none";
		document.getElementById("discount_div").style.display="none";
		document.getElementById("expiry_div").style.display="none";
			
}

</script>
<script language="javascript" type="text/javascript" src="javascripts/datechooser.js"></script>
<script language="javascript" type="text/javascript" src="javascripts/date-functions.js"></script>
<link rel="stylesheet" href="styles/datechooser.css" type="text/css" />
<form action="promotional_edit.php" method="post" name="promotional_edit">
  <table cellpadding="0" cellspacing="10" border="0" width="97%">
    <tr>
      <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
      <td align="center"><table cellpadding="0" cellspacing="0" width="100%" class="table_border">
          <tr class="table_titlebar">
            <td class="main_heading" height="30" colspan="4">Manage Coupon Codes</td>
          </tr>
          <tr>
            <td height="40px;"></td>
          </tr>
          <tr>
            <td width="1%">&nbsp;</td>
            <td width="98%" align="center" valign="top"><table cellpadding="4" cellspacing="0" width="70%" class="table_border">
                <tr>
                  <td colspan="2">&nbsp;</td>
                  <td ><div id="code_div" style="display:none" class="no_details_msg">Enter the code</div>
                    <div id="discount_div" style="display:none" class="no_details_msg">Enter the Discount</div>
                    <div id="expiry_div" style="display:none" class="no_details_msg">Enter the Expiry Date</div></td>
                </tr>
                <tr>
                  <td width="11%">&nbsp;</td>
                  <td width="36%" align="left" class="table_details">Code&nbsp;:*</td>
                  <td width="53%" align="left"><input type="text" name="txtprom_code" id="txtprom_code" value="<?=$row_promo['promo_code'];?>" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" class="table_details">Discount(%)&nbsp;:*</td>
                  <td align="left"><input type="text" name="txtprom_discount" id="txtprom_discount" value="<?=$row_promo['promo_discount'];?>" /></td>
                </tr>
				<tr>
                  <td>&nbsp;</td>
                  <td align="left" class="table_details">&nbsp;</td>
                  <td align="left"><input type="radio" name="protype" checked="checked" value="0" />Percentage
				  <input type="radio" name="protype" <? if($row_promo['promo_type']==1){ echo 'checked="checked"';}?>  value="1" />Amount
				  </td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" class="table_details">&nbsp;</td>
                  <td align="left"><input type="radio" name="pro_pdt_type" checked="checked" value="ez product" />Ez Product
				  <input type="radio" name="pro_pdt_type" <? if($row_promo['promo_product_type']=="Toon product"){ echo 'checked="checked"';}?>  value="Toon product" />Toon Product
				  </td>
                </tr>
				<tr>
                  <td>&nbsp;</td>
                  <td align="left" class="table_details">Minimum Amount Of Purchase</td>
                  <td align="left"><input type="text" name="txtprom_amount" value="<?=$row_promo['promo_amount'];?>" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" class="table_details">Expiry&nbsp;:*</td>
                  <td align="left" ><input type="text" name="pass_date" value="<?=$row_promo['promo_expiry'];?>"id="pass_date" onClick="showChooser(this, 'pass_date', 'cal_from', 1900, 2028, 'Y-m-d', false);"/>
                    &nbsp;<img align="absmiddle" src="images/calendar.gif" width="20" onclick="showChooser(this, 'pass_date', 'cal_from', 1900, 2028, 'Y-m-d', false);" />
                    <div class="dateChooser" id="cal_from" style="DISPLAY: none; VISIBILITY: hidden; WIDTH: 145px"></div></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" class="table_details">&nbsp;</td>
                  <td align="left" ><input type="checkbox" value="1" name="web_display" <? if($row_promo['promo_display']==1){ echo 'checked="checked"';}?> />&nbsp;Show In Website</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left">&nbsp;
                    <input type="hidden" name="promo_id" value="<?=$row_promo['promo_id'];?>" ></td>
                  <td align="left" ><input type="submit" name="submit" value=<? if($promo_id){?>"Update" <? }else{?>"Submit"<? }?>onclick="return valid()"/></td>
                </tr>
                <td align="left"></td>
                </tr>
              </table></td>
            <td width="1%">&nbsp;</td>
          </tr>
          <tr>
            <td height="49" colspan="4"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?	include("includes/footer.php");?>
