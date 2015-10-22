// JavaScript Document
function login_validation()
{
	
	if (document.getElementById("login_email").value=='')
		{
			document.getElementById("error_login_email").style.display='block'
			return false;
		}
	else
		{
			document.getElementById("error_login_email").style.display='none'
		}		
	if (document.getElementById("login_password").value=='')
		{
			document.getElementById("error_login_password").style.display='block'
			return false;
		}
	else
		{
			document.getElementById("error_login_password").style.display='none'
		}
}