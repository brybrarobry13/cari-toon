
function valid()
{
	var ok=1;
	hide();
	if(document.getElementById("uname").value=="")
	{
		document.getElementById("div_uname").style.display="block";
		ok=0;
	}
	if(document.getElementById("pass").value=="")
	{
		document.getElementById("div_pass").style.display="block";
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
		document.getElementById("div_uname").style.display="none";
		document.getElementById("div_pass").style.display="none";
		document.getElementById("error").style.display="none";
	}
