// JavaScript Document
var xmlhttp;
	function country1()
	{
		var country = document.getElementById('bill_country').value;
		if((country!='US') && (country!='CA'))
		{
		document.getElementById("stat_div").innerHTML = '<input type="text" name="bill_state" style="width:190px;" id="bill_state">';
		return false;
		}
		xmlhttp=GetXmlHttpObject();
		if (xmlhttp==null)
		{
			alert ("Your browser does not support XMLHTTP!");
			return false;
		}
		var url="ajax_country.php";
		url=url+"?country="+country;
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
			//var arrxml = xmlresp.split("|");
			document.getElementById("stat_div").innerHTML = xmlresp;
//			document.getElementById("state").options[0] = new Option("Select a state","");
//			for (i=0;i<arrxml.length;i++) {
//			if(arrxml[i]!="")
//			var countryarray=arrxml[i].split("-");
//			document.getElementById("state").options[i+1] = new Option(countryarray[1],countryarray[0]);
			//}

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