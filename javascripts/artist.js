
function valid()
{	
	var ok=1;
	clear();
	if(document.getElementById("user_fname").value=="")
	{      
		document.getElementById("fname_div").style.display="block";
		ok=0;
	}
	if(document.getElementById("user_lname").value=="")
	{      
		document.getElementById("lname_div").style.display="block";
		ok=0;
	}
	if(document.getElementById("user_email").value=="")
	{
		document.getElementById("email_div").style.display="block";
		ok=0;
	}
	if(document.getElementById("user_email").value!="")
	{
		checkEmail = document.getElementById("user_email").value;
		if ((checkEmail.indexOf('@') < 0) || ((checkEmail.charAt(checkEmail.length-4) != '.') && (checkEmail.charAt(checkEmail.length-3) != '.')))
		{
			document.getElementById("email1_div").style.display="block";
			ok=0;
		}
	}
	if(new_user)
	{
		if(document.getElementById("user_password").value=="")
		{      
			document.getElementById("password_div").style.display="block";
			ok=0;
		}
	}
	if(document.getElementById("user_address1").value=="")
	{      
		document.getElementById("address1_div").style.display="block";
		ok=0;
	}
	if(document.getElementById("bill_country").value=="")
	{      
		document.getElementById("bill_country_div").style.display="block";
		ok=0;
	}
	if(document.getElementById("bill_country").value=="USA")
	{
		if(document.getElementById("bill_state_select").value=="")
		{      
			document.getElementById("bill_state_div").style.display="block";
			ok=0;
		}
	}
	else if(document.getElementById("state").value=="")
	{
		document.getElementById("bill_state_div").style.display="block";
		ok=0;	
	}
	if(document.getElementById("user_city").value=="")
	{      
		document.getElementById("user_city_div").style.display="block";
		ok=0;
	}
	if(document.getElementById("user_zipcode").value=="")
	{      
		document.getElementById("user_zipcode_div").style.display="block";
		ok=0;
	}
	if(document.getElementById("user_phone").value=="")
	{      
		document.getElementById("user_phone_div").style.display="block";
		ok=0;
	}
	if(document.getElementById("user_paypal_acc").value=="")
	{      
		document.getElementById("user_paypal_acc_div").style.display="block";
		ok=0;
	}
	if(document.getElementById("sample_photo").value=="" || document.getElementById("sample_photo2").value=="" || document.getElementById("sample_photo3").value=="")
	{      
		document.getElementById("sample_photo_div").style.display="block";
		ok=0;
	}
	if(document.getElementById("captcha").value=="")
	{      
		document.getElementById("captcha_div").style.display="block";
		ok=0;
	}
	if(document.getElementById("ch_count").value!="3")
	{
		document.getElementById("artist_style_div").style.display="block";
		ok=0;
	}
	if(ok)
	{
		return true;
	}
	else
	{
		return false;
	}
}
function clear()
{
	document.getElementById("fname_div").style.display="none";
	document.getElementById("lname_div").style.display="none";
	document.getElementById("email_div").style.display="none";
	document.getElementById("email1_div").style.display="none";
	document.getElementById("password_div").style.display="none";
	document.getElementById("address1_div").style.display="none";
	document.getElementById("bill_country_div").style.display="none";
	document.getElementById("bill_state_div").style.display="none";
	document.getElementById("user_city_div").style.display="none";
	document.getElementById("user_zipcode_div").style.display="none";
	document.getElementById("user_phone_div").style.display="none";
	document.getElementById("user_paypal_acc_div").style.display="none";
	document.getElementById("sample_photo_div").style.display="none";
	document.getElementById("artist_style_div").style.display="none";
	document.getElementById("captcha_div").style.display="none";	
	document.getElementById("error").style.display="none";
}
