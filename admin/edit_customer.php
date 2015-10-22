<? include('includes/configuration.php');
	$user_id =$_REQUEST['user_id'];
	
	$del=$_REQUEST['del'];
	if($del)
	{	
		$row_photoname=mysql_fetch_assoc(mysql_query("SELECT `user_image` FROM `toon_users` WHERE `user_id`='$user_id'"));
		@unlink(DIR_PROFILE_IMAGES.$row_photoname['user_image']);
		$sql_delete="update `toon_users` set user_image='' WHERE `user_id`='$user_id'";
		mysql_query($sql_delete);
	}
		
	if(isset($_POST['submit']))
	{
		$user_id =$_POST['user_id'];
		$fname=$_POST['user_fname'];
		$lname=$_POST['user_lname'];
		$email=$_POST['user_email'];
		$address1=$_POST['user_address1'];
		$address2=$_POST['user_address2'];
		$city=$_POST['user_city'];
		$zipcode=$_POST['user_zipcode'];
		$country=$_POST['user_country'];
		$status=$_POST['user_status'];
		$state=$_POST['user_state'];
		$sql_update="UPDATE `toon_users` set `user_fname`='$fname',`user_lname`='$lname',`user_email`='$email',`user_address1`='$address1',`user_address2`='$address2',`user_city`='$city',`user_zipcode`='$zipcode',`user_state`='$state',`user_country`='$country',`user_status`='$status' WHERE `user_id`='$user_id'";
		$rs_content=mysql_query($sql_update);
		
		$customer_photo = $_FILES['customer_photo']['name'];
		if($customer_photo!='')
		{
			$photoname_split = explode('.',$customer_photo);
			$customer_ext = $photoname_split[sizeof($photoname_split)-1];
			$allow_types = array("jpg","jpeg","gif","png");
			if(($customer_photo && in_array($customer_ext,$allow_types)))
			{
				$imagename = $_FILES['customer_photo']['name'];
				$photoName=str_replace(" ","_",$imagename);
				$newname=$user_id.'_'.$photoName;
				move_uploaded_file($_FILES['customer_photo']['tmp_name'],DIR_PROFILE_IMAGES.$user_id.'_'.$photoName);
				mysql_query("UPDATE `toon_users` SET `user_image`='$newname' WHERE `user_id`='$user_id'");								
			} 
			else 
			{
				$error = "Photo format not supported";
			}
		}
		header("Location:customers.php");
	}
	
	if($user_id !='')
	{
		$sql_content="SELECT * FROM `toon_users` WHERE `user_id`='$user_id'";
		$rs_content = mysql_query($sql_content);
		$content=mysql_fetch_assoc($rs_content);
		$photo = $content['user_image'];
	}
	include ('includes/header.php');
?>
<script>
function valid()
{
	clear();
	var valid=true;
	if(document.getElementById("user_fname").value=="")
	{      
			document.getElementById("fname_div").style.display="block";
			valid=false;
	}
	if(document.getElementById("user_lname").value=="")
	{      
			document.getElementById("lname_div").style.display="block";
			valid=false;
	}
	if(document.getElementById("user_email").value=="")
	{
			document.getElementById("email_div").style.display="block";
			valid=false;
	}
	 if(document.getElementById("user_email").value!="")
	{
			checkEmail = document.getElementById("user_email").value;
	if ((checkEmail.indexOf('@') < 0) || ((checkEmail.charAt(checkEmail.length-4) != '.') && (checkEmail.charAt(checkEmail.length-3) != '.')))
	{
			document.getElementById("email1_div").style.display="block";
			valid=false;
	}
	}

	return valid;
}
function clear()
{
	document.getElementById("fname_div").style.display="none";
	document.getElementById("lname_div").style.display="none";
	document.getElementById("email_div").style.display="none";
	document.getElementById("email1_div").style.display="none";
}
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
	
</script>
<form action="edit_customer.php" method="post"  enctype="multipart/form-data">
  <table cellpadding="0" cellspacing="10" border="0" width="97%">
    <tr>
      <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
      <td align="center"><table cellpadding="0" cellspacing="0" width="100%" class="table_border">
          <tr class="table_titlebar">
            <td class="main_heading" height="30" colspan="4">Manage Customer</td>
          </tr>
          <tr>
            <td height="40px;"></td>
          </tr>
          <tr>
            <td width="1%">&nbsp;</td>
            <td width="98%" align="center" valign="top"><table cellpadding="5" cellspacing="0" width="60%" class="table_border">
                <tr>
				<td colspan="2">&nbsp;</td>
				<td><div id="fname_div" style="display:none" class="no_details_msg">Enter the First name</div>
			<div id="lname_div" style="display:none" class="no_details_msg">Enter the Last name</div>
			<div id="email_div" style="display:none" class="no_details_msg">Enter the Email id</div>
			<div id="email1_div" style="display:none" class="no_details_msg">Enter the Correct Email id</div></td></tr>
				<tr>
				<td width="14%">&nbsp;</td>
                  <td width="33%" align="left" class="table_details">First Name&nbsp;:*</td>
                  <td width="53%" align="left"><input type="text" name="user_fname" id="user_fname" value="<?=$content['user_fname']?>" /></td>
                </tr>
                <tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">Last Name&nbsp;:*</td>
                  <td align="left"><input type="text" name="user_lname" id="user_lname" value="<?=$content['user_lname']?>" />
				</td>
                </tr>
                <tr><td>&nbsp;</td>
                  <td align="left" class="table_details">Email&nbsp;:*</td>
                  <td align="left" ><input type="text" name="user_email" id="user_email" value="<?=$content['user_email']?>" />
				   </td>
                </tr>
				<tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">Address1&nbsp;:</td>
                  <td align="left"><textarea name="user_address1" id="user_address1" ><?=$content['user_address1']?></textarea></td>
                </tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">Address2&nbsp;:</td>
                  <td align="left"><textarea name="user_address2" id="user_address2" ><?=$content['user_address2']?></textarea>
				 
				  </td>
                </tr>
				
					<tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">State/Province&nbsp;:</td>
                  <td align="left"> <? $stateprovince = getoption_values(state);?>
				    <select name="user_state" id="user_state" onchange="return country('user_state','user_country');">
  					<option value="">--Select--</option>
					<option value="other"<? if($content['user_state']=='other')echo 'selected="selected"'; ?>>Non US State</option>
					<? foreach($stateprovince as $key=>$value)	{?>
					<option value="<?=$key?>" <? if($key==$content['user_state'])echo 'selected="selected"'; ?>><? echo $value; ?></option>
					<? }?>
					</select>
					
						</td>
					</tr>
					<tr>
                  <td>&nbsp;</td>
                  <td align="left" class="table_details">Country&nbsp;:</td>
                  <td align="left"><? $countryprovince = getoption_values(country);?>
                    <select name="user_country" id="user_country" style="width:142px;" onchange="return country('user_country','user_state');">
                      <option value="">--Select--</option>
                      <? foreach($countryprovince as $key=>$value)	{?>
                      <option value="<?=$key?>" <? if($key==$content['user_country'])echo 'selected="selected"'; ?>><? echo $value; ?></option>
                      <? }?>
                    </select>
				  </td>
                </tr>
				  <tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">City&nbsp;:</td>
                  <td align="left"><input type="text" name="user_city" id="user_city" value="<?=$content['user_city']?>" />
				   
				  </td>
                </tr>
                <tr><td>&nbsp;</td>
                  <td align="left" class="table_details">Status&nbsp;:</td>
                  <td align="left"><select name="user_status">
                      <option value="Inactive" <? if($content['user_status']==Inactive) {?> selected<? } ?>> Inactive</option>
                      <option value="Active" <? if($content['user_status']==Active) {?> selected<? } ?>> Active</option>
                    </select></td>
                </tr>
				  <tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">Zip/Postal Code&nbsp;:</td>
                  <td align="left"><input type="text" name="user_zipcode" id="user_zipcode" value="<? if($content['user_zipcode']!=0) { echo $value=$content['user_zipcode'];}else { echo $value='';} ?>" /></td>
                </tr>
				 <!--<tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">Country&nbsp;:</td>
                  <td align="left"><input type="text" name="user_country" id="user_country" value="<? if($content['user_country']!=0) { echo $value=$content['user_country'];} else { echo $value='';}?>" /> </td>
                </tr>-->
				
				<tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">Upload Photo&nbsp;:</td>
				  <? if($photo){?>
                        <td align="left"> <img src="<?='../includes/imageProcess.php?image='.$content['user_image'].'&type=profile&size=73';?>" border="0"  class="photo_border"/>
                        <a href="edit_customer.php?del=1&&user_id=<?=$content['user_id'];?>" onclick="return confirmation();"><img src="images/delete.gif" border="0" width="12" /></a>
                        </td>
                    <? } else { ?>
                    <td align="left"> <input type="file" name="customer_photo" id="customer_photo"/> </td>
                    <? } ?>
				</tr>
                
                <tr height="50">
                  <td align="center" colspan="2"><input type="hidden" name="user_id" value="<?=$content['user_id'];?>" ></td>
                    <td><input type="submit" name="submit" value="update" id="submit" onclick="return valid()"/>
                  </td>
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
