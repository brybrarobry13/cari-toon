<?
	include('includes/configuration.php');
	include("../includes/general.php");	
	
	$bulk_id=$_REQUEST['bulk_id'];
	
	if($bulk_id!="")
	{
		$sql_promo_bulk=mysql_query("SELECT * FROM `toon_promo_bulk` WHERE `bulk_id`='$bulk_id'");
		$row_promo_bulk=mysql_fetch_assoc($sql_promo_bulk);
		$old_bulk_num_coupons = $row_promo_bulk['bulk_count'];
		
		$sql_promo = mysql_query("SELECT * FROM `toon_promo` WHERE `bulk_id`='$bulk_id' LIMIT 1");
		$row_promo=mysql_fetch_assoc($sql_promo);
		
	}
	
	if(isset($_POST['submit']))
	{
		$bulk_pdt_type=$_POST['bulk_pdt_type'];
		$bulk_title=$_POST["txtbulk_title"];
		$bulk_num_coupons = $_POST["txtnum_coupons"];
		$bulk_discount=$_POST["txtbulk_discount"];		
		$bulk_start_date=$_POST["start_date"];
		$bulk_end_date=$_POST["end_date"];
		
		if($bulk_id)
		{	
			$sql_update_promo_bulk=mysql_query("UPDATE `toon_promo_bulk` SET `bulk_title`='$bulk_title',`bulk_count`='$bulk_num_coupons' WHERE `bulk_id`='$bulk_id'");	
			$sql_update_promo=mysql_query("UPDATE `toon_promo` SET `promo_discount`='$bulk_discount',`promo_product_type`='$bulk_pdt_type',`promo_start_date`='$bulk_start_date' ,`promo_expiry`='$bulk_end_date' WHERE `bulk_id`='$bulk_id'");	
			//$update_bulk_coupon=mysql_query($sql_update);
			
			if($old_bulk_num_coupons != $bulk_num_coupons)
			{
				$del_query_codes = "delete from toon_promo where `bulk_id`='$bulk_id'";
				mysql_query($del_query_codes);
				if($bulk_num_coupons > 0)
				{
					for($val=1;$val<=$bulk_num_coupons;$val++)
					{
						$coupon_code = createRandomString();
						$sql_insert_promo_code=mysql_query("insert into `toon_promo` (`bulk_id`, `promo_code`, `promo_discount`,`promo_product_type`,`promo_start_date`,`promo_expiry`,`promo_isused`)values('$bulk_id', '$coupon_code','$bulk_discount','$bulk_pdt_type','$bulk_start_date', '$bulk_end_date', '0')");
					}
				}
			}		
		}
		else
		{
			$sql_insert_promo_bulk=mysql_query("insert into `toon_promo_bulk` (`bulk_title`, `bulk_count`)values('$bulk_title','$bulk_num_coupons')");
			$bulk_id=mysql_insert_id();
			
			if($bulk_num_coupons > 0)
			{
				for($val=1;$val<=$bulk_num_coupons;$val++)
				{
					$coupon_code = createRandomString();
					$sql_insert_promo=mysql_query("insert into `toon_promo` (`bulk_id`,`promo_code`, `promo_discount`,`promo_product_type`,`promo_start_date`,`promo_expiry`,`promo_isused`)values('$bulk_id', '$coupon_code','$bulk_discount','$bulk_pdt_type','$bulk_start_date', '$bulk_end_date', '0')");
				}
			}
		}
		header("Location:bulk_coupons.php");
	}
	
	include ('includes/header.php');
?>
<script type="text/javascript">
function valid()
{
	clear();
	var valid=true;
		if(document.getElementById("txtbulk_title").value=="")
    	{      
		 		document.getElementById("code_div").style.display="block";
				valid=false;
     	}
		if((document.getElementById("txtbulk_discount").value=="")||(isNaN(document.getElementById("txtbulk_discount").value)))
    	{      
		 		document.getElementById("discount_div").style.display="block";
				valid=false;
     	 		
		}
	 	if(document.getElementById("end_date").value=="")
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
<form action="bulkcoupon_edit.php" method="post" name="bulkcoupon_edit">
  <table cellpadding="0" cellspacing="10" border="0" width="97%">
    <tr>
      <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
      <td align="center"><table cellpadding="0" cellspacing="0" width="100%" class="table_border">
          <tr class="table_titlebar">
            <td class="main_heading" height="30" colspan="4">Manage Promotional Codes</td>
          </tr>
          <tr>
            <td height="40px;"></td>
          </tr>
          <tr>
            <td width="1%">&nbsp;</td>
            <td width="98%" align="center" valign="top"><table cellpadding="4" cellspacing="0" width="70%" class="table_border">
                <tr>
                  <td colspan="2">&nbsp;</td>
                  <td ><div id="code_div" style="display:none" class="no_details_msg">Enter the Title</div>
                    <div id="discount_div" style="display:none" class="no_details_msg">Enter the Discount</div>
                    <div id="expiry_div" style="display:none" class="no_details_msg">Enter the Expiry Date</div></td>
                </tr>
                <tr>
                  <td width="11%">&nbsp;</td>
                  <td width="36%" align="left" class="table_details">Title&nbsp;:*</td>
                  <td width="53%" align="left"><input type="text" name="txtbulk_title" id="txtbulk_title" value="<?=$row_promo_bulk['bulk_title'];?>" /></td>
                </tr>
                <tr>
                  <td width="11%">&nbsp;</td>
                  <td width="36%" align="left" class="table_details">Number of Coupons&nbsp;:*</td>
                  <td width="53%" align="left"><input type="text" name="txtnum_coupons" id="txtnum_coupons" value="<?=$row_promo_bulk['bulk_count'];?>" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" class="table_details">Discount(%)&nbsp;:*</td>
                  <td align="left"><input type="text" name="txtbulk_discount" id="txtbulk_discount" value="<?=$row_promo['promo_discount'];?>" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" class="table_details">&nbsp;</td>
                  <td align="left"><input type="radio" name="bulk_pdt_type" checked="checked" value="ez product" />Ez Product
				  <input type="radio" name="bulk_pdt_type" <? if($row_promo['promo_product_type']=="Toon product"){ echo 'checked="checked"';}?>  value="Toon product" />Toon Product
				  </td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" class="table_details">Start Date&nbsp;:*</td>
                  <td align="left" ><input type="text" name="start_date" value="<?=$row_promo['promo_start_date'];?>" id="start_date" onClick="showChooser(this, 'start_date', 'cal_from', 1900, 2028, 'Y-m-d', false);"/>
                    &nbsp;<img align="absmiddle" src="images/calendar.gif" width="20" onclick="showChooser(this, 'start_date', 'cal_from', 1900, 2028, 'Y-m-d', false);" />
                    <div class="dateChooser" id="cal_from" style="DISPLAY: none; VISIBILITY: hidden; WIDTH: 145px"></div></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" class="table_details">End Date&nbsp;:*</td>
                  <td align="left" ><input type="text" name="end_date" value="<?=$row_promo['promo_expiry'];?>" id="end_date" onClick="showChooser(this, 'end_date', 'cal_from', 1900, 2028, 'Y-m-d', false);"/>
                    &nbsp;<img align="absmiddle" src="images/calendar.gif" width="20" onclick="showChooser(this, 'end_date', 'cal_from', 1900, 2028, 'Y-m-d', false);" />
                    <div class="dateChooser" id="cal_from" style="DISPLAY: none; VISIBILITY: hidden; WIDTH: 145px"></div></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left">&nbsp;
                    <input type="hidden" name="bulk_id" value="<?=$row_promo_bulk['bulk_id'];?>" ></td>
                  <td align="left" ><input type="submit" name="submit" value=<? if($bulk_id){?>"Update" <? }else{?>"Submit"<? }?>onclick="return valid()"/></td>
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
