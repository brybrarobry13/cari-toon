<?  include('includes/configuration.php');
	//TO DELETE COUPON
	$ti_id =$_REQUEST['ti_id'];
	$del=$_REQUEST['del'];
	if($ti_id && $del)
	{
	    $del_ideas1 = mysql_query("delete from toons_ideas where `ti_id`='$ti_id'");
		$del_ideas2 = mysql_query("select * from toon_admin_artist_images where `ti_id`='$ti_id'");	
		while($del_img_row=mysql_fetch_array($del_ideas2))
		{
			unlink("../z_uploads/admin_artist_gallery/thumb_artist_images/th_".$del_img_row['img_name']);
			unlink("../z_uploads/admin_artist_gallery/artist_images/".$del_img_row['img_name']);
		}
		$del_ideas3 = mysql_query("delete from toon_admin_artist_images where `ti_id`='$ti_id'");
    }
	
	$sql_ideas="SELECT * FROM `toons_ideas` ORDER BY ti_ref_name";
	$rs_ideas=mysql_query($sql_ideas);
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
function edit_details()
{
	window.open('edit_idea_details.php','EDIT DETAILS','width=1200','height=420','scrollbars=0');
}
</script>

<table cellpadding="0" cellspacing="10" border="0" width="97%">
  <tr>
    <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
    <td align="center" valign="top"><table cellpadding="0" cellspacing="0" width="100%" class="table_border">
        <tr class="table_titlebar">
          <td class="main_heading" height="30" colspan="4">Toons Ideas</td>
        </tr>
        <tr>
          <td height="40" colspan="2" align="right" style="padding-right:18px;"><input type="submit" name="submit" value="Add Toon Links" onclick="edit_details();" /></td>

        </tr>

        <tr>
          <td width="1%">&nbsp;</td>
          <td width="94%" align="center"><?
		
		$number=mysql_num_rows($rs_ideas);
		if ($number!=0)
		{
		?>
		  
            <table cellpadding="4" cellspacing="0" width="95%" class="table_border" >
              <tr class="heading_bg">
                <td class="sub_heading" height="30">Reference Name</td>
                <td class="sub_heading" height="30">Reference Link</td>
                <td class="sub_heading" height="30">Actions</td>
              </tr>
			  
              <?
	   while($row_ideas=mysql_fetch_assoc($rs_ideas))
	   {
	   		$ref_link = $row_ideas['ti_ref_link'];
	   ?>
	   
              <tr>
			                <td align="left" class="table_details"><?=$row_ideas['ti_ref_name'];?></td>
                <td align="left" class="table_details"><? if (strlen($ref_link)>30){ echo substr($ref_link,0,30)." ...";} else { echo $ref_link; }?></td>
                <td align="left" class="table_details"><a href="edit_toonsideas.php?ti_id=<?=$row_ideas['ti_id'];?>" class="anger_tags"><img border="0" src="images/edit.png" title="Modify this Ideas" alt="Modify this Ideas" /></a> <a onclick="return confirmation()"href="manage_toonsideas.php?ti_id=<?=$row_ideas['ti_id'];?>&del=1"><img border="0" src="images/delete.png" title="Delete this Idea" alt="Delete this Idea"/></a></td>
              </tr>
              <?
	   }
       ?>
              <tr>
                <td height="40" colspan="4"></td>
              </tr>
            </table>
			
            <?
		}
		else
		{
		?>
            <table align="center">
              <tr>
                <td class="no_details_msg">No Ideas!</td>
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
