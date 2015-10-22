
function validate()
{
	hide();
	var valid=true;
	if(document.getElementById('toons').value=='')
	{
		document.getElementById('div_toons').style.display='block';
		valid=false;
	}
	if(document.getElementById('page_affiliates').value=='')
	{
		document.getElementById('div_affiliates').style.display='block';
		valid=false;
	}
	if(document.getElementById('page_faqs').value=='')
	{
		document.getElementById('div_faqs').style.display='block';
		valid=false;
	}
	if(document.getElementById('cool_links').value=='')
	{
		document.getElementById('div_cool_links').style.display='block';
		valid=false;
	}
return valid;
}
function hide()
{
	document.getElementById('div_toons').style.display='none';
	document.getElementById('div_affiliates').style.display='none';
	document.getElementById('div_faqs').style.display='none';
	document.getElementById('div_cool_links').style.display='none';
}