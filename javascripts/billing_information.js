// JavaScript Document
var xmlhttp;
var k;
	function country1(type)
	{	
		if(type=='ez')
		{
			var country = document.getElementById('country').value;
			k=1;
		}
		else
		{
			var country = document.getElementById('bill_country').value;
			k=0;
		}
		if((country!='USA') && (country!='CAN')&&(country!='US') && (country!='CA'))
		{
			if(type=='ez')
			{
				document.getElementById("stat_div_ez").innerHTML = '<input type="text" name="state" style="width:190px;" id="state" onblur="shipping_price()">';
				return false;
			}
			else
			{
				document.getElementById("stat_div").innerHTML = '<input type="text" name="bill_state" style="width:190px;" id="bill_state">';
				return false;
			}
		}
		xmlhttp=GetXmlHttpObject();
		if (xmlhttp==null)
		{
			alert ("Your browser does not support XMLHTTP!");
			return false;
		}
		var url="ajax_country.php";
		url=url+"?country="+country;
		url=url+"&type="+type;
		url=url+"&sid="+Math.random();
		xmlhttp.onreadystatechange=stateChanged2;
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
	}
		
	function stateChanged2()
	{
		if (xmlhttp.readyState==4)
		{
			var xmlresp=xmlhttp.responseText;
			if(k==1)
			{
			document.getElementById("stat_div_ez").innerHTML = xmlresp;
			}
			else
			{
			document.getElementById("stat_div").innerHTML = xmlresp;
			}
			
		}
	}
	
	function GetXmlHttpObject()
	{
		if (window.XMLHttpRequest)
		{
			// code for IE7+, Firefox, Chrome, Opera, Safari
			return new XMLHttpRequest();
		}
		if (window.ActiveXObject)
		{
			// code for IE6, IE5
			return new ActiveXObject("Microsoft.XMLHTTP");
		}
		return null;
	}