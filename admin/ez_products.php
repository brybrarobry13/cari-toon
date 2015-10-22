
<?
include('includes/configuration.php');

	$ez_product_id=$_REQUEST['ez_pid'];
	$order_id=$_REQUEST['del'];
	if($order_id !='' && $order_id=='ok')
	{   $select_img = mysql_fetch_array(mysql_query("select * from `toon_ez_products` WHERE `ezproduct_id`='$ez_product_id'"));
		$img_name = $select_img['ezproduct_image'];
		$delete=mysql_query("DELETE FROM `toon_ez_products` WHERE `ezproduct_id`='$ez_product_id'");
		unlink(DIR_EZ_IMAGES.$img_name);
	}
$count_pdts = mysql_query("SELECT COUNT( * ) `cat_count` , TC. * , TEP. *
FROM `toon_ez_products` TEP, `toon_ez_categories` TC
WHERE TC.ecat_id = TEP.ecat_id
GROUP BY TC.`ecat_id`
ORDER BY TC.`ecat_priority` ASC");
$change_proid = $_POST['change_proid'];
if($change_proid)
{
	$pro_priority=$_POST['ezpro_'.$change_proid];
	$query= "UPDATE `toon_ez_products` SET `ezproduct_priority`='$pro_priority' WHERE `ezproduct_id`='$change_proid'";
	$result = mysql_query($query);
}

while($count_pdts_row = mysql_fetch_array($count_pdts))
{
$count_ez[$count_pdts_row['ecat_id']]=$count_pdts_row['cat_count'];
}
$ez_details=mysql_query("SELECT TC.*,TEP.* FROM `toon_ez_products`TEP,`toon_ez_categories`TC WHERE TC.ecat_id=TEP.ecat_id ORDER BY TC.`ecat_priority` ASC");
include ('includes/header.php');
?>
<link rel="stylesheet" type="text/css" href="../styles/highslide.css" />
<script type="text/javascript" src="../javascripts/highslide-with-html.js"></script>
<script type="text/javascript">
	hs.graphicsDir = '../images/graphics/';
	hs.align = 'center';
	hs.transitions = ['expand', 'crossfade'];
	hs.outlineType = 'rounded-white';
	hs.fadeInOut = true;
	hs.numberPosition = 'caption';
	hs.dimmingOpacity = 0.75;

	// Add the controlbar
	if (hs.addSlideshow) hs.addSlideshow({
		//slideshowGroup: 'group1',
		interval: 5000,
		repeat: false,
		useControls: true,
		fixedControls: 'fit',
		overlayOptions: {
			opacity: .75,
			position: 'bottom center',
			hideOnMouseOut: true
		}
	});
</script>
<style type="text/css">
.border_line{	
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #E2E2E2;
}
</style>
<script type="text/javascript">
function show_confirm()
{
	var r=confirm("Do you really want to delete this product?");
	return r;
    
}
function changepriority(proid)
{
	document.getElementById("change_proid").value=proid;
	document.ezproducts.submit();
}
</script>
<table cellpadding="0" cellspacing="10" border="0" width="97%">
 <tr>
  <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
  <td align="center" valign="top">
    <table cellpadding="0" cellspacing="0" width="100%" class="table_border">
     <tr class="table_titlebar"><td class="main_heading" height="30" width="100%" colspan="4">EZ Products</td></tr>
      <tr><td height="40px;" colspan="2" align="right" valign="bottom"><input type="button" value="Add EZ Product" onclick="window.location='add_ezproduct.php'" /></td></tr>
      <tr>
      	<td width="2%">&nbsp;</td>
      	<td align="center">
		<?
			$count=mysql_num_rows($ez_details);
			if ($count)
			{?>
            <form action="" method="post" name="ezproducts">
				<table cellpadding="0" cellspacing="0" width="100%" class="table_border">
      <tr class="heading_bg">
          <td class="sub_heading">EZ Product Name</td>
          <td class="sub_heading">EZ Category Name</td>
          <td class="sub_heading">EZ Product Sku</td>
          <!--<td class="sub_heading">Product Image</td>-->
          <td class="sub_heading">EZ Product Priority</td>
		  <td class="sub_heading">Wholesale Price($)</td>
          <td class="sub_heading">Price($)</td>
          <td class="sub_heading">Actions</td>
		  
      </tr>
      <input type="hidden" id="change_proid" name="change_proid" />
       <?
	   while($ez_products=mysql_fetch_assoc($ez_details))
	   {
	   ?>
        <tr>
          <td align="left" class="table_details" ><?=$ez_products['ezproduct_name']?></td>
          <td align="left" class="table_details" ><?=$ez_products['ecat_name']?></td>
          <td align="left" class="table_details" ><?=$ez_products['ezproduct_sku']?></td>
          <td align="left" class="table_details" ><select name="ezpro_<?=$ez_products['ezproduct_id']?>" onchange="return changepriority(<?=$ez_products['ezproduct_id']?>)">
				 <? for($i=1;$i<=$count_ez[$ez_products['ecat_id']];$i++)
					{
				  ?>
				  <option value="<?=$i?>" <? if($ez_products['ezproduct_priority']==$i) {?> selected="selected"<? } ?>><?=$i?></option>
                  <?
				    }
				  ?>
				</select></td>
          <!--<td align="left" class="table_details" ><a href="../z_uploads/EZ_images/<?=$ez_products['ezproduct_image']?>" onclick="return hs.expand(this)"><?=$ez_products['ezproduct_image']?></a></td>-->
		  <td align="left" class="table_details" ><?=number_format($ez_products['ezproduct_wholesaleprice'],2)?></td>
          <td align="left" class="table_details" ><?=number_format($ez_products['ezproduct_price'],2)?></td>
          <td align="left" class="table_details"><a href="edit_ezproduct.php?ezproduct_id=<?=$ez_products['ezproduct_id']?>" class="anger_tags"><img border="0" src="images/edit.png" title="Modify Product Details" alt="Modify the Profile" /></a><a onclick="return show_confirm()" href="ez_products.php?ez_pid=<?=$ez_products['ezproduct_id'];?>&del=ok"><img border="0" src="images/delete.png" title="Delete this Order" alt="Delete this Order"/></a></td>
        </tr>
       <? }?>
        
        <tr>
          <td height="20" colspan="4"></td>
        </tr>
      </table>
      		</form>
	    <? }else
			{?>
				<table align="center">
			<tr>
				<td class="no_details_msg">No EZ Products Added</td>
			</tr>
		</table>
			<? } ?>
	   </td>
      <td width="2%">&nbsp;</td>
    </tr>
      <tr><td height="10" colspan="4"></td></tr>
   </table>
  </td>
 </tr>
</table>
<?	include("includes/footer.php");?>