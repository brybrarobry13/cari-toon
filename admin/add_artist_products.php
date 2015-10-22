<?
	include('includes/configuration.php');
	$user = $_REQUEST['artist'];
	$product_id=$_REQUEST['product'];
	$sql_product="SELECT * FROM `toon_products` WHERE `product_id`='$product_id'";
	$rs_product = mysql_query($sql_product);
	$row_product=mysql_fetch_assoc($rs_product);
	if(isset($_POST['submit']))
	{
		$product_title=$_POST["txtproduct_title"];
		$product_description=$_POST["txtproduct_discription"];
		$turnaroundtime=$_POST["txt_turnaroundtime"];
		$product_price=$_POST["txtprice"];
		$whoel_sale_price=$_POST["txt_wholesaleprice"];
		$additionalCopy_price=$_POST["txt_additionalCopy_price"];
		if($product_id)
		{
			$sql_update="UPDATE `toon_products` SET `product_title`='$product_title',`product_description`='$product_description',`product_turnaroundtime`='$turnaroundtime',`product_price`='$product_price',`product_wholesale_price`='$whoel_sale_price',`product_additionalCopy_price`='$additionalCopy_price' WHERE product_id ='$product_id'";
			$update_promo=mysql_query($sql_update);
		}
		else
		{
			$sql_insert=mysql_query("insert into`toon_products`(`user_id`,`product_title`,`product_description`,`product_turnaroundtime`,`product_price`,`product_wholesale_price`,`product_additionalCopy_price`) values('$user','$product_title','$product_description','$turnaroundtime','$product_price','$whoel_sale_price','$additionalCopy_price')");	
		}
		header("Location:list_artist_products.php?artist=".$user);
	}
		
	include ('includes/header.php');
?>
<script type="text/javascript">
function valid()
{
	clear();
	var valid=true;
	if(document.getElementById("txtproduct_title").value=="")
    	{      
		 		document.getElementById("title_div").style.display="block";
				valid=false;
     	}
		if(document.getElementById("txtproduct_discription").value=="")
    	{      
		 		document.getElementById("discription_div").style.display="block";
				valid=false;
     	}
		if(isNaN(document.getElementById("txt_turnaroundtime").value)||(document.getElementById("txt_turnaroundtime").value)=="")
    	{      
		 		document.getElementById("turnaroundtime_div").style.display="block";
				valid=false;
     	}
		if((document.getElementById("txtprice").value==0.00)||(isNaN(document.getElementById("txtprice").value)))
    	{      
		 		document.getElementById("price_div").style.display="block";
				valid=false;
     	}
		if((document.getElementById("txt_wholesaleprice").value==0.00)||(isNaN(document.getElementById("txt_wholesaleprice").value)))
    	{      
		 		document.getElementById("error_wholesaleprice").style.display="block";
				valid=false;
     	}
		if((document.getElementById("txt_additionalCopy_price").value==0.00)||(isNaN(document.getElementById("txt_additionalCopy_price").value)))
    	{      
		 		document.getElementById("error_additionalCopy_price").style.display="block";
				valid=false;
     	}
		//if(isNaN(my_string)){
		return valid;
}
function clear()
{
		document.getElementById("title_div").style.display="none";
		document.getElementById("discription_div").style.display="none";
		document.getElementById("turnaroundtime_div").style.display="none";
		document.getElementById("error_wholesaleprice").style.display="none";
		document.getElementById("price_div").style.display="none";
		document.getElementById("error_additionalCopy_price").style.display="none";
		
}
</script>
<form action="add_artist_products.php" method="post" name="add_artist_product" enctype="multipart/form-data">
  <table cellpadding="0" cellspacing="10" border="0" width="97%">
    <tr>
      <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
      <td align="center"valign="top"><table cellpadding="0" cellspacing="0" width="100%" class="table_border">
          <tr class="table_titlebar">
            <td class="main_heading" height="30" colspan="4">Add Products</td>
          </tr>
          <tr>
            <td height="40px;"></td>
          </tr>
          <tr>
            <td width="1%">&nbsp;</td>
            <td width="98%" align="center" ><table cellpadding="4" cellspacing="0" width="70%" class="table_border">
                <tr>
                  <td colspan="2">&nbsp;</td>
                  <td ><div id="title_div" style="display:none" class="no_details_msg">Enter the product Title</div>
                    <div id="discription_div" style="display:none" class="no_details_msg">Enter the Product Description</div>
					<div id="turnaroundtime_div" style="display:none" class="no_details_msg">Enter Turnaround Time </div>
                    <div id="error_wholesaleprice" style="display:none" class="no_details_msg">Enter Wholesale Price</div>
                    <div id="price_div" style="display:none" class="no_details_msg">Enter the Product Price</div>
                    <div id="error_additionalCopy_price" style="display:none" class="no_details_msg">Enter Additional Copy Price</div>
					</td>
                </tr>
                <tr>
                  <td width="11%">&nbsp;</td>
                  <td width="36%" align="left" class="table_details">Product Title&nbsp;:*</td>
                  <td width="53%" align="left"><input type="text" name="txtproduct_title" id="txtproduct_title" value="<?=$row_product['product_title']?>" onchange="return IsNumeric(<? echo $row_product['product_title']?>);" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" class="table_details">Description&nbsp;:*</td>
                  <td align="left"><textarea name="txtproduct_discription" id="txtproduct_discription" /><?=$row_product['product_description']?></textarea></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" class="table_details">Turn around time&nbsp;:*</td>
                  <td align="left" class="valid_char"><input type="text" name="txt_turnaroundtime" id="txt_turnaroundtime" value="<? $turn_day=$row_product['product_turnaroundtime'];$expl_array=explode(" ",$turn_day);echo $expl_array[0];?>"/>(Days)
                     </td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" class="table_details">Wholesale Price&nbsp;:*</td>
                  <td align="left"><input type="text" name="txt_wholesaleprice" id="txt_wholesaleprice" value="<?=number_format($row_product['product_wholesale_price'],2);?>"/>
                     </td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" class="table_details">Product Price&nbsp;:*</td>
                  <td align="left"><input type="text" name="txtprice" id="txtprice" value="<?=number_format($row_product['product_price'],2);?>"/>
                     </td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" class="table_details">Additional Person Price&nbsp;:*</td>
                  <td align="left"><input type="text" name="txt_additionalCopy_price" id="txt_additionalCopy_price" value="<?=number_format($row_product['product_price'],2);?>"/>
                     </td>
                </tr>

				<!--<tr>
                  <td>&nbsp;</td>
                  <td align="left" class="table_details">Product Image&nbsp;:*</td>
                  <td align="left">
					<input type="file" name="file" id="file"/>
<br />
 </td>
</tr>-->
				
                <tr>
                  <td>&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left" ><input type="submit" name="submit" value="submit" onClick="return valid()"/></td>
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
  </table><input type="hidden" name="artist" value="<?=$user;?>" />
  <input type="hidden" name="product" value="<?=$product_id;?>" />
</form>
<?	include("includes/footer.php");?>
