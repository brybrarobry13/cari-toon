<?  include("includes/configuration.php");
	include("includes/functions/encryption.php");
	$shoform=true;
	@$encrypt_obj = new AzDGCrypt(1074);
	$user_id= $_SESSION['sess_tt_uid'];//Fetching the userid
	$getuserDetails = getUserDetails($user_id);//Fetching the user details according to the userid
	$res=mysql_query("SELECT * FROM `toon_users` where user_id='$user_id'");
	$row=mysql_fetch_array($res);
	
	$news=mysql_num_rows(mysql_query("SELECT * FROM `toon_newsletter` where nltr_email='$row[user_email]'"));
	
	if(isset($_REQUEST['update_x']))
	{
		$email=$_POST['email'];
		$fname=$_POST['fname'];
		$lname=$_POST['lname'];
		$decription=$_POST['user_decription'];
		$pass=$encrypt_obj->crypt($_POST['pass']);
		$offers=$_POST['offers'];
		$dup_email=mysql_num_rows(mysql_query("select * from `toon_users` where user_id!='$user_id' AND user_email='$email' AND user_delete='0'"));
		if(!$dup_email)
		{
			$update="update `toon_users` set user_email='$email',user_fname='$fname',user_lname='$lname',user_description='$decription'";
			if($pass)
			{
				$update.=",user_password='$pass' ";
			}
			$update.="where user_id='$user_id'";
			mysql_query($update);
			$shoform=false;
			/*if($offers)
			{	
				mysql_query("delete from `toon_newsletter` where nltr_email='$row[user_email]'");
				mysql_query("insert into `toon_newsletter`(nltr_email) values('$email')");
			}
			else
			{
				mysql_query("delete from `toon_newsletter` where nltr_email='$row[user_email]'");
			}*/
			if($_FILES['profile_image']['name']!='')
			{					
				if ($_FILES['profile_image']["type"] == "image/gif" || $_FILES['profile_image']["type"] == "image/jpeg" || $_FILES['profile_image']["type"] == "image/pjpeg" || $_FILES['profile_image']["type"] == "image/png")
				{
					if($_FILES['image']['size'] < 10485760)
					// IF PHOTO SIZE LESS THAN ALLOWED SIZE THEN CONTINUE
					{	
						$photoName1=$_FILES['profile_image']['name'];
						$photoName=str_replace(" ","_",$photoName1);
						$name=$user_id;
						if($row['user_image']!='')
						{
							@unlink(DIR_PROFILE_IMAGES.$row['user_image']);
						}
						move_uploaded_file($_FILES['profile_image']['tmp_name'],DIR_PROFILE_IMAGES.$name.'_'.$photoName);
						$newname=$name.'_'.$photoName;
						mysql_query("UPDATE `toon_users` SET `user_image`='$newname' WHERE `user_id`='$user_id'");
					}
					else
					{
						$size_error='Please select an image less than 10 MB';
						$shoform=true;
					}
				}
				else
				{
					$type_error='please select an image file';
					$shoform=true;
				}
			}
		}else
		{	
			$row[user_email]=$email;
			$error="email already exists";
		}
	}
	
	
	if($getuserDetails['utype_id']==2)
		{
		include (DIR_INCLUDES.'artist_header.php');
		}
		else
		{
		include (DIR_INCLUDES.'header.php');
		}
?> 
<script language="javascript" type="text/javascript">
function validate()
{
	var ok=1;	
	hide();
	var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
	
	if(document.getElementById("email").value=="")
	{
		document.getElementById("email_div").style.display="block";
		ok=0;
	}
	else if (document.getElementById("email").value != "" && !filter.test(document.getElementById("email").value))
		{
			document.getElementById("div_in_emailid").style.display="block";
			ok=0;
		}
	
	if(document.getElementById("fname").value=="")
	{
		document.getElementById("fname_div").style.display="block";
		ok=0;
	}
	
	if(document.getElementById("lname").value=="")
	{
		document.getElementById("lname_div").style.display="block";
		ok=0;
	}
	
	if(document.getElementById("pass").value!=""&&document.getElementById("pass").value.length < 6)
	{
		document.getElementById("pass_length_div").style.display="block";
		ok=0;
	}
	else if((document.getElementById("repass").value!=(document.getElementById("pass").value)))
	{
		document.getElementById("repass_div").style.display="block";
		ok=0;
	}
	if(ok==0)
	{
		return false;
	}
	else
		return true;
}
function hide()
{
	
	document.getElementById("fname_div").style.display="none";
	document.getElementById("lname_div").style.display="none";
	document.getElementById("email_div").style.display="none";
	document.getElementById("pass_length_div").style.display="none";
	document.getElementById("repass_div").style.display="none";
	document.getElementById("div_in_emailid").style.display="none";
	
}
</script>
		<!--header ends-->
		<!--content starts-->
		<link href="styles/style.css" rel="stylesheet" type="text/css" />
		<form action="<?=$_SERVER['PHP_SELF'];?>" method="post" onsubmit="return validate();" enctype="multipart/form-data">
		<div id="content">
        <? if($shoform){?>
			<div class="height80"></div>
			<div align="left" style="width:60%;margin-left:180px;">
				<div align="left" style="text-align:left;" class="header_text">It's easy to change your Caricature Toons Profile below. Oh, and we love how our artists transform images into caricatures.</div>
			</div>
			<div style="height:20px;"></div>									
			<div>
				<div class="buy_now_curvepadding" style="margin-left:160px;background-repeat:no-repeat"><img src="images/white_curve_top_left.gif" /></div>
				<div class="buy_now_white_curve_top_middle_strip profile_sttings_whiteCurve_middle_strip"></div>
				<div><img src="images/white_curve_top_right.gif" /></div>				
				<div class="price_white_curve_middle_border profile_sttings_middle_content" style="clear:both;">
					<div class="profile_sttings_img"><img src="images/change_profile.gif"  border="0" alt="change profile and settings" title="Change profile and setting"/></div>
                    <div>
                     <div class="div_text" align="center"><?=$error?><?=$size_error?><?=$type_error?></div>
                      <div id="fname_div" style="display:none" class="div_text"align="center">*Please enter firstname</div>
                      <div id="lname_div" style="display:none" class="div_text"align="center">*Please enter lastname</div>
                      <div id="email_div" style="display:none" class="div_text"align="center">*Please enter your email</div>
                      <div id="div_in_emailid" style="display:none" class="div_text"align="center">*Invalid Email</div>
                      <div id="pass_length_div" style="display:none" class="div_text"align="center">*Please enter a valid password</div>
                      <div id="repass_div" style="display:none" class="div_text"align="center">*Password mismatch</div>
                      
                    </div>
					<div>
						<div class="text_blue profile_sttings_txt">Change Email:</div>
						<div><input type="text" name="email" id="email" value="<?=$row['user_email'];?>"/></div>
					</div>
					<div class="profile_sttings_content_top_padding">
						<div class="text_blue profile_sttings_txt">Change First Name:</div>
						<div><input type="text" name="fname" id="fname"value="<?=$row['user_fname'];?>" /></div>
					</div>
					<div class="profile_sttings_content_top_padding">
						<div class="text_blue profile_sttings_txt">Change Last Name:</div>
						<div><input type="text" name="lname" id="lname"value="<?=$row['user_lname'];?>" /></div>
					</div>
					<div class="profile_sttings_content_top_padding">
						<div  class="text_blue profile_sttings_txt">Change Password:</div>
						<div><input type="password" name="pass" id="pass" /></div>
					</div>
					<div class="profile_sttings_content_top_padding">
						<div  class="text_blue profile_sttings_txt">Re-enter Password</div>
						<div><input type="password" name="repass" id="repass"/></div>
					</div>
                    <?
                    if($getuserDetails['utype_id']==2)
					{
					?>
					<div class="profile_sttings_content_top_padding">
						<div  class="text_blue profile_sttings_txt">Description:</div>
						<div><textarea name="user_decription" id="user_decription" ><?=$row['user_description'];?></textarea></div>
					</div>			
					<?
                    }
					?>
                    <div class="profile_sttings_content_top_padding">
						<div  class="text_blue profile_sttings_txt">Upload Photo</div>
						<div>
						<?
						if($row['user_image']!='')
						{
                        ?>
                        <img src="<?='includes/imageProcess.php?image='.$row['user_image'].'&type=profile&size=73';?>" border="0" class="photo_border"/>
                        <?
						}
						?>
						</div>
					</div>
					<div class="profile_sttings_content_top_padding">
						<div class="text_blue profile_sttings_txt">&nbsp;</div>
						<div><input type="file" name="profile_image" id="profile_image"/></div>
					</div>                    
					<div class="clear_both">
						<div class="profile_sttings_update_btn"><input type="image" name="update"src="images/update.gif" border="0" alt="update" title="Update" /></a></div>
						<div class="profile_sttings_cancel_btn">
						<?
                    if($getuserDetails['utype_id']==2)
					{
					?>
						<a href="art-hm.php"><img src="images/cancel.gif" border="0" alt="cancel" title="Cancel" /></a>
					<? }else{?>
						<a href="my-caricature-toons.php"><img src="images/cancel.gif" border="0" alt="cancel" title="Cancel"/></a>
					<? }?></div>
					</div>
					<div class="clear_both">&nbsp;</div>
				</div>
				
				<div>
					<div class="buy_now_curvepadding profile_sttings_btm_curve"><img src="images/contact_btm_left_curve.gif" /></div>
					<div class="white_btm_middle_strip profile_sttings_whiteCurve_middle_strip"></div>
					<div class="curve_right_position"><img src="images/contact_btm_right_curve.gif" /></div>
				</div>
			</div>
			<div class="profile_btm_height">&nbsp;</div>
        <? }else{?>
			<div class="height80"></div>
          
            <div align="left" style="width:60%;margin-left:180px;text-align:left;" class="header_text">Your Caricature Toons Profile has been successfully updated.</div>
			<div style="height:20px;"></div>	
            <div>
				<div class="buy_now_curvepadding" style="margin-left:160px;"><img src="images/white_curve_top_left.gif" /></div>
				<div class="buy_now_white_curve_top_middle_strip profile_sttings_whiteCurve_middle_strip"></div>
				<div class="clear_right"><img src="images/white_curve_top_right.gif" /></div>							
				<div class="price_white_curve_middle_border" style="margin-left:160px;margin-right:194px;">
					<div style="padding-left:20px;height:100px;"><img src="images/successfully_updated_profile.gif" border="0" alt="successfully updated profile" title="Successfully updated profile"/></div>
					
					<div style="clear:both;">
						
						<div style="padding-left:20px;text-align:center">
						<? if($getuserDetails['utype_id']==3) {?>
						<a href="my-caricature-toons.php"><img src="images/return_to_my_stuff.gif" border="0" alt="return to my stuff" title="Return to my stuff" /></a>
						<? }else {?>
						<a href="art-hm.php"><img src="images/return_to_my_orders.gif" border="0" alt="return to my orders" title="Return to my orders" /></a>
						<? }?>
						</div>
					</div>
					<div style="clear:both">&nbsp;</div>
				</div>
				
				<div>
					<div class="buy_now_curvepadding" style="padding-left:140px;"><img src="images/contact_btm_left_curve.gif" /></div>
					<div class="white_btm_middle_strip profile_sttings_whiteCurve_middle_strip"></div>
					<div class="curve_right_position"><img src="images/contact_btm_right_curve.gif" /></div>
				</div>
			</div>
			<div class="successfully_updated_btm_height">&nbsp;</div>
	    <? }?>
		</div>
		</form>
		<!--content ends-->	
		<!--footer-->	
<? 
 if($getuserDetails['utype_id']==2)
{
include (DIR_INCLUDES.'artist_footer.php');
}
else
{
include (DIR_INCLUDES.'footer.php') ;
} ?>
