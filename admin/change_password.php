<?
	include('includes/configuration.php');
	$showform = true;
	if(isset($_REQUEST['submit_x']))
	{	
		$user_password=md5($_POST['password']);
		$pass_query=mysql_query("SELECT `user_password` FROM `toon_users` where `utype_id` =1 ");
		$row=mysql_fetch_assoc($pass_query);
		$u_pass=$row['user_password'];
		if($u_pass==$user_password)
		{
			$new_password =md5($_POST['new_pass']);
			$password = $new_password;
			$update="UPDATE `toon_users` SET `user_password` ='$password' WHERE `utype_id`=1 ";
			mysql_query($update);
			$message="Your password has been changed successfully";
			if($update)
			{
            	$showform = false;
       		}
		}
		else 
		{	
			$error = "Current password was entered wrong.";
		}
		
	}		
		
	include ('includes/header.php');
?>
<script language="javascript" type="text/javascript" src="javascripts/change_password.js"></script>
<form method="post" onsubmit="return valid();">
  <table cellpadding="0" cellspacing="10" border="0" width="97%" height="400px;">
    <tr>
      <td width="3%" valign="top"><? include ("includes/leftnav.php");?></td>
      <td align="center" valign="top">
	  <?
		if($showform) 
		{
	  ?>
        <table cellpadding="0" cellspacing="0" width="100%" class="table_border">
          <tr class="table_titlebar">
            <td class="main_heading" height="30">Change Password</td>
          </tr>
          <tr>
            <td height="40" colspan="4" align="center" class="no_details_msg">
                <div id="error"><? echo "$error";?></div>
                <div id="password_div" style="display:none;">Enter current password</div>
                <div id="new_pass_div" style="display:none;">Enter new password</div>
                <div id="new_pass_length_div" style="display:none;">Enter a valid password</div>
                <div id="n_password_div" style="display:none;">Passwords not matching</div>
            </td>
          </tr>
          <tr>
            <td height="20" align="center"><table cellpadding="4" cellspacing="0">
                <tr>
                  <td align="left">Current password&nbsp;*&nbsp;:</td>
                  <td align="left" ><input type="password" name="password" id="password" />
                  </td>
                </tr>
                <tr>
                  <td align="left">New password&nbsp;*&nbsp;:<div class="valid_char">(At least six characters!)</div></td>
                  <td align="left"><input type="password" name="new_pass" id="new_pass" />
                  </td>
                </tr>
                <tr>
                  <td align="left">Re-type password&nbsp;*&nbsp;:</td>
                  <td align="left"><input type="password" name="re_pass" id="re_pass" />
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td align="left"><input type="image" src="images/submit.gif" name="submit" id="submit"/></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td height="40" colspan="4"></td>
          </tr>
        </table>
        <?
		} 
		else 
		{ 
		?>
        <table cellpadding="0" cellspacing="0" width="100%" class="table_border">
          <tr class="table_titlebar">
            <td class="main_heading" height="30">Change Password</td>
          </tr>
          <tr>
            <td height="200" align="center" class="no_details_msg"><p><div class="no_details_msg"><?=$message;?></div></p></td>
          </tr>
        </table>
        <? 
		}
		?>
      </td>
    </tr>
  </table>
</form>
<?	
	include("includes/footer.php");
?>
