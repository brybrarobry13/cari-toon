<?  include("includes/configuration.php");
	$title_text = "Artist Application Page:";
	include (DIR_INCLUDES.'header.php'); 
	include_once(DIR_FUNCTIONS."static.php");
	$static_code='PAGE_ARTAPP';

	include("includes/functions/options.php");
	include("includes/functions/encryption.php");
	include('includes/functions/orders.php');
	$static=get_staticdetails($static_code);
	
	@$encrypt_obj = new AzDGCrypt(1074);
	$sql_styles="SELECT * FROM toon_artist_styles";
	$res_styles=mysql_query($sql_styles);
	
	$states = getoption_values('state',NULL,"USA");
	
	if(isset($_POST['submit']))
	{
		$artist_fname=$_POST["user_fname"];
		$artist_lname=$_POST["user_lname"];
		$artist_email=$_POST["user_email"];
		$password=$_POST['user_password'];
		$artist_password=$encrypt_obj->crypt($_POST['user_password']);
		$artist_decription=addslashes($_POST["user_decription"]);
		$artist_address1=addslashes($_POST["user_address1"]);
		$artist_address2=addslashes($_POST["user_address2"]);
		$artist_country=$_POST["bill_country"];
		if($_POST['bill_country']!='USA')
		{
			$artist_state=$_POST["state"];
		}
		else
		{
			$artist_state=$_POST["bill_state_select"];	
		}
		$artist_city=$_POST["user_city"];
		$artist_zipcode=$_POST["user_zipcode"];
		$artist_phone=$_POST["user_phone"];
		$artist_paypal_acc=$_POST["user_paypal_acc"];
		$artist_company=$_POST["user_company"];
		$sample_photo = $_FILES['sample_photo']['name'];
	    $sample_photo2 = $_FILES['sample_photo2']['name'];
		$sample_photo3 = $_FILES['sample_photo3']['name'];
		$photoname_split = explode('.',$sample_photo);
		$artist_ext = $photoname_split[sizeof($photoname_split)-1];
		$allow_types = array("jpg","jpeg","gif","png");
	    $path_info2 = pathinfo($sample_photo2);
        $ext2=$path_info2['extension'];
	    $path_info3 = pathinfo($sample_photo3);
        $ext3=$path_info3['extension'];
		$sql="SELECT * FROM `toon_users` WHERE `user_email`='$artist_email' and `user_id`!='$user_id' and `user_delete`='0'";
		$rs = mysql_query($sql);
		$no_artist = mysql_num_rows($rs);
		$err = false;
		if($no_artist)
		{
			$error = "Email already exists";
			$err = true;
		}
		if($_SESSION["captcha"]!=$_POST["captcha"])
		{
			$error = "Captcha entered is wrong !";
			$err = true;
		}
		if(!$err)
		{
			if($user_id)
			{
				$sql_update="UPDATE `toon_users` SET `user_fname`='$artist_fname', `user_lname`='$artist_lname', `user_email`='$artist_email', `user_password`='$artist_password', `user_address1`='$artist_address1', `user_description`='$artist_decription', `user_address2`='$artist_address2', `user_state`='$artist_state', `user_country`='$artist_country', `user_city`='$artist_city', `user_status`='Inactive', `user_zipcode`='$artist_zipcode', `user_phone`='$artist_phone', `user_paypal_acc`='$artist_paypal_acc', `user_company`='$artist_company' WHERE `user_id`='$user_id'";	
				$update_promo=mysql_query($sql_update);
				mysql_query("DELETE FROM toon_artist_styles_selections WHERE artist_id=".$user_id);
				$msg='Updated Successfully!';
			}
			else
			{
				$sql_insert="INSERT INTO `toon_users` ( `user_fname`, `user_lname`, `user_email`, `user_password`, `user_description`, `user_address1`, `user_address2`, `user_state`, `user_country`, `user_city`, `user_status`, `approval_status`, `artist_gallery_status`, `user_zipcode`, `user_phone`, `user_paypal_acc`, `user_company`, `utype_id`, `user_joined` ) VALUES ('$artist_fname', '$artist_lname', '$artist_email','$artist_password','$artist_decription', '$artist_address1', '$artist_address2', '$artist_state', '$artist_country', '$artist_city', 'Inactive', 'New', 'Inactive', '$artist_zipcode', '$artist_phone', '$artist_paypal_acc', '$artist_company',2,NOW())";	
				mysql_query($sql_insert);
				$user_id=mysql_insert_id();
				$from=$_CONFIG[email_outgoing];
				$to= $artist_email;
				$subject='Welcome Aboard';
				$message="<table><tr><td>Hi ".$artist_fname." ".$artist_lname.",<br /><br />
				You are now officially joined Caricature Toons as an Artist. <br /><br />
				Your email ID and password is as follows:<br /><br />
				Email ID: ".$artist_email."<br />
				Password: ".$password."<br /><br />
				You can view your Artist Admin Dashboard by logging in at www.caricaturetoons.com<br /><br />
				<span style='text-decoration:underline'>Activate Your Account</span><br />
				<b>IMPORTANT:</b> Your account has been set up but is <b>NOT</b> yet online. The first thing you need to do is upload sample images to your Gallery. Once you’ve done that, please contact us at headtoon@caricaturetoons.com and we will activate your account. Customers will then be able to view your samples and place orders.<br /><br />
			
				<span style='text-decoration:underline'>Video Tutorials</span><br />
				Below are the links to the following video tutorials. <br /><br />
			
				Artist Tutorial Ð How to set up your Gallery<br />
				http://www.youtube.com/watch?v=ohlhky7_zuY <br /><br />
			
				Artist Tutorial Ð How to process your Orders<br />
				http://www.youtube.com/watch?v=H-SRmOgIKdQ <br /><br />
			
				Customer Tutorial Ð How to Create Your Toon<br />
				http://www.youtube.com/watch?v=XAAiArRLsb4 <br /><br />
								
				<span style='text-decoration:underline'>Your Orders</span><br />
				You will be notified by email when you receive an order, but it’s never a bad idea to check your Artist Admin Dashboard daily. <br /><br />
			
				When you get an order, you need to click on it and change the order status button from “paid” to “work in process”. All the photo’s and information you require will be included.<br /><br />
			
				If for any reason you have a question for the customer, you can communicate directly to the customer through the “my orders” section by clicking on the envelope icon.<br /><br /> 
			
				When the Toon is ready, you can upload through the “View” link. <b> DO NOT </b> upload Toon proofs through the communications envelope.<br /><br />
			
				<b>AS AN ORGANIZATIONAL REQUIREMENT, ALL CUSTOMER COMMUNICATIONS MUST TAKE PLACE THROUGH THIS METHOD; PLEASE DO NOT EMAIL THE CUSTOMER DIRECTLY USING YOUR EMAIL ACCOUNT.</b><br /><br />
			
				If at anytime you have questions or require assistance, please email us at ".$_CONFIG['email_contact_us']."<br /><br />
			
				Life should always be fun!!!<br /><br />
			
				The Captoon<br /><br />
				www.caricaturetoons.com<br /><br />
				</td></tr></table>";
				$header="From:'".$_CONFIG[site_name]."'< $from >\n";
				$header .= "MIME-Verson: 1.1\n";
				$header .= "Content-type:text/html; charset=iso-8859-1\n";
				mail($to,$subject,$message,$header);
				
				$from=$_CONFIG[email_outgoing];
				$to= $artist_email;
				$toadmin = $_CONFIG[email_admin];
				$subject='New Artist Joined';
				$message="A new artist has joined today in www.caricaturetoons.com.<br><br><b>Artist Details :</b><br>
				Name : ".$artist_fname." ".$artist_lname."<br>
				Email Id : ".$artist_email."<br>
				User Id : ".$user_id."<br>
				Please find more details in the Administrator Panel of wwww.caricaturetoons.com";
				mail($to,$subject,$message,$header);
				mail($toadmin,$subject,$message,$header);
							
			}
			if(($sample_photo && in_array($artist_ext,$allow_types)) || !$sample_photo)
			{
				if($sample_photo)
				{	
					$imagename = $_FILES['sample_photo']['name'];
					$photoName=str_replace(" ","_",$imagename);
					$sample_image1=$user_id.'_1_'.$photoName;
					move_uploaded_file($_FILES['sample_photo']['tmp_name'],DIR_SAMPLE_IMAGES.$sample_image1);
				}
		    } 
		    else 
		    {
			    $error = "Photo format not supported";
		    }
			if(($sample_photo2 && in_array($ext2,$allow_types)) || !$sample_photo2)
			{
				if($sample_photo2)
				{	
					$imagename2 = $_FILES['sample_photo2']['name'];
					$photoName2=str_replace(" ","_",$imagename2);
					$sample_image2=$user_id.'_2_'.$photoName2;
					move_uploaded_file($_FILES['sample_photo2']['tmp_name'],DIR_SAMPLE_IMAGES.$sample_image2);
				}
		    }
			if(($sample_photo3 && in_array($ext3,$allow_types)) || !$sample_photo3)
			{
				if($sample_photo3)
				{	
					$imagename3 = $_FILES['sample_photo3']['name'];
					$photoName3=str_replace(" ","_",$imagename3);
					$sample_image3=$user_id.'_3_'.$photoName3;
					move_uploaded_file($_FILES['sample_photo3']['tmp_name'],DIR_SAMPLE_IMAGES.$sample_image3);
				}
			 }
			if($sample_photo)
			 {
			 $img_qry="INSERT INTO toon_sample_images( user_id , sample_image1, sample_image2, sample_image3 ) VALUES( '$user_id', '$sample_image1', '$sample_image2', '$sample_image3' )";
			 mysql_query($img_qry);
			 }
			 
			 
			 
			while($row_styles = mysql_fetch_array($res_styles))
			{
				if(isset($_POST['style_'.$row_styles['style_id']]))
				{
				    $sql_style_update="INSERT INTO toon_artist_styles_selections ( artist_id , style_id ) VALUES ( '".$user_id."','".$_POST['style_'.$row_styles['style_id']]."') ";
					mysql_query($sql_style_update);
				}
			}
			$succ = "Congratulations,Your registration is completed! Wait for approval from the administrator.";					
		}
	}	
?>
<!--header ends-->
<!--content starts-->
<script language="javascript" type="text/javascript" src="javascripts/artist.js"></script>
<link href="styles/style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
function validate()
{
	var result = valid();
	document.getElementById("captcha_div").style.display="none";
	if(document.getElementById("captcha").value =="")
	{
		document.getElementById("captcha_div").style.display="block";
		result = false;
	}
	return result;
}

function check_us(val)
{
	if(val == "USA")
	{
		document.getElementById("state").style.display="none";
		document.getElementById("bill_state_select").style.display="block";
	}
	else
	{
		document.getElementById("state").style.display="block";
		document.getElementById("bill_state_select").style.display="none";
	}
}

function check_count(id)
{
	if(document.getElementById(id).checked == true)
	{
		if(document.getElementById("ch_count").value == 3)
		{
			alert("Can pick up to 3 styles. You have already selected 3 styles.");
			return false;
		}
		document.getElementById("ch_count").value++;
	}
	else
	{
		document.getElementById("ch_count").value--;
	}
	return true;
		
}
</script>
<div id="content">
  <div style="height:5px;"></div>
  <div>
    <div class="faq_top_curve"><img src="images/contact_top_left_curve.gif" /></div>
    <div class="buy_now_middlestrip faq_top_middlestrip_position"></div>
    <div class="float_left"><img src="images/contact_top_right_curve.gif" /></div>
    <div class="clear_right">&nbsp;</div>
    <div class="affliate_content_middle_strip faq_content_position">
		<?php if(!empty($succ))
		{?>
        	<div style="height:25px;"></div>
			<div class="text_blue" align="center"><?=$succ?></div>
            <div style="height:25px;"></div>
		<?php 
		}
		else
		{
		?>
      <div class="text_blue line_space" style="padding-left: 30px"><?php echo $static;?></div>
		
		<div align="center" style="padding-left: 100px; padding-right: 100px;">
		<form method="post" action="join-our-team.php" onsubmit="return valid()" enctype="multipart/form-data">
		<table cellpadding="5" cellspacing="0" width="50%" border="0" class="table_border">
			<tr>
			<td colspan="2" align="center">
			<div id="error" class="no_details_msg"><? echo "$error";?></div>	
			<div id="fname_div" style="display:none" class="no_details_msg">Enter the First name</div>
			<div id="lname_div" style="display:none" class="no_details_msg">Enter the Last name</div>
			<div id="email_div" style="display:none" class="no_details_msg">Enter the Email id</div>
			<div id="email1_div" style="display:none" class="no_details_msg">Enter the Correct Email id</div>
			<div id="password_div" style="display:none" class="no_details_msg">Enter the Password</div>
			<div id="address1_div" style="display:none" class="no_details_msg">Enter the Address</div>
            <div id="bill_country_div" style="display:none" class="no_details_msg">Enter the Country</div>
            <div id="bill_state_div" style="display:none" class="no_details_msg">Enter the State/Province</div>
            <div id="user_city_div" style="display:none" class="no_details_msg">Enter the City</div>
            <div id="user_zipcode_div" style="display:none" class="no_details_msg">Enter the Zipcode</div>
            <div id="user_phone_div" style="display:none" class="no_details_msg">Enter the Phone</div>
            <div id="user_paypal_acc_div" style="display:none" class="no_details_msg">Enter the Paypal Account</div>
            <div id="sample_photo_div" style="display:none" class="no_details_msg">Enter 3 Sample Photos</div>
            <div id="artist_style_div" style="display:none" class="no_details_msg">Enter 3 artist styles</div>
			<div id="captcha_div" style="display:none" class="no_details_msg">Enter the Captcha</div>
			</td>
			</tr>
				<tr>
                  <td align="left" class="text_blue" width="50%">First Name&nbsp;:<span style="color:#F00;">*</span></td>
                  <td align="left" width="50%"><input type="text" name="user_fname" id="user_fname" value="<?=$artist_fname?>" /></td>
                </tr>
                <tr>
                  <td align="left" class="text_blue">Last Name&nbsp;:<span style="color:#F00;">*</span></td>
                  <td align="left"><input type="text" name="user_lname" id="user_lname" value="<?=$artist_lname?>" />
				  
				  </td>
                </tr>
                <tr>
                  <td align="left" class="text_blue">Email&nbsp;:<span style="color:#F00;">*</span></td>
                  <td align="left" ><input type="text" name="user_email" id="user_email" value="<?=$artist_email?>" />
				  </td>
                </tr>
				<? if(!$user_id) {
				?><script>var new_user=1;</script>
                <? }?>
				<tr>
                  <td align="left" class="text_blue">Password&nbsp;:<span style="color:#F00;">*</span></td>
                  <td align="left" ><input type="text" name="user_password" id="user_password" value="" />
				  </td>
                </tr>
				<tr>
                  <td align="left" class="text_blue" valign="top">Address1&nbsp;:<span style="color:#F00;">*</span></td>
                  <td align="left"><textarea name="user_address1" id="user_address1" ><?=$artist_address1?></textarea></td>
                </tr>
				<tr>
                  <td align="left" class="text_blue" valign="top">Address2&nbsp;:</td>
                  <td align="left"><textarea name="user_address2" id="user_address2" ><?=$artist_address2?></textarea>
				 </td>
                </tr>
		 		<tr>
                  <td align="left" class="text_blue">Country&nbsp;:<span style="color:#F00;">*</span></td>
                  <td align="left">
				  <? $countries=getoption_values('country'); ?>
					<select name="bill_country" id="bill_country" onChange="check_us(this.value)" style="width:180px;">
					<option value="">Select Country</option>
					<? foreach($countries as $name=> $code)
					{?>
						<option value="<?=$name?>" <?php if($artist_country == $name) {?> selected="selected" <?php }?> ><?=$code?></option>
					<? }?>
					</select>
				  </td>
                </tr>
                <tr>
                  <td align="left" class="text_blue">State/Province&nbsp;:<span style="color:#F00;">*</span></td>
                  <td align="left" id="stat_div">
                  <? if($artist_state!='USA'){?>
                  <input type="text" name="state" id="state" value="<?=$artist_state;?>">
				  <? }?>
				  <select name="bill_state_select" id="bill_state_select" style="display:none;width:180px;">
                  <option value="">Select State/Province</option>
				  <?php 
				  foreach($states as $key => $value)
				  {?>
				  	<option value="<?=$value?>" <?php if($artist_state == $value) {?> selected="selected" <?php }?>><?=$value?></option>
				<?php }	?>	
				  </select>
				  </td>
                </tr>
		        <tr>
                  <td align="left" class="text_blue">City&nbsp;:<span style="color:#F00;">*</span></td>
                  <td align="left"><input type="text" name="user_city" id="user_city" value="<?=$artist_city?>" /></td>
                </tr>
				<tr>
                  <td align="left" class="text_blue">Zip/Postal Code&nbsp;:<span style="color:#F00;">*</span></td>
                  <td align="left"><input type="text" name="user_zipcode" id="user_zipcode" value="<?=$artist_zipcode?>" /></td>
                </tr>
                <tr>
                  <td align="left" class="text_blue">Phone&nbsp;:<span style="color:#F00;">*</span></td>
                  <td align="left"><input type="text" name="user_phone" id="user_phone" value="<?=$artist_phone?>" /></td>
                </tr>
                <tr>
                  <td align="left" class="text_blue">Company Name&nbsp;:</td>
                  <td align="left"><input type="text" name="user_company" id="user_company" value="<?=$artist_company?>"/></td>
                </tr>                
                <tr>
                  <td align="left" class="text_blue">Paypal Account&nbsp;:<span style="color:#F00;">*</span></td>
                  <td align="left"><input type="text" name="user_paypal_acc" id="user_paypal_acc" value="<?=$artist_paypal_acc?>" /></td>
                </tr>    
                <tr>
                  <td align="left" class="text_blue">Upload Samples&nbsp;:<span style="color:#F00;">*</span></td>
                    <td align="left" class="text_blue"><input type="file" value="" name="sample_photo" id="sample_photo"/></td>
				</tr>
				<tr>
                  <td align="left" class="text_blue"></td>
                    <td align="left" class="text_blue"><input type="file" value="" name="sample_photo2" id="sample_photo2"/></td>
				</tr>
				<tr>
                  <td align="left" class="text_blue"></td>
                    <td align="left" class="text_blue"><input type="file" value="" name="sample_photo3" id="sample_photo3"/></td>
				</tr>
                <tr>
                  <td align="left" class="text_blue">Artist Style(s)&nbsp;:<span style="color:#F00;">*</span></td>
                  <td align="left" class="text_blue">
				  <?php
				  while($row_styles=mysql_fetch_assoc($res_styles))
				  {?>
				  <input type="checkbox" name="style_<?=$row_styles['style_id']?>"<?php if(isset($_POST['style_'.$row_styles['style_id']])){ ?> checked="checked" <?php }?> id="style_<?=$row_styles['style_id']?>" value="<?=$row_styles['style_id']?>" onClick="return check_count('style_<?=$row_styles['style_id']?>')"/> 
				  <?php
				  	echo $row_styles['style_name'].'<br>';
				  }
				  ?>	
				  	  <input type="hidden" name="ch_count" id="ch_count" value="0" />
				  </td>
                </tr>    
                <tr>
					<td align="left" class="text_blue">Enter the symbols&nbsp;:<span style="color:#F00;">*</span></td>
					<td align="left"><img src="captcha.php" alt="captcha image" width="75">&nbsp;&nbsp;<input type="text" name="captcha" id="captcha" size="7" maxlength="6" style="height:20px;vertical-align:top;" /></td>
				</tr>
				<tr height="50">
                  <td></td>
                    <td><input type="submit" name="submit" value="Submit"/>
                  </td>
                </tr>
				
            </table>
		</form>
		</div>
	<?php
	}
	?>	
		
    </div>
    <div class="faq_top_curve"><img src="images/contact_btm_left_curve.gif" /></div>
    <div class="contact_middle_strip_btm faq_btm_strip_position"></div>
    <div class="float_left"><img src="images/contact_btm_right_curve.gif" /></div>
    <div class="height_1 clear_both">&nbsp;</div>
  </div>
</div>
<!--content ends-->
<!--footer-->
<? include (DIR_INCLUDES.'footer.php') ?>
