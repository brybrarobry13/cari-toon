
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
			document.getElementById("error").style.display="none";
}
