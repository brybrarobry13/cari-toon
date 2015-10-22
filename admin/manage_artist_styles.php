<?  include('includes/configuration.php');
	//TO DELETE COUPON
	$style_id =$_REQUEST['style_id'];
	$del=$_REQUEST['del'];
	if($style_id && $del)
	{
	    $del_ideas1 = mysql_query("delete from toon_artist_styles where style_id='$style_id'");
    }
	
	$sql_ideas="SELECT * FROM toon_artist_styles";
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
          <td class="main_heading" height="30" colspan="4">Artist Styles</td>
        </tr>
        <tr>
          <td height="40" colspan="2" align="right" style="padding-right:18px;">
		  <form action="add_style.php" method="post"><input type="submit" name="submit" value="Add New Style"/></form></td>

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
                <td class="sub_heading" height="30">Style Name</td>
                <td class="sub_heading" height="30">Actions</td>
              </tr>
			  
              <?
	   while($row_ideas=mysql_fetch_assoc($rs_ideas))
	   {
	   		$ref_link = $row_ideas['style_name'];
	   ?>
	   
              <tr>
			                <td align="left" class="table_details"><?=$row_ideas['style_name'];?></td>
                <td align="left" class="table_details"><a href="edit_style.php?style_id=<?=$row_ideas['style_id'];?>" class="anger_tags"><img border="0" src="images/edit.png" title="Modify this Style" alt="Modify this Style" /></a> <a onclick="return confirmation()"href="manage_artist_styles.php?style_id=<?=$row_ideas['style_id'];?>&del=1"><img border="0" src="images/delete.png" title="Delete this Style" alt="Delete this Style"/></a></td>
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
                <td class="no_details_msg">No Styles!</td>
              </tr>
            </table>
            <? } ?>
          </td>
          <td width="5%">&nbsp;</td>
        </tr>
        <tr>
          <td height="40" colspan="4" style="padding-left:30px;">
		  </td>
        </tr>
      </table></td>
  </tr>
</table>
<?	include("includes/footer.php");?>
