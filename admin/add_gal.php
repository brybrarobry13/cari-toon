<?	include ("includes/configuration.php");
	include('includes/imageResize.php');
	$artist=$_REQUEST['artist'];
	
	if(isset($_POST['image']))
	{
	
		if ((($_FILES["file"]["type"] == "image/gif")
		|| ($_FILES["file"]["type"] == "image/jpeg")
		|| ($_FILES["file"]["type"] == "image/pjpeg")
		&& ($_FILES["file"]["size"] < 10485760)))
		{	
			mysql_query("insert into toon_artist_gallery(user_id) values('$artist')");
			$img_id=mysql_insert_id();
			$imagename 	= $_FILES["file"]["name"];
			$ext		= explode('.',$imagename);
			$destination = DIR_ARTIST_GALLERY.$img_id.".".$ext[1];	
			$db_image=$img_id.".".$ext[1];
			move_uploaded_file($_FILES["file"]["tmp_name"],$destination);
			new imageProcessing("$destination",920,600);
			mysql_query("update toon_artist_gallery set agal_image='$db_image' where `agal_id`='$img_id'");
		}
		header("Location:list_artist_gallery.php?artist=".$artist);
	}
	
 $name=mysql_fetch_assoc(mysql_query("SELECT `user_fname`as name FROM `toon_users` WHERE `user_id`='$artist'"));
include ("includes/header.php");
?>
<script>
function valid()
{
	hide();
if(document.getElementById("file").value=="")
    	{      
		 		document.getElementById("image_enter").style.display="block";
     	 		return false;
		}
		return true;
}
function hide()
{
document.getElementById("image_enter").style.display="none";
}

</script>


<form action="add_gal.php"method="post"enctype="multipart/form-data">
	<table cellpadding="0" cellspacing="10" border="0" width="97%" height="400px;">
        <tr>
        	<td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
        	<td valign="top" align="center">
             <table cellpadding="0" cellspacing="0" width="100%" class="table_border">
              <tr class="table_titlebar">
            <td class="main_heading" height="30">Add To <?=$name['name'];?>'s Gallery</td>
          </tr>
              <tr>
            <td height="20" align="center"><table cellpadding="4" cellspacing="4" align="center"><tr><td colspan="2"></td></tr>
			<tr><td colspan="2"><div id="image_enter"align="center" style="display:none; color:#CC0000">Please select the image</div></td></tr>
				<tr>
                    <td >Gallery Photo:*</td>
                    <td valign="top">
                     <input type="file" name="file" id="file" size="8" /></td>
				</tr>
				<!--<tr>
                    <td width="172">Promotional Photo:</td>
                    <td valign="top">
                     <input type="file" name="file" id="file" size="8" /></td>
				</tr>-->
                <!--<tr> 
					<td width="172">Code:</td>
					<td><input name="code" value="<?=$row['news_title'];?>" /></td>
				</tr>-->
				<tr>
					<td colspan="3" align="right"><input type="submit" name="image"  value="Submit" onclick="return valid()"/></td>
				</tr>

			</table></td>
          </tr>         	  
             </table>
            </td>
         </tr>
    </table><input type="hidden" name="artist" value="<?=$artist;?>" />
</form>
	
	
				
<? include ("includes/footer.php");?>
