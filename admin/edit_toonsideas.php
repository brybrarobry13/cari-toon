<?  include('includes/configuration.php');
	$ti_id=$_REQUEST['ti_id'];
	
	if(isset($_REQUEST['del_img_id']))
	{
		$del_id = $_REQUEST['del_img_id'];
		$sql_del="SELECT * FROM toon_admin_artist_images WHERE artist_img_id=$del_id";
		$rs_del = mysql_query($sql_del);
		$row_del=mysql_fetch_assoc($rs_del);
		unlink("../z_uploads/admin_artist_gallery/thumb_artist_images/th_".$row_del['img_name']);
		unlink("../z_uploads/admin_artist_gallery/artist_images/".$row_del['img_name']);
		mysql_query("DELETE FROM toon_admin_artist_images WHERE artist_img_id=$del_id");
	}
	if($ti_id!="")
	{
		$sql_ideas="SELECT * FROM `toons_ideas` WHERE `ti_id`='$ti_id'";
		$rs_ideas = mysql_query($sql_ideas);
		$row_ideas=mysql_fetch_assoc($rs_ideas);
	}
	
	if(isset($_REQUEST['submit']))
	{
		$img_name=$_REQUEST["photo_1"];
		$artist_id=$_REQUEST["ti_art_name"];
		
		$sql_insert="INSERT INTO `toon_admin_artist_images` (artist_id,img_name,ti_id) VALUES ($artist_id,'$img_name',$ti_id)";	
		$inser_promo=mysql_query($sql_insert);
		
		$art_img_id=mysql_insert_id();
		$new_img_name=$art_img_id.'_'.$img_name;
		
		$sql_update="UPDATE `toon_admin_artist_images` SET img_name='$new_img_name' WHERE artist_img_id=$art_img_id";	
		$update_promo=mysql_query($sql_update);
		
		copy("../z_uploads/admin_artist_gallery/thumb_artist_images/th_".$img_name, "../z_uploads/admin_artist_gallery/thumb_artist_images/th_".$new_img_name);
		unlink("../z_uploads/admin_artist_gallery/thumb_artist_images/th_".$img_name);
		copy("../z_uploads/admin_artist_gallery/artist_images/".$img_name, "../z_uploads/admin_artist_gallery/artist_images/".$new_img_name);
		unlink("../z_uploads/admin_artist_gallery/artist_images/".$img_name);
		unlink("../z_uploads/admin_artist_gallery/artist_images/for_crop_".$img_name);
	}			
	include ('includes/header.php');
?>
<script type="text/javascript">
function valid()
{
	clear();
	var valid=true;
		if(document.getElementById("ti_ref_name").value=="")
    	{      
			document.getElementById("rname_div").style.display="block";
			valid=false;
     	}
		return valid;
}
function clear()
{
	document.getElementById("rname_div").style.display="none";
	document.getElementById("rlink_div").style.display="none";
}
function confirmation(f_id)
{
	if(confirm("Do you really want to delete?"))
	{
		var form_name="del_form_"+f_id;
		document.forms[form_name].submit();
		return true;
	}
	return false;	
}

function edit_details(ti_id)
{
	window.open('edit_idea_details.php?ti_id='+ti_id,'EDIT DETAILS','width=1200','height=1000','scrollbars=0');
}

function add_image(ti_id)
{
	//window.open ("http://www.javascript-coder.com", "mywindow","location=1,status=1,scrollbars=1, width=100,height=100");
	//window.open('add_image.php?ti_id='+ti_id,'ADD IMAGE','screenX=285,screenY=178,location=1,status=0,resizable=0,scrollbars=0, width=600,height=100');
	document.getElementById('add_new_image').style.display = 'block';
	
}
function check_form()
{
	document.getElementById('crop_err').style.display = 'none';
	document.getElementById('art_err').style.display = 'none';
	if(document.getElementById("cropped").value!='yes')
	{
		document.getElementById('crop_err').style.display = 'block';
		return false;
	}
	if(document.getElementById("ti_art_name").value=='')
	{
		document.getElementById('art_err').style.display = 'block';
		return false;
	}
}

function startUpload()
{
	  document.getElementById('f1_upload_process_1').style.display = 'block';
	  document.getElementById('f1_upload_form_1').style.display = 'none';
      return true;
}

function stopUpload(success,file_name)
{
	//alert(file_name);
	var result = '';
	if (success == 1)
	{
		window.open('templates/jcrop_main.php?file_name='+file_name,'CROP IMAGE','width=1200,height=620,scrollbars=0');
	}
	else 
	{
		result = '<span class="emsg">There was an error during file upload!<\/span><br/><br/>';
	}
	document.getElementById('f1_upload_process_1').style.display = 'none';
	document.getElementById('f1_upload_form_1').style.display = 'block';  
	if(file_name.substr(0,6)=='artist')
	{
		document.getElementById('photo_1').value=file_name;
		document.getElementById("cropped").value="no";
		// alert(file_name);
	}
	
	/*alert(document.getElementById("cropped_1").value);
	alert(document.getElementById("cropped_2").value);*/
	return true;   
}

function set_cropped_no(img_id)
{
	if(img_id=='1')
	{
		document.getElementById("cropped").value="no";
	}
}
</script> 
  <table cellpadding="0" cellspacing="10" border="0" width="97%">
    <tr>
      <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
      <td align="center" valign="top"><table cellpadding="0" cellspacing="0" width="100%" class="table_border">
          <tr class="table_titlebar">
            <td class="main_heading" height="30" colspan="4">Manage Toons Ideas</td>
          </tr>
		  <tr>
            <td class="header_sub_text" style="padding-left:50px; padding-top:30px;" height="30" colspan="4">Page Details ( <a style="cursor:pointer; font-weight:bold; color:#03F;" onclick="edit_details('<?=$_GET['ti_id']?>')">Edit</a> ) </td>
          </tr>
		  <tr>
            <td width="1%">&nbsp;</td>
            <td width="98%" align="center" valign="top"><table cellpadding="5" cellspacing="0" width="100%" class="">
                
				<tr>
				<tr><td></td></tr>
				<td width="4%">&nbsp;</td>
                  <td width="18%" align="left" class="table_details">Page Name&nbsp;</td><td>:</td>
                  <td width="76%" align="left" style="font-weight:bold;"><?=$row_ideas['ti_ref_name']?></td>
                </tr>
                <tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">Page Link&nbsp;</td><td>:</td>
                  <td align="left" style="font-weight:bold;"><?=$row_ideas['ti_ref_link']?>
				  </td>
				</tr>
				<tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details" valign="top">Top Text&nbsp;</td><td valign="top">:</td>
                  <td align="left" style="font-weight:bold;"><?=$row_ideas['ti_top_text']?>
				  </td>
				</tr>
				<tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details" valign="top">Bottom Text&nbsp;</td><td valign="top">:</td>
                  <td align="left" style="font-weight:bold;"><?=$row_ideas['ti_bottom_text']?>
				  </td>
				</tr>
                <td>&nbsp;</td>
                  <td align="left" class="table_details">Meta Keyword&nbsp;</td><td>:</td>
                  <td align="left" style="font-weight:bold;"><?=$row_ideas['ti_pg_keyword']?>
				  </td>
				</tr>
				<tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details" valign="top">Meta Title&nbsp;</td><td valign="top">:</td>
                  <td align="left" style="font-weight:bold;"><?=$row_ideas['ti_pg_title']?>
				  </td>
				</tr>
				<tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details" valign="top">Meta Description&nbsp;</td><td valign="top">:</td>
                  <td align="left" style="font-weight:bold;"><?=$row_ideas['ti_pg_des']?>
				  </td>
				</tr>
            </table></td>
            <td width="1%">&nbsp;</td>
          </tr>
          <tr>
            <td height="40" colspan="4"></td>
          </tr>
        </table>
		
		<table cellpadding="0" cellspacing="0" width="100%" class="table_border">
		 <tr>
            <td class="header_sub_text" style="padding-left:50px; padding-top:30px;" height="30" colspan="4">Artist Images ( <a style="cursor:pointer;font-weight:bold; color:#03F;" onclick="add_image('<?=$_GET['ti_id']?>')">Add New</a> ) </td>
          </tr>
          
		  <tr><td id="add_new_image" style="display:none; padding-left:50px; padding-right:50px;">
		  
		  <div style=" border:1px solid #063;">
		  
			<table cellpadding="5" cellspacing="0" border="0" width="100%" class="">
                <tr>
				<td colspan="2"><div id="crop_err" style="display:none; padding-left:50px;" class="no_details_msg">Please Choose and Crop an image</div>
			<div id="art_err" style="display:none;padding-left:50px;" class="no_details_msg">Please Choose an artist</div></td>
				
				</tr>
				
				<tr>
				
				 <td id="new_image" style="padding-left:60px;">
					<form action="upload.php?type=artist" method="post" enctype="multipart/form-data" target="upload_target" onsubmit="startUpload(1);" >
                     <p id="f1_upload_process_1" style="display:none;">Loading...<br/><img src="images/loader.gif" /><br/></p>
                     <p id="f1_upload_form_1" class="text_blue">
                         <label>New Image&nbsp;:
                              <input name="myfile" type="file" id="myfile_1" onchange="set_cropped_no(1)" size="30"  />
                         </label>
						 
                         <label>
                             <input type="submit" name="submitBtn" class="sbtn" value="Crop Image" />
                         </label>
                         <input type="hidden" name="sess_val" value="<?=$_GET['ti_id']?>" />
						 
                     </p>
                     <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                 </form>
				 </td>
				</tr>
				<tr><td style="padding-left:60px;">
				<form action="edit_toonsideas.php?ti_id=<?=$ti_id?>" method="post" onsubmit="return check_form()">
					  Artist Name&nbsp;:
					  <select name="ti_art_name" id="ti_art_name" />
					  <option value="">--Choose An Artist--</option>
					  <?php
					  $res=mysql_query("SELECT * FROM `toon_users` WHERE `utype_id`=2 AND `user_status`='Active'");
					  while($row_artist=mysql_fetch_array($res))
					  {
					  ?>
						<option value="<?=$row_artist['user_id']?>"><?php echo $row_artist['user_fname'].' '.$row_artist['user_lname'];?></option>
					  <?php
					  }
					  ?>
					  </select>
					  <input type="hidden" name="photo_1" id="photo_1" />
					  <input type="hidden" name="cropped" id="cropped" value="no" />
					  <span style="padding-left:93px;"></span>
					  <input type="submit" name="submit" value="Save Image & Artist" />
				</form>
				</td></tr>
				
            </table>
		  </div>
		 	 
		  </td></tr>
		  <tr><td style="padding-left:50px; padding-bottom:30px;">
		  <?php 
		  	$sql_img="SELECT * FROM toon_admin_artist_images INNER JOIN toon_users ON toon_admin_artist_images.artist_id = toon_users.user_id WHERE ti_id=".$ti_id;
		  	$res_img=mysql_query($sql_img);
			while($row_img=mysql_fetch_array($res_img))
			{?>
				<div style="float:left;padding-right:15px; padding-top:15px; font-size:16px">
				 <img src="../z_uploads/admin_artist_gallery/thumb_artist_images/th_<?=$row_img['img_name']?>" style="padding-bottom:5px;"  /><br />
				 <form action="edit_toonsideas.php?ti_id=<?=$ti_id?>&del_img_id=<?=$row_img['artist_img_id']?>" method="post" name="del_form_<?=$row_img['artist_img_id']?>" id="del_form_<?=$row_img['artist_img_id']?>" style="text-align:center; padding-top:5px;"><?php echo $row_img['user_fname'].' '.$row_img['user_lname'];?><a onclick="confirmation(<?=$row_img['artist_img_id']?>)" style="float:right; cursor:pointer;"><img src="images/delete.png" /></a></form>
				</div>
				 
	  <?php } ?> 
		 
		  </td></tr>
        </table>
		
		</td>
    </tr>
  </table>
  	


<?	include("includes/footer.php");?>
