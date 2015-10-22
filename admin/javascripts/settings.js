

function validate()
{
	hide();
	var valid=true;
	if(document.getElementById('site_url').value=='')
	{
		document.getElementById('div_site_url').style.display='block';
		valid=false;
	}
	if(document.getElementById('site_name').value=='')
	{
		document.getElementById('div_site_name').style.display='block';
		valid=false;
	}
	if(document.getElementById('web_title').value=='')
	{
		document.getElementById('div_web_title').style.display='block';
		valid=false;
	}
	
	if(document.getElementById('admin_email').value=='')
	{
		document.getElementById('div_admin_email').style.display='block';
		valid=false;
	}
	if(document.getElementById("admin_email").value!="")
		{
				checkEmail = document.getElementById("admin_email").value;
		if ((checkEmail.indexOf('@') < 0) || ((checkEmail.charAt(checkEmail.length-4) != '.') && (checkEmail.charAt(checkEmail.length-3) != '.')))
		{
				document.getElementById("div2_admin_email").style.display="block";
				valid=false;
		}
		}
	if(document.getElementById('package_out_email').value=='')
	{
		document.getElementById('div_out_email').style.display='block';
		valid=false;
	}
	if(document.getElementById("package_out_email").value!="")
		{
				checkEmail = document.getElementById("package_out_email").value;
		if ((checkEmail.indexOf('@') < 0) || ((checkEmail.charAt(checkEmail.length-4) != '.') && (checkEmail.charAt(checkEmail.length-3) != '.')))
		{
				document.getElementById("div2_out_email").style.display="block";
				valid=false;
		}
		}
	if(document.getElementById('package_contact_email').value=='')
	{
		document.getElementById('div_contact_email').style.display='block';
		valid=false;
	}
	if(document.getElementById("package_contact_email").value!="")
		{
				checkEmail = document.getElementById("package_contact_email").value;
		if ((checkEmail.indexOf('@') < 0) || ((checkEmail.charAt(checkEmail.length-4) != '.') && (checkEmail.charAt(checkEmail.length-3) != '.')))
		{
				document.getElementById("div2_contact_email").style.display="block";
				valid=false;
		}
		}
	
	if(document.getElementById('keywords').value=='')
	{
		document.getElementById('div_keywords').style.display='block';
		valid=false;
	}
	if(document.getElementById('description').value=='')
	{
		document.getElementById('div_description').style.display='block';
		valid=false;
	}
	if(document.getElementById('twitter_username').value=='')
	{
		document.getElementById('div_twitter_username').style.display='block';
		valid=false;
	}
	if(document.getElementById('facebook_username').value=='')
	{
		document.getElementById('div_facebook_username').style.display='block';
		valid=false;
	}
	if(document.getElementById('youtube_username').value=='')
	{
		document.getElementById('div_youtube_username').style.display='block';
		valid=false;
	}
	if(document.getElementById('blog_username').value=='')
	{
		document.getElementById('div_blog_username').style.display='block';
		valid=false;
	}
	if(document.getElementById('google_ads').value=='')
	{
		document.getElementById('div_google_ads').style.display='block';
		valid=false;
	}
	if(document.getElementById('paypal_uname').value=='')
	{
		document.getElementById('div_paypal_uname').style.display='block';
		valid=false;
	}
	if(document.getElementById('paypal_password').value=='')
	{
		document.getElementById('div_paypal_password').style.display='block';
		valid=false;
	}
	if(document.getElementById('paypal_signature').value=='')
	{
		document.getElementById('div_paypal_signature').style.display='block';
		valid=false;
	}
	return valid;
}
function hide()
{
	
	document.getElementById('div_site_url').style.display='none';
	document.getElementById('div_site_name').style.display='none';
	document.getElementById('div_web_title').style.display='none';
	document.getElementById('div_admin_email').style.display='none';
	document.getElementById('div2_admin_email').style.display='none';
	document.getElementById('div_out_email').style.display='none';
	document.getElementById('div2_out_email').style.display='none';
	document.getElementById('div_contact_email').style.display='none';
	document.getElementById('div2_contact_email').style.display='none';
	document.getElementById('div_keywords').style.display='none';
	document.getElementById('div_description').style.display='none';
	document.getElementById('div_twitter_username').style.display='none';
	document.getElementById('div_facebook_username').style.display='none';
	document.getElementById('div_youtube_username').style.display='none';
	document.getElementById('div_blog_username').style.display='none';
	document.getElementById('div_google_ads').style.display='none';
	document.getElementById('div_paypal_uname').style.display='none';
	document.getElementById('div_paypal_password').style.display='none';
	document.getElementById('div_paypal_signature').style.display='none';
	document.getElementById('div_err_msg').style.display='none';
}
