<?
	include('includes/configuration.php');
	//TO DELETE COOL CATEGORIES
	$cct_id =$_REQUEST['cct_id'];
	$del=$_REQUEST['del'];
	
	if($cct_id && $del)
	{
		$del_cool_category = mysql_query("delete from toon_cool_categories where `cct_id`='$cct_id'");
		mysql_query("update toon_cool_coupon set `cct_id`='0' where cc_flag='O' AND `cct_id`='$cct_id'");
    }
		$change_proid = $_POST['change_proid'];
			if($change_proid)
			{
				$pro_priority=$_POST['cat_'.$change_proid];
				$query= "UPDATE `toon_cool_categories` SET `cc_priority`='$pro_priority' WHERE `cct_id`='$change_proid'";
				$result = mysql_query($query);
			}
	$sql_cool_category="SELECT * FROM `toon_cool_categories` ORDER BY `cct_category_name` ASC";
	$rs_cool_category=mysql_query($sql_cool_category);
	$count=mysql_num_rows($rs_cool_category);

	include ('includes/header.php');
 ?>
<script>
function confirmation()
{
	if(confirm("Do you really want to delete?"))
	{
		return true;
	}
	return false;	
}

function changepriority(proid)
{
	document.getElementById("change_proid").value=proid;
	document.category.submit();
}
</script>


<table cellpadding="0" cellspacing="10" border="0" width="97%">
  <tr>
    <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
    <td align="center" valign="top"><table cellpadding="0" cellspacing="0" width="100%" class="table_border">
        <tr class="table_titlebar">
          <td class="main_heading" height="30" colspan="4">Cool Categories Categories</td>
        </tr>
        <tr>
          <td height="40" colspan="2" align="right" style="padding-right:18px;"><input type="submit" name="submit" value="Add Cool Link Category"onclick="window.location='edit_cool_category.php'" />
          </td>


        </tr>
		 
        <tr>
          <td width="1%">&nbsp;</td>
          <td width="94%" align="center"><?
		
		$number=mysql_num_rows($rs_cool_category);
		if ($number!=0)
		{
		?>
		<form action="" method="post" name="category">
            <table cellpadding="4" cellspacing="0" width="95%" class="table_border" >
              <tr class="heading_bg">
                <td class="sub_heading" height="30">Category Name</td>
                <td class="sub_heading" height="30">Description</td>
				<td class="sub_heading" height="30">Priority</td>
                <td class="sub_heading" height="30">Actions</td>
              </tr>
			  <input type="hidden" id="change_proid" name="change_proid" />
              <?
	   while($row_cool_category=mysql_fetch_assoc($rs_cool_category))
	   {
	   		$ref_category_name = $row_cool_category['cct_category_name'];
	   		$description = $row_cool_category['cct_description'];
	   		
	   		
	   ?>
              <tr>
                <td align="left" class="table_details"><?=$row_cool_category['cct_category_name'];?></td>
                <td align="left" class="table_details"><? if (strlen($description)>30){ echo substr($description,0,30)." ...";} else { echo $description; }?></td>
				<td align="left" class="table_details" ><select name="cat_<?=$row_cool_category['cct_id']?>" onchange="return changepriority(<?=$row_cool_category['cct_id']?>)">
				 <? for($i=1;$i<=$count;$i++)
					{
				  ?>
				  <option value="<?=$i?>" <? if($row_cool_category['cc_priority']==$i) {?> selected="selected"<? } ?>><?=$i?></option>
                  <?
				    }
				  ?>
				</select></td>
                <td align="left" class="table_details"><a href="edit_cool_category.php?cct_id=<?=$row_cool_category['cct_id'];?>" class="anger_tags"><img border="0" src="images/edit.png" title="Modify this Cool Category" alt="Modify this Cool Category" /></a> <a onclick="return confirmation()"href="manage_cool_categories.php?cct_id=<?=$row_cool_category['cct_id'];?>&del=1"><img border="0" src="images/delete.png" title="Delete this Cool Category" alt="Delete this Cool Category"/></a></td>
              </tr>
              <?
	   }
       ?>
              <tr>
                <td height="40" colspan="3"></td>
              </tr>
            </table>
			</form>
            <?
		}
		else
		{
		?>
            <table align="center">
              <tr>
                <td class="no_details_msg">No Cool Categories!</td>
              </tr>
            </table>
            <? } ?>
          </td>
          <td width="5%">&nbsp;</td>
        </tr>
        <tr>
          <td height="40" colspan="4"></td>
        </tr>
      </table></td>
  </tr>
</table>
<?	include("includes/footer.php");?>
