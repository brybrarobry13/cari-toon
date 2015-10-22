<?  include('includes/configuration.php');
if(isset($_REQUEST['submit_style']))
{
	$style_name = $_REQUEST['style_name'];
	$sql_ideas = "SELECT * FROM toon_artist_styles WHERE style_name='".$style_name."'";
	$rs_ideas = mysql_query($sql_ideas);
	if(mysql_num_rows($rs_ideas) == 0)
	{
		$sql_insert="INSERT INTO toon_artist_styles (style_name) VALUES('".$style_name."')";
		mysql_query($sql_insert);
		
		$msg="New Style ' ".$style_name." ' added successfully !";
		$success_flag=true;
		
		header('location: manage_artist_styles.php');
	}
	else
	{
		$msg="The Style ' ".$style_name." ' already exists !";
		$success_flag=false;
	} 
	
}
		include ('includes/header.php');
 ?>
<script>
function Check_form()
{
	if(document.getElementById('style_name').value=="")
	{
		document.getElementById('erro_msg').style.display='block';
		return false;
	}
	return true;
}
</script>
<table cellpadding="0" cellspacing="10" border="0" width="97%">
  <tr>
    <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
    <td align="center" valign="top"><table cellpadding="0" cellspacing="0" width="100%" border="0" class="table_border">
        <tr class="table_titlebar">
          <td class="main_heading" height="30" colspan="4">Artist Styles</td>
        </tr>
       
        <tr>
      
         <td width="94%" align="center" style="<?php if($success_flag){?> color:#009900<?php } else { ?>color:#FF0000<?php } ?>; font-size:12px; font-weight:bold; padding-top:10px;">
   			<?=$msg;?>
			<div style="display:none;" id="erro_msg">Please enter a style Name !</div>
         </td>
        </tr>
        <tr>
          <td height="40" colspan="4" style=" padding-top:10px;" class="header_sub_text" align="center">

		  <form action="add_style.php" method="post" onSubmit="return Check_form()">
		  Style Name : <input type="text" name="style_name" id="style_name">
		  <input type="submit" name="submit_style" value="Add Style"> 
		  </form>
		  </td>
        </tr>
      </table></td>
  </tr>
</table>
<?	include("includes/footer.php");?>
