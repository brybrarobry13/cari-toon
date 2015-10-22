// MULTIPLE PHOTO UPLOAD
	function more_photo()
	{	
		var browserName = navigator.appName;
		photo_counter++;
		var row = document.createElement("DIV");
		row.setAttribute("style","padding-top:5px;");
		if(browserName!="Microsoft Internet Explorer")
		{
			var inp = document.createElement("input");
			inp.setAttribute("type","File");
			inp.setAttribute("name","photo_"+photo_counter);
		}
		else
		{
			var inp = document.createElement("<INPUT TYPE='File' NAME='photo_"+photo_counter+"' />");
		}	
		row.appendChild(inp);
		var divTg = document.createElement('DIV');
		var divTag = document.createElement('DIV');
		divTg.appendChild(row);
		divTag.innerHTML = divTg.innerHTML;
		document.getElementById("photo_more").appendChild(divTag);
		if(photo_counter>=max_photos)
		{
			document.getElementById("add_photo").style.display = 'none';
		}
		return false;
		
	}
