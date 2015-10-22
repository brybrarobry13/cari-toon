<?
	include('includes/configuration.php');
	//TO DELETE COOL LINKS
	$cc_id =$_REQUEST['cc_id'];
	$del=$_REQUEST['del'];
	
	if($cc_id && $del)
	{
		$del_cool_link = mysql_query("delete from toon_cool_coupon where `cc_id`='$cc_id'");
    }
 $count_pdts = mysql_query("SELECT COUNT( * ) `cat_count` , TC. * , TEP. *
FROM `toon_cool_coupon` TEP, `toon_cool_categories` TC
WHERE TC.cct_id = TEP.cct_id AND TEP.cc_flag=0 
GROUP BY TEP.`cct_id`
ORDER BY TEP.`ref_priority` ASC");
$change_proid = $_POST['change_proid'];
if($change_proid)
{
	$pro_priority=$_POST['ezpro_'.$change_proid];
	$query= "UPDATE `toon_cool_coupon` SET `ref_priority`='$pro_priority' WHERE `cc_id`='$change_proid'";
	$result = mysql_query($query);
}
while($count_pdts_row = mysql_fetch_array($count_pdts))
{
$count_ez[$count_pdts_row['cct_id']]=$count_pdts_row['cat_count'];
//echo $count_ez[$count_pdts_row['cct_id']];

}
	$sql_cool_link="
SELECT toon_cool_coupon.*,toon_cool_categories.cct_category_name
FROM toon_cool_coupon LEFT JOIN toon_cool_categories
ON toon_cool_coupon.cct_id = toon_cool_categories.cct_id
WHERE `cc_flag` = '0'
ORDER BY toon_cool_categories.cct_category_name ASC, toon_cool_coupon.cc_link_name ASC
";
	$rs_cool_link=mysql_query($sql_cool_link);

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
	document.coollinks.submit();
}
</script>

<table cellpadding="0" cellspacing="10" border="0" width="97%">
  <tr>
    <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
    <td align="center" valign="top"><table cellpadding="0" cellspacing="0" width="100%" class="table_border">
        <tr class="table_titlebar">
          <td class="main_heading" height="30" colspan="4">Cool Links</td>
        </tr>
        <tr>
          <td height="40" colspan="2" align="right" style="padding-right:18px;"><input type="submit" name="submit" value="Add Cool Link"onclick="window.location='edit_cool_links.php'" /></td>

        </tr>
        <tr>
          <td width="1%">&nbsp;</td>
          <td width="94%" align="center"><?
		
		$number=mysql_num_rows($rs_cool_link);
		if ($number!=0)
		{
		?>
		<form action="" method="post" name="coollinks">
            <table cellpadding="4" cellspacing="0" width="95%" class="table_border" >
              <tr class="heading_bg">
                <td class="sub_heading" height="30">Reference Name</td>
                <td class="sub_heading" height="30">Reference Category</td>
                <td class="sub_heading" height="30">Reference Link</td>
				<td class="sub_heading" height="30">Reference Priority</td>
                <td class="sub_heading" height="30">Description</td>
                <td class="sub_heading" height="30">Actions</td>
              </tr>
			   <input type="hidden" id="change_proid" name="change_proid" />
              <?
	   while($row_cool_link=mysql_fetch_assoc($rs_cool_link))
	   {
	   		$ref_link = $row_cool_link['cc_link'];
	   		$description = $row_cool_link['cc_desc'];
	   		
	   		
	   ?>
              <tr>
                <td align="left" class="table_details"><?=stripslashes($row_cool_link['cc_link_name']);?></td>
                <td align="left" class="table_details"><?=$row_cool_link['cct_category_name'];?></td>
                <td align="left" class="table_details"><? if (strlen($ref_link)>30){ echo substr($ref_link,0,30)." ...";} else { echo $ref_link; }?></td>
				
				<td align="left" class="table_details" ><select name="ezpro_<?=$row_cool_link['cc_id']?>" onchange="return changepriority(<?=$row_cool_link['cc_id']?>)">
				 <? for($i=1;$i<=$count_ez[$row_cool_link['cct_id']];$i++)
					{
				  ?>
				  <option value="<?=$i?>" <? if($row_cool_link['ref_priority']==$i) {?> selected="selected"<? } ?>><?=$i?></option>
                  <?
				    }
				  ?>
				</select></td>
                <td align="left" class="table_details"><?if (strlen($description)>30){ echo substr($description,0,30)." ...";} else { echo $description; }?></td>
                <td align="left" class="table_details"><a href="edit_cool_links.php?cc_id=<?=$row_cool_link['cc_id'];?>" class="anger_tags"><img border="0" src="images/edit.png" title="Modify this Cool Link" alt="Modify this Cool Link" /></a> <a onclick="return confirmation()"href="manage_cool_links.php?cc_id=<?=$row_cool_link['cc_id'];?>&del=1"><img border="0" src="images/delete.png" title="Delete this Cool Link" alt="Delete this Cool Link"/></a></td>
              </tr>
              <?
	   }
       ?>
              <tr>
                <td height="40" colspan="5"></td>
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
                <td class="no_details_msg">No Cool Links!</td>
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
