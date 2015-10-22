<?
include('includes/configuration.php');

	$mcat_id=$_REQUEST['mcat_id'];
	$order_id=$_REQUEST['del'];
	if($order_id !='' && $order_id=='ok')
	{  
		/*$mcat_image=mysql_query("SELECT * FROM `toon_ez_products` WHERE `ecat_id`='$mcat_id'");
		while(mysql_fetch_assoc($mcat_image))
		{
		$img_name=$mcat_images['ezproduct_image'];
		unlink(DIR_EZ_IMAGES.$img_name);
		}
		mysql_query("DELETE FROM `toon_ez_products` WHERE `ecat_id`='$mcat_id'");*/
		$delete=mysql_query("DELETE FROM `toon_main_category` WHERE `mcat_id`='$mcat_id'");
	}
	$change_mcatid = $_POST['change_mcatid'];
	if($change_mcatid!='')
	{
		$mcat_priority=$_POST['mcat_'.$change_mcatid];
		$query= "UPDATE `toon_main_category` SET `mcat_priority`='$mcat_priority' WHERE `mcat_id`='$change_mcatid'";
		$result = mysql_query($query);	
	}

$ez_details=mysql_query("SELECT * FROM `toon_main_category` ");
$count=mysql_num_rows($ez_details);
include ('includes/header.php');
?>
<script>
function show_confirm()
{
	var r=confirm("Do you really want to delete this Category?");
	return r;
    
}
function changepriority(mcatid)
{
//alert(mcatid);
	document.getElementById("change_mcatid").value=mcatid;
	document.mcat.submit();
}
</script>
<table cellpadding="0" cellspacing="10" border="0" width="97%">
 <tr>
  <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
  <td align="center" valign="top">
    <table cellpadding="0" cellspacing="0" width="100%" class="table_border">
     <tr class="table_titlebar"><td class="main_heading" height="30" width="100%" colspan="4">EZ Main Categories</td></tr>
      <tr><td height="40px;" colspan="2" align="right" valign="bottom">
	  <input type="button" value="Add EZ Main Category" onclick="window.location='add_maincategory.php'" /></td></tr>
      <tr>
      	<td width="2%">&nbsp;</td>
      	<td align="center">
		<?
			if ($count)
			{?>
            	<form action="" method="post" name="mcat">
				<table cellpadding="0" cellspacing="0" width="100%" class="table_border">
      <tr class="heading_bg">
          <td class="sub_heading">EZ Main Category Id</td>
          <td class="sub_heading">EZ Main Category Name</td>
          <td class="sub_heading">EZ Main Category Priority</td>
          <td class="sub_heading">Actions</td>
      </tr>
      <input type="hidden" name="change_mcatid" id="change_mcatid" />
       <?
	   while($ez_products=mysql_fetch_assoc($ez_details))
	   {
	   ?>
        <tr>
          <td align="left" class="table_details" ><?=$ez_products['mcat_id']?></td>
          <td align="left" class="table_details" ><?=$ez_products['mcat_name']?></td>
		  
          <td align="left" class="table_details"><select name="mcat_<?=$ez_products['mcat_id']?>" onchange="return changepriority(<?=$ez_products['mcat_id']?>)">
				 <? for($i=1;$i<=$count;$i++)
					{
				  ?>
				  <option value="<?=$i?>" <? if($ez_products['mcat_priority']==$i) {?> selected="selected"<? } ?>><?=$i?></option>
                  <?
				    }
				  ?>
				</select></td>
          <td align="left" class="table_details"><a href="edit_maincategory.php?mcat_id=<?=$ez_products['mcat_id'];?>" class="anger_tags">
		  <img border="0" src="images/edit.png" title="Modify the Category" alt="Modify the Category" />
		  </a><a onclick="return show_confirm()" href="main_category.php?mcat_id=<?=$ez_products['mcat_id'];?>&del=ok">
		  <img border="0" src="images/delete.png" title="Delete this Category" alt="Delete this Category"/></a></td>
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
				<td class="no_details_msg">No EZ Main Categories Added</td>
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