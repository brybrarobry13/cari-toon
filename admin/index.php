<?
include('includes/configuration.php');
if(isset($_REQUEST['signin']))
	{
		$uname=$_POST['uname'];
		$pass=md5($_POST['pass']);
		$q_login="select * from toon_users where user_email='$uname' and user_password='$pass' and utype_id=1";
		$r_login=mysql_num_rows(mysql_query($q_login));
		if($r_login)
		{
			$_SESSION['sess_admin']=1;
			header("Location:customers.php");
		}
		else
		{
			$error='INVALID LOGIN!';
		}
	
		
	}
include ('includes/header.php');
?>	
<script language="javascript" type="text/javascript" src="javascripts/login.js"></script>
<form method="post" onsubmit="return valid();">
<table cellpadding="0" cellspacing="10" border="0" width="97%" height="400px;">
 <tr>
 <td width="3%">&nbsp;</td>
  <td align="center">
    <table cellpadding="0" cellspacing="0" width="100%" class="table_border">
             <tr class="table_titlebar"><td class="main_heading" height="30">Login</td></tr>
             <tr><td height="40" colspan="4" align="center">
			 	<div class="no_details_msg" id="error"align="center"><? echo "$error";?></div>
            	  <div id="div_uname" style="display:none" class="no_details_msg">Please enter your email</div>
				  <div id="div_pass" style="display:none" class="no_details_msg">Please enter password</div>
             </td></tr>
             <tr>
             <td height="20" align="center">
                <table cellpadding="4" cellspacing="0">
                 <tr>
                  <td align="left">Email:</td>
                  <td align="left" ><input type="text" name="uname" id="uname" value=""/>
                  </td>
                </tr>
                 <tr>
                  <td align="left">Password:</td>
                  <td align="left"><input type="password" name="pass" id="pass"/>
                  </td>
                 </tr>
                  
                 <tr>
                      <td></td>
                      <td align="left"><input type="submit" value="Sign In" name="signin" /></td>
                    </tr>
                </table>
             </td>
            </tr>
             <tr><td height="40" colspan="4"></td></tr>		
			</table>
  </td>
 </tr>
</table>
<?	
	include("includes/footer.php");
?>