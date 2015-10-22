<?
include("includes/configuration.php");
$form = false;
if(isset($_POST['submit']))
{
	$email_news=$_POST['email'];
	$fname_news=$_POST['fname'];
	$lname_news=$_POST['lname'];
	mysql_query("INSERT INTO `toon_newsletter`(`nltr_email`,`nltr_fname`,`nltr_lname`)VALUES('$email_news','$fname_news','$lname_news')");
	$apikey = 'd430e689849743713ddb3f23b2b96f80-us1';
	$listID = '89b8c40889';
	$url = sprintf('http://api.mailchimp.com/1.2/?method=listSubscribe&apikey=%s&id=%s&email_address=%s&merge_vars[FNAME]=%s&merge_vars[LNAME]=%s&merge_vars[OPTINIP]=%s&merge_vars[MMERGE1]=webdev_tutorials&double_optin=false&output=json', $apikey, $listID, $email_news,$fname_news,$lname_news, $_SERVER['REMOTE_ADDR']);
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($ch);
	curl_close($ch);
	$msg='Thank you for subscribing our newsletter.';
	$form = true;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="styles/style.css" rel="stylesheet" type="text/css" />
</head>
<script>
function validate()
{
if(document.getElementById('fname').value=='')
			{
				document.getElementById('fname_error').style.display='block';
				return false;
			}
		else
			{
				document.getElementById('fname_error').style.display='none';
			}
if(document.getElementById('lname').value=='')
			{
				document.getElementById('lname_error').style.display='block';
				return false;
			}
		else
			{
				document.getElementById('lname_error').style.display='none';
			}
if(document.getElementById('email').value=='')
			{
				document.getElementById('email_error').style.display='block';
				return false;
			}
		else
			{
				document.getElementById('email_error').style.display='none';
			}

}
function checkemail(myForm)
	{
		if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(myForm.email.value))
		{
			return true;
		}
			document.getElementById("valid_email_error").style.display="block";
			return false;
	}
</script>
<body>
	<table align="center" width="100%">
    	<tr>
        <td class="header_bg_color" valign="top"><div class="logo"><img src="images/logo_news.gif" border="0"  /></div>
        <div align="right"><a onclick="window.parent.$('colorbox').colorbox.close();" style="cursor:pointer"><input type="image" value="Close" onclick="window.parent.$('colorbox').colorbox.close();" src="images/graphics/close.png" /></a></div>
        </td>
        </tr>
        
        <? if(!$form){?>
        <tr>
        <td style="height:240px;" align="center" valign="middle">
        <form action="" method="post" onSubmit="return checkemail(this)">
        <table class="text_blue" width="70%">
        <tr>
        <td colspan="2" height="20px" valign="bottom" align="center"><?=$msg?>
        <div class="div_text" style="display:none;" id="fname_error">*Please enter first name</div>
        <div class="div_text" style="display:none;" id="lname_error">*Please enter last name</div>
        <div class="div_text" style="display:none;" id="email_error">*Please enter email</div>
        <div class="div_text" style="display:none;" id="valid_email_error">*Please enter  valid email</div>
        </td>
        </tr>
        <tr>
        	<td colspan="2" height="80px" class="text_blue_13_bold" align="center">Email me special offers and keep in contact.<br/>You can unsubscribe at any time.</td>
        </tr>
        <tr>
        <td align="left">First Name</td>
        <td align="left"><input type="text" name="fname" id="fname" style="width:200px" /></td>
        </tr>
        <tr>
        <td align="left">Last Name</td>
        <td align="left"><input type="text" name="lname" id="lname" style="width:200px" /></td>
        </tr>
        <tr>
        <td align="left">Email</td>
        <td align="left"><input type="text" name="email" id="email" style="width:200px" /></td>
        </tr>
        <tr><td></td><td>&nbsp;</td></tr>
        <tr>
        <td colspan="2" align="center"><input type="submit" name="submit" value="Submit" onclick="return validate()" />&nbsp;&nbsp;<input type="button" value="No Thanks" onclick="window.parent.$('colorbox').colorbox.close();" /></td>
        </tr>
        </table>
        </form>
        </td>
        </tr>
        <? }else{?>
        <tr><td height="50">&nbsp;</td></tr>
        <tr>
        <td height="50px" align="center" class="text_green" valign="middle"><?=$msg?>
        </td>
        </tr>
        <tr>
        <td height="130px" align="center" valign="top"><a onclick="window.parent.$('colorbox').colorbox.close();" style="cursor:pointer"><input type="button" value="Close" onclick="window.parent.$('colorbox').colorbox.close();" /></a>
        </td>
        </tr>
        <? }?>
        
        <tr>
        <td class="header_bg_color" style="height:40px">&nbsp;</td>
        </tr>
	</table>
</body>
</html>
<? if($form){?>
<script>
setTimeout("window.parent.$('colorbox').colorbox.close()", 5000);
</script>
<? }?>