<?
	include('includes/configuration.php');
	if(isset($_POST['submit']))
	{
			$product_name=$_POST["product_name"];
			$product_sku=$_POST["product_sku"];
			$product_price=$_POST["product_price"];
			$product_wholsal_price=$_POST["product_wholsal_price"];
			$product_cat=$_POST['product_cat'];
			$product_display = $_POST['product_display'];
			if($product_display == '')
			$product_display = 0;
			$sql_insert="INSERT INTO `toon_ez_products`(`ezproduct_name` ,`ezproduct_sku` ,`ezproduct_price`,`ezproduct_wholesaleprice`,`ecat_id`,`ezproduct_display`)VALUES 
			('$product_name','$product_sku','$product_price','$product_wholsal_price','$product_cat','$product_display')";	
			mysql_query($sql_insert);
			$ez_product_id=mysql_insert_id();
			if (($_FILES["product_img"]["type"] == "image/gif")
			|| ($_FILES["product_img"]["type"] == "image/jpeg")
			|| ($_FILES["product_img"]["type"] == "image/jpg")
			|| ($_FILES["product_img"]["type"] == "image/pjpeg"))
			{	
				$imagename 	= $_FILES["product_img"]["name"];
				$ext		= explode('.',$imagename);
				$destination = DIR_EZ_IMAGES.$ez_product_id.".".$ext[1];	
				$db_image=$ez_product_id.".".$ext[1];
				move_uploaded_file($_FILES["product_img"]["tmp_name"],$destination);
				mysql_query("update `toon_ez_products` set `ezproduct_image`='$db_image' where `ezproduct_id`='$ez_product_id'");
			}
			header("Location:ez_products.php");
		}			
	$rs_toon_ez_categories=mysql_query("SELECT * FROM `toon_ez_categories`");
	
	include ('includes/header.php');
?>
<script language="javascript" type="text/javascript">
function hide()
  {
  	document.getElementById("product_name_err").style.display="none";
	document.getElementById("product_sku_err").style.display="none";
	document.getElementById("product_price_err").style.display="none";
	document.getElementById("product_wholsal_price_err").style.display="none";
    document.getElementById("product_img_err").style.display="none";
	document.getElementById("product_cat_err").style.display="none";
  }
function verify()
  {
   hide();
   var ok=1;
    if(document.getElementById("product_name").value=='')
	{
		document.getElementById("product_name_err").style.display="block";
		ok=0;
	}
	if(document.getElementById("product_sku").value=='')
	{
		document.getElementById("product_sku_err").style.display="block";
		ok=0;
	}
	if((document.getElementById("product_price").value=='') || (isNaN(document.getElementById("product_price").value)==true))
	{
		document.getElementById("product_price_err").style.display="block";
		ok=0;
	}
	if((document.getElementById("product_wholsal_price").value=='') || (isNaN(document.getElementById("product_wholsal_price").value)==true))
	{
		document.getElementById("product_wholsal_price_err").style.display="block";
		ok=0;
	}
	if(document.getElementById("product_img").value=='')
	{
		document.getElementById("product_img_err").style.display="block";
		ok=0;
	}
	if(document.getElementById("product_cat").value=='')
	{
		document.getElementById("product_cat_err").style.display="block";
		ok=0;
	}
  if(ok==1)
   return true;
  else
   return false;  
  }
</script>
<form action="add_ezproduct.php" method="post" enctype="multipart/form-data"  onsubmit="return verify();" >
  <table cellpadding="0" cellspacing="10" border="0" width="97%">
    <tr>
      <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
      <td align="center"><table cellpadding="0" cellspacing="0" width="100%" class="table_border">
          <tr class="table_titlebar">
            <td class="main_heading" height="30" colspan="4">Add EZ Product</td>
          </tr>
          <tr>
		  <td height="40px;"></td>
		 </tr>
		  <tr>
            <td width="1%">&nbsp;</td>
            <td width="98%" align="center" valign="top"><table cellpadding="5" cellspacing="0" width="60%" class="table_border">
                <tr>
				<td colspan="2">&nbsp;</td>
				<td>	
			<div id="product_name_err" style="display:none;color:#FF0000" >Enter EZ Product Name</div>
			<div id="product_sku_err" style="display:none;color:#FF0000" >Enter EZ Product Sku</div>
			<div id="product_wholsal_price_err" style="display:none;color:#FF0000" >Enter the Wholesale Price</div>
			<div id="product_price_err" style="display:none;color:#FF0000" >Enter the Price</div>
			<div id="product_img_err" style="display:none;color:#FF0000" >Enter the Product Image</div>
            <div id="product_cat_err" style="display:none;color:#FF0000" >Enter the Product Category</div>
			
				</tr>
				<tr>
				<td width="14%">&nbsp;</td>
                  <td width="33%" align="left" class="table_details">EZ Product Name&nbsp;:*</td>
                  <td width="53%" align="left"><input type="text" name="product_name" id="product_name"/></td>
                </tr>
                <tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">EZ Product Sku&nbsp;:*</td>
                  <td align="left"><input type="text" name="product_sku" id="product_sku" />
				  
				  </td>
                </tr>
                <tr><td>&nbsp;</td>
                  <td align="left" class="table_details">Wholesale Price($)&nbsp;:*</td>
                  <td align="left" ><input type="text" name="product_wholsal_price" id="product_wholsal_price" />
				  </td>
                </tr>
                <tr><td>&nbsp;</td>
                  <td align="left" class="table_details">Price($)&nbsp;:*</td>
                  <td align="left" ><input type="text" name="product_price" id="product_price" />
				  </td>
                </tr>

				<tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details" valign="top">Product Image&nbsp;:*</td>
                  <td align="left"><input type="file" name="product_img" id="product_img" />
                  </td>
                </tr>
                <tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details" valign="top"></td>
                  <td align="left"><select name="product_cat" id="product_cat">
                  <option value="">Select Category</option>
                  <?
				  while($row_toon_ez_categories=mysql_fetch_array($rs_toon_ez_categories))
				  {
				  
				  ?>
                  <option value="<?=$row_toon_ez_categories['ecat_id'];?>"><?=$row_toon_ez_categories['ecat_name'];?></option>
                  <?
				  }
				  ?>
                  </select>
                  </td>
                </tr>
                <tr>
                <td>&nbsp;</td>
                  <td align="left" class="table_details">&nbsp;</td>
                  <td align="left"><input type="checkbox" name="product_display" checked="checked" value="1" /> Show in Website</td>
                </tr>
                <tr><td>&nbsp;</td>
                  <td align="left" class="table_details"></td>
                  <td align="left" ><input type="submit" name="submit" value="Save"/>
				  </td>
                </tr>
            </table></td>
            <td width="1%">&nbsp;</td>
          </tr>
          <tr>
            <td height="40" colspan="4"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>

<?	include("includes/footer.php");?>
