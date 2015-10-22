<?  include('includes/configuration.php');
	$user_id=$_REQUEST['user_id'];
	$artist=$_POST["artist"];
	$activity = 0;
	if(isset($_REQUEST['activity']))
	{
		$activity = $_REQUEST['activity'];
		if($_REQUEST['activity'] == 0)
		{
			$filterby .= "";
		}
		if($_REQUEST['activity'] == 1)
		{
			$filterby = "AND user_status = 'Active'";
		}
		if($_REQUEST['activity'] == 2)
		{
			$filterby = "AND user_status = 'Inactive'";
		}
	}
	if($user_id)
	{
		$active_art_num=mysql_num_rows(mysql_query("SELECT * FROM `toon_orders` WHERE `artist_id`='$user_id' AND `order_status`!='In Cart' AND `order_status`!='Pending' AND `order_status`!='artist paid' AND `order_status`!='Refunded' "));
		if($active_art_num==0)
		{
		$delete=mysql_query("UPDATE `toon_users` SET `user_delete` = '1' WHERE `user_id`='$user_id'");
		$msg="Artist Deleted";
		}
		else
		{
		$msg="Cannot Delete Artist";
		}
	}
	
	$change_id=$_POST['change_id'];
	if($_POST['change_id']!="")
		{ 	
			$artist=$_POST['artist_'.$_POST['change_id']];
			$query= "UPDATE `toon_users` SET `user_artist_priority`='$artist' WHERE `user_id`='$change_id'";
			$result = mysql_query($query);	
		}
	 $sql_content = "SELECT *,DATE_FORMAT(`user_joined`, '%m-%d-%y') as `user_joined` FROM `toon_users` WHERE `utype_id`=2 AND `user_delete`=0 ".$filterby." ORDER BY `user_artist_priority` ASC, `user_status` ASC ";
	$rs_content = mysql_query($sql_content);
	$count_user=mysql_num_rows($rs_content);
	
include ('includes/header.php');
?>
<script type="text/javascript">
function show_confirm()
{
	var r=confirm("Do you really want to delete this artist?");
	return r;
    
}
function changepriority(id)
{	
	document.getElementById("change_id").value=id;
	document.manage_artist.submit();
}
function filterBy()
{
	document.manage_artist.submit();
}
</script>
<form name="manage_artist" method="post" action="manage_artists.php">
<table cellpadding="0" cellspacing="10" border="0" width="97%">
  <tr>
    <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
    <td align="center"valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="table_border">
        <tr class="table_titlebar">
          <td class="main_heading" height="30" colspan="4">Artists</td>
        </tr>
        <tr>
          <td height="40px;" colspan="2" align="center"><div style="float:left; padding-left:9px;" class="table_details">Filter By : 
		<select name="activity" onchange="filterBy()">
		<option value="0" <?php if($activity == 0) { ?> selected="selected" <?php }?>>All</option>
		<option value="1" <?php if($activity == 1) { ?> selected="selected" <?php }?>>Active</option>
		<option value="2" <?php if($activity == 2) { ?> selected="selected" <?php }?>>Inactive</option>
		</select></div>
		<div style="float:right;"><input type="button" value="Add Artist" onclick="window.location='edit_artist.php'"/></div></td>
        </tr>
        <tr><td colspan="2" align="center" class="no_details_msg"><?=$msg?></td></tr>
		
		<? if($no_content = mysql_num_rows($rs_content)==0) 
							{ 
					  ?>
        <tr>
          <td align="center" colspan="5" class="no_details_msg">No Artists</td>
        </tr>
        <? 		} 
					
					else {
					?>
        <tr>
          <td width="1%">&nbsp;</td>
          <td width="98%" align="center" ><table cellpadding="0" cellspacing="0" width="100%" class="table_border">
              <tr class="heading_bg">
                <td width="23%" height="30" class="sub_heading">Name</td>
                <td width="25%" class="sub_heading">Email</td>
                <td width="17%" class="sub_heading">Artist Status</td>
				 <td width="17%" class="sub_heading">Approval Status</td>
                <td width="20%"  class="sub_heading">Date of Joining</td>
				<td width="20%"  class="sub_heading">Artist priority</td>
                <td width="15%"  class="sub_heading">Actions</td>
              </tr>
			  <tr>
                <td height="10" colspan="5"></td>
              </tr>
              <?  	
			    while($content=mysql_fetch_array($rs_content))
				{
				
				 ?>
              <tr>
                <td align="left" class="table_details"><?=$content['user_fname'].' '.$content['user_lname']?></td>
                <td align="left" class="table_details"><?=$content['user_email']?></td>
                <td align="left" class="table_details"><?=$content['user_status']?></td>
				 <td align="left" class="table_details"><?=$content['approval_status']?></td>
                <td align="left" class="table_details"><?=$content['user_joined']?></td>
				<td align="left" class="table_details"><input type="text" size="2" name="artist_<?=$content['user_id']?>" onchange="return changepriority(<?=$content['user_id']?>)" id="artist" value="<?=$content['user_artist_priority']?>">
				 
				</td>
                <td align="left" class="table_details"><a href="edit_artist.php?user_id=<?=$content['user_id'];?>" class="anger_tags"><img border="0" src="images/edit.png" title="Modify the Profile" alt="Modify the Profile" /></a>  <a onclick="return show_confirm()"href="manage_artists.php?user_id=<?=$content['user_id'];?>&del"><img border="0" src="images/delete.png" title="Delete this Artist" alt="Delete this Artist"/></a></td>
              </tr>
			   <tr>
                <td height="5" colspan="5"></td>
              </tr>
              <?
				  } }
				  ?>
				  
              <tr>
                <td height="40" colspan="5"><input type="hidden" name="change_id" id="change_id"></td>
              </tr>
            </table></td>
          <td width="1%">&nbsp;</td>
        </tr>
               <tr>
          <td height="40" colspan="5"></td>
        </tr>
      </table></td>
  </tr>
  
</table>
</form>
<?	include("includes/footer.php");
?>
