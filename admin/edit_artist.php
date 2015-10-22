<?      include('includes/configuration.php');
		include("../includes/functions/encryption.php");
		include('../includes/functions/orders.php');
		@$encrypt_obj = new AzDGCrypt(1074);
 		$user_id=$_REQUEST['user_id'];
 		
 		$del=$_REQUEST['del'];
	    if($del)
	    {	
	    	$row_photoname=mysql_fetch_assoc(mysql_query("SELECT `user_image` FROM `toon_users` WHERE `user_id`='$user_id'"));
			@unlink(DIR_PROFILE_IMAGES.$row_photoname['user_image']);
			$sql_delete="update `toon_users` set user_image='' WHERE `user_id`='$user_id'";
			mysql_query($sql_delete);
		}
		
		if($user_id!="")
		{
			$sql_artist="SELECT * FROM `toon_users` WHERE `user_id`='$user_id'";
			$rs_artist = mysql_query($sql_artist);
			$row_artist=mysql_fetch_assoc($rs_artist);
			$photo = $row_artist['user_image'];
		}
		
		$sql_styles="SELECT * FROM toon_artist_styles";
		$res_styles=mysql_query($sql_styles);
		
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
			$artist_state=$_POST["bill_state"];
			$artist_country=$_POST["bill_country"];
			$artist_city=$_POST["user_city"];
			$artist_status=$_POST["user_status"];
			$approval_status = $_POST['approval_status'];
			$artist_zipcode=$_POST["user_zipcode"];
			$artist_phone=$_POST["user_phone"];
			$artist_paypal_acc=$_POST["user_paypal_acc"];
			$artist_company=$_POST["user_company"];
			$artist_photo = $_FILES['artist_photo']['name'];
			$photoname_split = explode('.',$artist_photo);
			$artist_ext = $photoname_split[sizeof($photoname_split)-1];
			$allow_types = array("jpg","jpeg","gif","png");
			
			$sql="SELECT * FROM `toon_users` WHERE `user_email`='$artist_email' and `user_id`!='$user_id' and `user_delete`='0'";
			$rs = mysql_query($sql);
			$no_artist = mysql_num_rows($rs);
			if($no_artist)
			{
				$error = "Email already exists";
				$row_artist['user_fname']=$artist_fname;
				$row_artist['user_lname']=$artist_lname;
				$row_artist['user_email']=$artist_email;
				$row_artist['user_address1']=$artist_address1;
			}
			else
			{
					if($user_id)
					{
						$sql_update="UPDATE `toon_users` SET `user_fname`='$artist_fname',`user_lname`='$artist_lname',`user_email`='$artist_email',`user_password`='$artist_password',`user_address1`='$artist_address1',`user_description`='$artist_decription',`user_address2`='$artist_address2',`user_state`='$artist_state',`approval_status`='$approval_status',`user_country`='$artist_country',`user_city`='$artist_city',`user_status`='$artist_status',`user_zipcode`='$artist_zipcode',`user_phone`='$artist_phone',`user_paypal_acc`='$artist_paypal_acc',`user_company`='$artist_company' WHERE `user_id`='$user_id'";
						$update_promo=mysql_query($sql_update);
						
						mysql_query("DELETE FROM toon_artist_styles_selections WHERE artist_id=".$user_id);
						$msg='Updated Successfully!';
						
						if($row_artist['approval_status'] != $_POST['approval_status'])
						{
							$from=$_CONFIG[email_outgoing];
							$to= $artist_email;
							$subject='You are '.strtolower($_POST['approval_status']).' in www.caricaturetoons.com';
							if($_POST['approval_status'] == 'Denied')
							{
								$message="Dear $artist_fname,<br><br>Sorry to say that you are denied from Caricaturetoons site.<br>";
								if(!empty($_POST['reason']))
								{
									$message.="Reason for your denial is: ".$_POST['reason']."<br><br>";
								}									
							}
							else
							{
								$message="Dear $artist_fname,<br><br>Glad to inform you that you are approved as an artist in Caricaturetoons site<br><br>";
							}
							$message.="Life should always be fun!!!<br>The Captoon<br>www.Caricaturetoons.com<br>";
							$header  = "From:'".$_CONFIG[site_name]."'< $from >\n";
							$header .= "MIME-Verson: 1.1\n";
							$header .= "Content-type:text/html; charset=iso-8859-1\n";
							mail($to,$subject,$message,$header);			
						}
					}
					else
					{
						$sql_insert="INSERT INTO `toon_users`(`user_fname` ,`user_lname` ,`user_email` ,`user_password` ,`user_description` ,`user_address1` ,`user_address2` ,`user_state`,`user_country`,`user_city`,`user_status` ,`approval_status`,`user_zipcode` ,`user_phone` ,`user_paypal_acc` ,`user_company` ,`utype_id`,`user_joined`) VALUES ('$artist_fname', '$artist_lname', '$artist_email','$artist_password','$artist_decription', '$artist_address1', '$artist_address2', '$artist_state', '$artist_country', '$artist_city', '$artist_status', '$approval_status', '$artist_zipcode', '$artist_phone', '$artist_paypal_acc', '$artist_company', 2, NOW())";
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
					}
					
				if(($artist_photo && in_array($artist_ext,$allow_types)) || !$artist_photo)
				{
					if($artist_photo)
					{	
						$imagename = $_FILES['artist_photo']['name'];
						$photoName=str_replace(" ","_",$imagename);
						$newname=$user_id.'_'.$photoName;
						move_uploaded_file($_FILES['artist_photo']['tmp_name'],DIR_PROFILE_IMAGES.$user_id.'_'.$photoName);
						mysql_query("UPDATE `toon_users` SET `user_image`='$newname' WHERE `user_id`='$user_id'");								
					}
			   } 
			   else 
			   {
				   $error = "Photo format not supported";
			   }
			   
				while($row_styles = mysql_fetch_array($res_styles))
				{
					if(isset($_POST['style_'.$row_styles['style_id']]))
					{
						$sql_style_update="INSERT INTO toon_artist_styles_selections ( artist_id , style_id) VALUES ( '".$user_id."','".$_POST['style_'.$row_styles['style_id']]."') ";
						mysql_query($sql_style_update);
					}
				}
				header("Location:manage_artists.php");
			}
		}			

		include ('includes/header.php');
?>
<script>
	var new_user=0;
	function country(slect,set)
	{
		if(document.getElementById(slect).selectedIndex!=1 )
			{
				document.getElementById(set).selectedIndex=1;
			}
			
	}
	function confirmation()
	{
		if(confirm("Do you really want to delete?"))
		{
			return true;
		}
		return false;	
	}
	function set_reaon(val)
	{
		if(val == 'Denied')
		{
			document.getElementById("reason").style.display="table-row";
		}
		else
		{
			document.getElementById("reason").style.display="none";
		}
	}
</script>
<script src="javascripts/billing_information.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="javascripts/artist.js"></script>
<script language="javascript" type="text/javascript" src="javascripts/datechooser.js"></script>
<script language="javascript" type="text/javascript" src="javascripts/date-functions.js"></script>
<link rel="stylesheet" href="styles/datechooser.css" type="text/css" />
<form action="edit_artist.php" method="post" onsubmit="return valid()" enctype="multipart/form-data">
  <table cellpadding="0" cellspacing="10" border="0" width="97%">
    <tr>
      <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
      <td align="center">
      <table cellpadding="0" cellspacing="0" width="100%" class="table_border" border="0">
          <tr class="table_titlebar">
            <td class="main_heading" height="30" colspan="4">Manage Artist</td>
          </tr>
          <tr>
		  <td height="40px;"></td>
		 </tr>
		  <tr>
            <td width="1%">&nbsp;</td>
            <td width="98%" align="center" valign="top">
            <table cellpadding="5" cellspacing="0" border="0" width="80%" class="table_border">
                <tr>
				<td colspan="2" align="center">
                <div id="error" class="no_details_msg"><? echo "$error";?></div>	
                <div id="fname_div" style="display:none" class="no_details_msg">Enter the First name</div>
                <div id="lname_div" style="display:none" class="no_details_msg">Enter the Last name</div>
                <div id="email_div" style="display:none" class="no_details_msg">Enter the Email id</div>
                <div id="email1_div" style="display:none" class="no_details_msg">Enter the Correct Email id</div>
                <div id="password_div" style="display:none" class="no_details_msg">Enter the Password</div>
                <div id="decription_div" style="display:none" class="no_details_msg">Enter the Description</div>
                </td>
                </tr>
				<tr>
                  <td width="47%" align="left" class="table_details">First Name&nbsp;:*</td>
                  <td width="53%" align="left"><input type="text" name="user_fname" id="user_fname" value="<?=$row_artist['user_fname']?>" /></td>
                </tr>
                <tr>
                  <td align="left" class="table_details">Last Name&nbsp;:*</td>
                  <td align="left"><input type="text" name="user_lname" id="user_lname" value="<?=$row_artist['user_lname']?>" /></td>
                </tr>
                <tr>
                  <td align="left" class="table_details">Email&nbsp;:*</td>
                  <td align="left" ><input type="text" name="user_email" id="user_email" value="<?=$row_artist['user_email']?>" /></td>
                </tr>
				<? if(!$user_id) {
				?><script>var new_user=1;</script>
                <? }?>
				<tr>
                  <td align="left" class="table_details">Password&nbsp;:*</td>
                  <td align="left" ><input type="text" name="user_password" id="user_password" value="<?=$encrypt_obj->decrypt($row_artist['user_password'])?>" /></td>
                </tr>
				<tr>
                  <td align="left" class="table_details">Description&nbsp;:</td>
                  <td align="left" ><textarea name="user_decription" id="user_decription" ><?=$row_artist['user_description'];?></textarea></td>
                </tr>
				<tr>
                  <td align="left" class="table_details" valign="top">Address1&nbsp;:</td>
                  <td align="left"><textarea name="user_address1" id="user_address1" ><?=$row_artist['user_address1'];?></textarea></td>
                </tr>
                <tr>
                  <td align="left" class="table_details" valign="top">Address2&nbsp;:</td>
                  <td align="left"><textarea name="user_address2" id="user_address2" ><?=$row_artist['user_address2']?></textarea>
				 </td>
                </tr>
		 		 <tr>
                  <td align="left" class="table_details">Country&nbsp;:</td>
                  <td align="left"><?
					$countries=getoption_values('country');
					if($row_artist['user_country'] == '')$row_artist['user_country']='US';?>
					<select name="bill_country" id="bill_country" onChange="country1()" style="width:180px;">
					<? foreach($countries as $name=> $code)
					{?>
						<option value="<?=$name?>" <? if($name==$row_artist['user_country']) echo 'selected="selected"';?>><?=$code?></option>
					<? }?>
					</select>
				  </td>
                </tr>
                <tr>
                  <td align="left" class="table_details">State/Province&nbsp;:</td>
                  <td align="left" id="stat_div">
				    <? if($row_artist['user_country']!=US&&$row_artist['user_country']!=CA){?>
                    <input type="text" id="state" value="<?=$row_artist['user_state'];?>">
					<? } else {?>
					<? $states = getoption_values('state',NULL,$row_artist['user_country']); ?>
                    <select name="bill_state" id="bill_state" style="width:180px;"><option value="">--Select State--</option>
                    <? foreach($states as $key => $value)
                    {?>
                        <option value="<?=$key?>" <? if($key==$row_artist['user_state']) echo 'selected="selected"';?>><?=$value?></option>
                    <? } ?>
                    </select>
                    <? }?>
				  </td>
                </tr>
         
          <!--<tr>
                  <td align="left" class="table_details">State&nbsp;:</td>
                  <td align="left"> <? $stateprovince = getoption_values(state);?>
				    <select name="user_state" id="user_state" onchange="return country('user_state','user_country');">
  					<option value="">--Select--</option>
					<option value="other"<? if($row_artist['user_state']=='other'){?> selected="selected"<? }?>>Non US State</option>
					<? foreach($stateprovince as $key=>$value)	{?>
					<option value="<?=$key?>" <? if($key==$row_artist['user_state'])echo 'selected="selected"'; ?>><? echo $value; ?></option>
					<? }?>
					</select>
					
						</td>
					</tr>-->
               
          <!--<tr>
                  <td align="left" class="table_details">Country&nbsp;:</td>
                  <td align="left"><? $countryprovince = getoption_values(country);?>
                    <select name="user_country" id="user_country" style="width:142px;" onchange="return country('user_country','user_state');">
                      <option value="">--Select--</option>
                      <? foreach($countryprovince as $key=>$value)	{?>
                      <option value="<?=$key?>" <? if($key==$row_artist['user_country'])echo 'selected="selected"'; ?>><? echo $value; ?></option>
                      <? }?>
                    </select>
				  </td>
                </tr>-->
		  <tr>
                  <td align="left" class="table_details">City&nbsp;:</td>
                  <td align="left"><input type="text" name="user_city" id="user_city" value="<?=$row_artist['user_city']?>" /></td>
                </tr>
                <tr>
                  <td align="left" class="table_details">Status&nbsp;:</td>
                  <td align="left"><select name="user_status">
                      <option value="Inactive" <? if($row_artist['user_status']==Inactive) {?> selected<? } ?>> Inactive</option>
                      <option value="Active" <? if($row_artist['user_status']==Active) {?> selected<? } ?>> Active</option>
                    </select></td>
                </tr>
				<tr>
                  <td align="left" class="table_details">Approval Status&nbsp;:</td>
                  <td align="left"><select name="approval_status" onchange="set_reaon(this.value)">
                      <option value="Denied" <? if($row_artist['approval_status']=='Denied') {?> selected<? } ?>>Denied</option>
                      <option value="Approved" <? if($row_artist['approval_status']=='Approved') {?> selected<? } ?>>Approved</option>
                    </select>
				  </td>
                </tr>
				<tr id="reason" style="display:none" >
					<td class="table_details">Reason for Denial&nbsp;:</td>
					<td><textarea name="reason" rows="3"></textarea></td>
				</tr>
				<tr>
                  <td align="left" class="table_details">Zip/Postal Code&nbsp;:</td>
                  <td align="left"><input type="text" name="user_zipcode" id="user_zipcode" value="<? if($row_artist['user_zipcode']!=0) { echo $value=$row_artist['user_zipcode']; } else { echo $value='';}?>" /></td>
                </tr>
                <tr>
                  <td align="left" class="table_details">Phone&nbsp;:</td>
                  <td align="left"><input type="text" name="user_phone" id="user_phone" value="<?=$row_artist['user_phone']?>" /></td>
                </tr>
                <tr>
                  <td align="left" class="table_details">Company Name&nbsp;:</td>
                  <td align="left"><input type="text" name="user_company" id="user_company" value="<?=$row_artist['user_company']?>"/></td>
                </tr>                
                <tr>
                  <td align="left" class="table_details">Paypal Account&nbsp;:</td>
                  <td align="left"><input type="text" name="user_paypal_acc" id="user_paypal_acc" value="<?=$row_artist['user_paypal_acc']?>" /></td>
                </tr>    
                <tr>
                  <td align="left" class="table_details">Upload Photo&nbsp;:</td>
				  <? if($photo){?>
                        <td align="left"> <img src="<?='../includes/imageProcess.php?image='.$row_artist['user_image'].'&type=profile&size=73';?>" border="0"  class="photo_border"/>
                        <a href="edit_artist.php?del=1&&user_id=<?=$row_artist['user_id'];?>" onclick="return confirmation();"><img src="images/delete.gif" border="0" width="12" /></a>
                        </td>
                    <? } else { ?>
                    <td align="left"> <input type="file" name="artist_photo" id="artist_photo"/> </td>
                    <? } ?>
				</tr>
                <tr>
                  <td align="left" class="table_details">Artist Style(s)&nbsp;:</td>
                  <td align="left" class="table_details">
				  <?php
				  while($row_styles=mysql_fetch_assoc($res_styles))
				  {?>
				  <input type="checkbox" name="style_<?=$row_styles['style_id']?>" value="<?=$row_styles['style_id']?>"
				  <?php
				    $sql_styles_sel="SELECT * FROM toon_artist_styles_selections WHERE artist_id=".$user_id." AND style_id=".$row_styles['style_id'];
					$res_styles_sel=mysql_query($sql_styles_sel);
					if(mysql_num_rows($res_styles_sel) != 0)
					{
					?>
					checked="checked"
					<?php
				  	}
				  	?> /> 
				  <?php
				  	echo $row_styles['style_name'].'<br>';
				  }
				  ?>	
				  </td>
                </tr>    
				<tr height="20">
                  <td align="left" class="table_details" colspan="3">Sample Images :</td>
                </tr>
				<?php 
				$sql="SELECT * FROM `toon_sample_images` WHERE `user_id`='$user_id'";
			    $rs = mysql_query($sql);
			    $row=mysql_fetch_assoc($rs);
				if($row['sample_image1']){?>	
                <tr>
                	<td colspan="2" style="padding-left:15px;"> 
                    	<table cellpadding="0" cellspacing="0" width="100%" border="0">        		
                            <tr>
                                <td width="33%"><img src="<?='../includes/imageProcess.php?image='.$row['sample_image1'].'&type=sample_image&size=150';?>" border="0"  class="photo_border"/></td>
                                <td width="34%"><? if($row['sample_image2']){?><img src="<?='../includes/imageProcess.php?image='.$row['sample_image2'].'&type=sample_image&size=150';?>" border="0"  class="photo_border"/> <? } ?></td>
                                <td width="33%"><? if($row['sample_image3']){?><img src="<?='../includes/imageProcess.php?image='.$row['sample_image3'].'&type=sample_image&size=150';?>" border="0"  class="photo_border"/><? } ?></td>
                            </tr>	
						</table>
                    </td>
                </tr>                       
				<? } ?>
                <tr><td height="20"></td></tr>
				<tr height="50">
                  <td><input type="hidden" name="user_id" value="<?=$row_artist['user_id'];?>" ></td>
                  <td><input type="submit" name="submit" value=<? if($user_id){?>"Update" <? }else{?>"Submit"<? }?> /></td>
                </tr>
            </table></td>
            <td width="1%">&nbsp;</td>
          </tr>
          <tr>
            <td height="40" colspan="4"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?	include("includes/footer.php");?>