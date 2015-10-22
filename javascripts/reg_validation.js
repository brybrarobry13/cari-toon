// JavaScript Document
function reg_validation()
{
	
	if (document.getElementById("fname").value=='')
		{
			document.getElementById("error_fname").style.display='block'
			return false;
		}
	else
		{
			document.getElementById("error_fname").style.display='none'
		}		
	if (document.getElementById("lname").value=='')
		{
			document.getElementById("error_lname").style.display='block'
			return false;
		}
	else
		{
			document.getElementById("error_lname").style.display='none'
		}
	if (document.getElementById("email").value=='')
		{
			document.getElementById("error_email").style.display='block'
			return false;
		}
	else
		{
			document.getElementById("error_email").style.display='none'
		}
	
	if (document.getElementById("re_email").value=='')
		{
			document.getElementById("error_re_email").style.display='block'
			return false;
		}
	else
		{
			document.getElementById("error_re_email").style.display='none'
		}
	if (document.getElementById("email").value!=document.getElementById("re_email").value)
		{
			document.getElementById("correct_email").style.display='block'
			return false;
		}
	else
		{
			document.getElementById("correct_email").style.display='none'
		}
	
	if (document.getElementById("password").value=='')
		{
			document.getElementById("error_password").style.display='block'
			return false;
		}
	else
		{
			document.getElementById("error_password").style.display='none'
		}
	if(document.getElementById("password").value.length<6)
		{
			document.getElementById("len_password").style.display='block'
			return false;	
		}
	else
		{
			document.getElementById("len_password").style.display='none'
		}
	if (document.getElementById("re_password").value=='')
		{
			document.getElementById("error_re_password").style.display='block'
			return false;
		}
	else
		{
			document.getElementById("error_re_password").style.display='none'
		}
	if (document.getElementById("re_password").value!=document.getElementById("password").value)
		{
			document.getElementById("correct_password").style.display='block'
			return false;
		}
	else
		{
			document.getElementById("correct_password").style.display='none'
		}
	
}
function checkemail(myForm)
{
	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(myForm.re_email.value))
		{
			return (true)
		}
			document.getElementById("validemail").style.display="block";
			return (false)
}
