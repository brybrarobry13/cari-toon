<?
	include('includes/configuration.php');
	$spc_id=$_REQUEST['spc_id'];
	if(isset($_POST['submit']))
	{
		$spl_code=$_POST['spl_code'];
		$spl_product_price=$_POST["spl_product_price"];
		$spl_pdt_type=$_POST["spl_pdt_type"];
		$spl_wholesale_price = $_POST["spl_wholesale_price"];
		if($spc_id)
		{
		$sql_update="UPDATE `toon_special_coupons` SET `spc_code` = '$spl_code',`spc_product` = '$spl_pdt_type', `spc_product_price` = '$spl_product_price',`spc_wholesale_price` = '$spl_wholesale_price' WHERE `spc_id` ='$spc_id'";	
		$update_spc=mysql_query($sql_update);
		}
		else
		{
		$sql_insert=mysql_query("INSERT INTO `toon_special_coupons` (`spc_code`, `spc_product` ,`spc_product_price` ,`spc_wholesale_price` ,`spc_isused`)VALUES ('$spl_code', '$spl_pdt_type', '$spl_product_price', '$spl_wholesale_price' , '0')");
		}
		header("Location:spl_coupons.php");
	}
	$sql_spc="SELECT * FROM `toon_special_coupons` WHERE `spc_id`='$spc_id'";
	$rs_spc = mysql_query($sql_spc);
	$row_spc=mysql_fetch_assoc($rs_spc);
	
	include ('includes/header.php');
?>
<script type="text/javascript">
function valid()
{
	clear();
	var valid=true;
		if(document.getElementById("spl_code").value=="")
    	{      
		 		document.getElementById("code_div").style.display="block";
				valid=false;
     	}
		if((document.getElementById("spl_product_price").value=="")||(isNaN(document.getElementById("spl_product_price").value)))
    	{      
		 		document.getElementById("price_div").style.display="block";
				valid=false;
     	 		
		}
		if((document.getElementById("spl_wholesale_price").value=="")||(isNaN(document.getElementById("spl_wholesale_price").value)))
    	{      
		 		document.getElementById("wholesaleprice_div").style.display="block";
				valid=false;
     	 		
		}
		
		return valid;
}
function clear()
{
		document.getElementById("code_div").style.display="none";
		document.getElementById("price_div").style.display="none";
		document.getElementById("wholesaleprice_div").style.display="none";
			
}

</script>
<script language="javascript" type="text/javascript" src="javascripts/datechooser.js"></script>
<script language="javascript" type="text/javascript" src="javascripts/date-functions.js"></script>
<link rel="stylesheet" href="styles/datechooser.css" type="text/css" />
<form action="" method="post" name="spl_coupons_edit">
  <table cellpadding="0" cellspacing="10" border="0" width="97%">
    <tr>
      <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
      <td align="center"><table cellpadding="0" cellspacing="0" width="100%" class="table_border">
          <tr class="table_titlebar">
            <td class="main_heading" height="30" colspan="4">Manage Special Coupons</td>
          </tr>
          <tr>
            <td height="40px;"></td>
          </tr>
          <tr>
            <td width="1%">&nbsp;</td>
            <td width="98%" align="center" valign="top"><table cellpadding="4" cellspacing="0" width="70%" class="table_border">
                <tr>
                  <td colspan="2">&nbsp;</td>
                  <td ><div id="code_div" style="display:none" class="no_details_msg">Enter the Coupon Code</div>
                    <div id="price_div" style="display:none" class="no_details_msg">Enter the Product Price</div>
                    <div id="wholesaleprice_div" style="display:none" class="no_details_msg">Enter the Product Wholesale Price</div>
                    </td>
                </tr>
                <tr>
                  <td width="11%">&nbsp;</td>
                  <td width="36%" align="left" class="table_details">Coupon Code&nbsp;:*</td>
                  <td width="53%" align="left"><input type="text" name="spl_code" id="spl_code" value="<?=$row_spc['spc_code'];?>" /></td>
                </tr>

                <tr>
                  <td>&nbsp;</td>
                  <td align="left" class="table_details">Product Price&nbsp;:*</td>
                  <td align="left"><input type="text" name="spl_product_price" id="spl_product_price" value="<?=$row_spc['spc_product_price'];?>" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" class="table_details">Product Wholesale Price&nbsp;*</td>
                  <td align="left">
                  <input type="text" name="spl_wholesale_price" id="spl_wholesale_price" value="<?=$row_spc['spc_wholesale_price'];?>" />
				  <input type="hidden" name="spl_pdt_type" value="Toon product" />
				  </td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left" ><input type="submit" name="submit" value=<? if($spc_id){?>"Update" <? }else{?>"Submit"<? }?>onclick="return valid()"/></td>
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
