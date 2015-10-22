function valid()
{
	var ok=1;
	hide();
	if(document.getElementById("password").value=="")
	{
		document.getElementById("password_div").style.display="block";
		ok=0;
	}
	if(document.getElementById("new_pass").value=="")
	{
		document.getElementById("new_pass_div").style.display="block";
		ok=0;
	}
	else if(document.getElementById("new_pass").value.length < 6) 
  	{
		document.getElementById("new_pass_length_div").style.display="block";
		ok=0;
   	}
	else if(document.getElementById("new_pass").value != document.getElementById("re_pass").value)
	{
		document.getElementById("n_password_div").style.display="block";
		ok=0;
	}
	if(ok==0)
	{
		return false;
	}
	else
		return true;
}
	
function hide()
	{
		document.getElementById("password_div").style.display="none";
		document.getElementById("new_pass_div").style.display="none";
		document.getElementById("new_pass_length_div").style.display="none";
		document.getElementById("n_password_div").style.display="none";
		document.getElementById("error").style.display="none";
	}
