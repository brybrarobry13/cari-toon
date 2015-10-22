<?
include('includes/configuration.php');

	$ez_catid=$_REQUEST['ez_catid'];
	$main_catid=$_REQUEST['mcat_id'];
	$order_id=$_REQUEST['del'];
	if($order_id !='' && $order_id=='ok')
	{  
		$ez_images=mysql_query("SELECT * FROM `toon_ez_products` WHERE `ecat_id`='$ez_catid'");
		while(mysql_fetch_assoc($ez_images))
		{
		$img_name=$ez_images['ezproduct_image'];
		unlink(DIR_EZ_IMAGES.$img_name);
		}
		mysql_query("DELETE FROM `toon_ez_products` WHERE `ecat_id`='$ez_catid'");
		$delete=mysql_query("DELETE FROM `toon_ez_categories` WHERE `ecat_id`='$ez_catid'");
	}
	$change_catid = $_POST['change_catid'];
	if($change_catid!='')
	{
		$ecat_priority=$_POST['ecat_'.$change_catid];
		$query= "UPDATE `toon_ez_categories` SET `ecat_priority`='$ecat_priority' WHERE `ecat_id`='$change_catid'";
		$result = mysql_query($query);	
	}
	
$ez_details=mysql_query("SELECT TC.*,TEP.* FROM `toon_ez_categories` TEP,`toon_main_category` TC WHERE TC.mcat_id=TEP.mcat_id ORDER BY TEP.`ecat_priority` ASC");
$count=mysql_num_rows($ez_details);

$count_pdts = mysql_query("SELECT COUNT( * ) `cat_count` , TC. * , TEP. *
FROM `toon_ez_categories` TEP, `toon_main_category` TC
WHERE TC.mcat_id = TEP.mcat_id
GROUP BY TC.`mcat_id`
ORDER BY TC.`mcat_priority` ASC");

while($count_cats_row = mysql_fetch_array($count_pdts))
{
$count_ez[$count_cats_row['mcat_id']]=$count_cats_row['cat_count'];
}

include ('includes/header.php');
?>
<script>
function show_confirm()
{
	var r=confirm("Do you really want to delete this Category?");
	return r;
    
}
function changepriority(catid)
{
	document.getElementById("change_catid").value=catid;
	document.ezcat.submit();
}
</script>
<table cellpadding="0" cellspacing="10" border="0" width="97%">
 <tr>
  <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
  <td align="center" valign="top">
    <table cellpadding="0" cellspacing="0" width="100%" class="table_border">
     <tr class="table_titlebar"><td class="main_heading" height="30" width="100%" colspan="4">EZ Categories</td></tr>
      <tr><td height="40px;" colspan="2" align="right" valign="bottom"><input type="button" value="Add EZ Category" onclick="window.location='add_ezcategory.php'" /></td></tr>
      <tr>
      	<td width="2%">&nbsp;</td>
      	<td align="center">
		<?
			if ($count)
			{?>
            	<form action="" method="post" name="ezcat">
				<table cellpadding="0" cellspacing="0" width="100%" class="table_border">
      <tr class="heading_bg">
          <td class="sub_heading">EZ Category Id</td>
		  <td class="sub_heading">EZ Main Category Name</td>
          <td class="sub_heading">EZ Category Name</td>
          <td class="sub_heading">EZ Category Priority</td>
          <td class="sub_heading">Actions</td>
      </tr>
      <input type="hidden" name="change_catid" id="change_catid" />
       <?
	   while($ez_products=mysql_fetch_assoc($ez_details))
	   {
	   ?>
        <tr>
          <td align="left" class="table_details" ><?=$ez_products['ecat_id']?></td>
		   <td align="left" class="table_details" ><?=$ez_products['mcat_name']?></td>
          <td align="left" class="table_details" ><?=$ez_products['ecat_name']?></td>
          <td align="left" class="table_details"><select name="ecat_<?=$ez_products['ecat_id']?>" onchange="return changepriority(<?=$ez_products['ecat_id']?>)">
				 <? for($i=1;$i<=$count_ez[$ez_products['mcat_id']];$i++)
					{
				  ?>
				  <option value="<?=$i?>" <? if($ez_products['ecat_priority']==$i) {?> selected="selected"<? } ?>><?=$i?></option>
                  <?
				    }
				  ?>
				</select></td>
          <td align="left" class="table_details"><a href="edit_ezcategories.php?ez_catid=<?=$ez_products['ecat_id'];?>" class="anger_tags"><img border="0" src="images/edit.png" title="Modify the Category" alt="Modify the Category" /></a><a onclick="return show_confirm()" href="ez_categories.php?ez_catid=<?=$ez_products['ecat_id'];?>&del=ok"><img border="0" src="images/delete.png" title="Delete this Category" alt="Delete this Category"/></a></td>
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
				<td class="no_details_msg">No EZ Categories Added</td>
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