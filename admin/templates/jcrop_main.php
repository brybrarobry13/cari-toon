<!--<script src="../js/jquery.min.js"></script>
<script src="../js/jquery.ui.widget.js"></script>
<script src="../js/jquery.ui.accordion.js"></script>
<script src="../js/jquery.Jcrop.min.js"></script>

<script src="../js/jcrop_main.js"></script>-->

<!--<link rel="stylesheet" href="css/jquery.ui.theme.css" type="text/css" />
<link rel="stylesheet" href="css/jquery.ui.accordion.css" type="text/css" />
<link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css" />
<link rel="stylesheet" href="css/jcrop_main.css" type="text/css" />
-->
<?php
		  $target_path="../../z_uploads/admin_artist_gallery/artist_images/for_crop_".$_GET['file_name'];
		  $image_info = getimagesize($target_path);
		  $image_type = $image_info[2];
		  
		   if( $image_type == IMAGETYPE_JPEG ) {
			
			 $image = imagecreatefromjpeg($target_path);
		  } elseif( $image_type == IMAGETYPE_GIF ) {
	 
			 $image = imagecreatefromgif($target_path);
		  } elseif( $image_type == IMAGETYPE_PNG ) {
	 
			 $image = imagecreatefrompng($target_path);
		  }
		  
		  $old_height=imagesy($image);
		  $old_width=imagesx($image);
		  
		  $box_width=204;
		  $box_height=255;
		  if($old_height >= $old_width)
		  {
		  	
			if($old_height > 255 )
			{
				$left_max=$old_height-255;
			}
			else
			{
				$left_max=0;
				$box_height=$old_height;
			}
		  }
		  else
		  {
		  	$box_side=$old_height;
			if($old_width > 204)
			{
				$left_max=$old_width-204;
			}
			else
			{
				$left_max=0;
				$box_width=$old_width;
			}
		  }
		  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head></head>
    <body bgcolor="#999">        
        <div style="background-color:#CCC;height: 600px;">
			<div style="float:left; padding-left:50px;">
				<h3>Original Image</h3>
				<img src="../../z_uploads/admin_artist_gallery/artist_images/for_crop_<?=$_GET['file_name'] ?>"  id="cropbox1" style="float:left; padding-bottom:20px;" />
				<div style="position:relative; border:1px dashed #FFFFFF; width:<?=$box_width?>px; height:<?=$box_height?>px; cursor:move; left:0px; top:0px;" onMouseOver="start_drag()" onClick="stop_drag('<?=$_GET['file_name'];?>')" onMouseMove="changeposition()" id="selected_area"></div>
					
			
				<form action="../crop_image.php" name="crop_form" method="get" onSubmit="return checkCoords();">
					<div style="margin:5px;">
						<label><input type="hidden" name="x" id="x" value="8" size="4"/></label>
						<label><input type="hidden" name="y" id="y" size="4" value="308"/></label>
						<label><input type="hidden" name="x2" id="x2" size="4"/></label>
						<label><input type="hidden" name="y2" id="y2" size="4"/></label>
						<label><input type="hidden" name="w" id="w" size="4"/></label>
						<label><input type="hidden" name="h" id="h" size="4"/></label>
					</div>
						
					<div style="margin:5px;">
						<input type="hidden" name="image_name" value="<?=$_GET['file_name'] ?>" />
						<input type="hidden" name="drag" id="drag" value="" />
						<input type="hidden" name="mouse_start" id="mouse_start" />
						<input type="hidden" name="left_diff" id="left_diff" />
						<input type="hidden" name="top_diff" id="top_diff" />
						<input type="hidden" name="left_pos" id="left_pos" />
						<input type="hidden" name="top_pos" id="top_pos" />
						<input type="hidden" name="width" id="width" value="<?=$box_width?>" />
                        <input type="hidden" name="height" id="height" value="<?=$box_height?>" />
						<?php
						if($old_height>$old_width)
		  				{
						?>
						<input type="hidden" name="direction" id="direction" value="ver" />
						<?php
						}
						else
						{
						?>
						<input type="hidden" name="direction" id="direction" value="hor" />
						<?php
						}
						?>
						<input type="button" value="Crop Image" onClick="submitForm()"  />
					</div>
				</form>
				<form name="Show">
					<input type="hidden" name="MouseX" value="0" size="4"> <br>
					<input type="hidden" name="MouseY" value="0" size="4"> <br>
				</form>
			</div>
			<div style="float:left; padding-left:30px;">
                <h4>Thumbnail Image</h4>
                <div style="overflow: hidden; width:204px; height:255px;" id="preview_crop">
                    <img id="preview" src="../../z_uploads/admin_artist_gallery/artist_images/for_crop_<?=$_GET['file_name'] ?>"  />
					<?php /*?> <iframe src="show_image.php?file_name=<?=$_GET['file_name']?>"  width="<?=$box_side+10?>" height="<?=$box_side+10?>" style="overflow:hidden; border:0px solid #000000; margin:0;"></iframe><?php */?>
                </div>
            </div>
            
        </div>
		
	</body>
</html>
       

        
   




<script type="text/javascript">

function changeposition()
{
	//alert((document.getElementById("selected_area").style.left)+1);
	
	if(document.getElementById("drag").value=='up')
	{
		document.getElementById("selected_area").style.cursor='move';
		if(document.getElementById("direction").value=='hor')
		 {		
				
				//document.getElementById("mouse_start").value=document.Show.MouseX.value;
				var left_value=document.getElementById("selected_area").style.left;
				var right_value=document.getElementById("selected_area").style.right;
				//left_value='4px';
				var new_value_left;
				var new_value_right;
				
				new_value_left=left_value.replace('px',"");
				new_value_right=right_value.replace('px',"");
			
				var extravalue;
				var left_pos=parseInt(document.Show.MouseX.value)-parseInt(document.getElementById("left_diff").value);
				//var right_pos=parseInt(document.Show.MouseX.value)+parseInt(document.getElementById("right_diff").value);
				
				var left_max=parseInt(<?php echo $left_max?>);
				
				if(parseInt(left_pos)>=0 && parseInt(left_pos)<=left_max)
				{
					document.getElementById("left_pos").value=left_pos;
					document.getElementById("selected_area").style.left=left_pos+'px';
					document.getElementById("x").value=left_pos;
					document.getElementById("y").value=left_pos+300;	
				}
		
		}
		else
		{
				//alert("asda");
				//alert(document.getElementById("selected_area").style.top);
				var top_value=document.getElementById("selected_area").style.top;
				//alert("asda1");
				var new_value_top;
				new_value_top=top_value.replace('px',"");
				
				var top_pos=parseInt(document.Show.MouseY.value)-parseInt(document.getElementById("top_diff").value);			
				//alert("asdasd");	
				var top_max=parseInt(<?php echo $left_max?>);
				
				if(parseInt(top_pos)>=0 && parseInt(top_pos)<=top_max)
				{
					//alert(top_pos);
					document.getElementById("top_pos").value=top_pos;
					document.getElementById("selected_area").style.top=top_pos+'px';
					document.getElementById("x").value=top_pos;
					document.getElementById("y").value=top_pos+300;
				}
		}
			
	}
	
}

function start_drag()
{
	document.getElementById("drag").value="up";
	
	//document.getElementById("mouse_start").value=document.Show.MouseX.value;
	
	var left_value_1=document.getElementById("selected_area").style.left;
	var top_value_1=document.getElementById("selected_area").style.top;
	
	var new_value_left_1;
	var new_value_top_1;
	
	new_value_left_1=left_value_1.replace('px',"");
	new_value_top_1=top_value_1.replace('px',"");
	document.getElementById("left_diff").value=parseInt(document.Show.MouseX.value)-parseInt(new_value_left_1);
	document.getElementById("top_diff").value=parseInt(document.Show.MouseY.value)-parseInt(new_value_top_1);
	//alert(document.Show.MouseY.value+","+new_value_top_1+","document.getElementById("top_diff").value);
}
function stop_drag(img_name)
{
		document.getElementById("drag").value="down";
		if(document.getElementById("direction").value=='hor')
		 {		
		 
			left_pos=document.getElementById("left_pos").value;
			show_cropped(left_pos,img_name,'hor');
			
		 }
		 else
		 {
			top_pos=document.getElementById("top_pos").value;
			show_cropped(top_pos,img_name,'ver');
		 }
		 
		start_drag();
		document.getElementById("mouse_start").value="clicked";
		
}

function show_cropped(left_pos_clip,img_name,cr_type)
{	
	
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		//alert(xmlhttp.responseText);
		document.getElementById("preview_crop").innerHTML='<iframe src="show_image.php?file_name='+xmlhttp.responseText+'" frameborder="0" scrolling="no" width="300" height="400" style="overflow:hidden; border:0px solid #000000; margin:-8px;"></iframe>';
		
    }
	}
	xmlhttp.open("GET","crop_ajax.php?direction="+cr_type+"&from="+left_pos_clip+"&width=<?=$box_width?>&height=<?=$box_height?>&image_name="+img_name,true);
	xmlhttp.send();
}






</script>


<script language="JavaScript1.2">
<!--

// Detect if the browser is IE or not.
// If it is not IE, we assume that the browser is NS.
var IE = document.all?true:false

// If NS -- that is, !IE -- then set up for mouse capture
if (!IE) document.captureEvents(Event.MOUSEMOVE)

// Set-up to use getMouseXY function onMouseMove
document.onmousemove = getMouseXY;

// Temporary variables to hold mouse x-y pos.s
var tempX = 0
var tempY = 0

// Main function to retrieve mouse x-y pos.s

function getMouseXY(e) {
  if (IE) { // grab the x-y pos.s if browser is IE
    tempX = event.clientX + document.body.scrollLeft
    tempY = event.clientY + document.body.scrollTop
  } else {  // grab the x-y pos.s if browser is NS
    tempX = e.pageX
    tempY = e.pageY
  }  
  // catch possible negative values in NS4
  if (tempX < 0){tempX = 0}
  if (tempY < 0){tempY = 0}  
  // show the position values in the form named Show
  // in the text fields named MouseX and MouseY
  document.Show.MouseX.value = tempX
  document.Show.MouseY.value = tempY
  return true
}

function submitForm()
{
		document.crop_form.submit();
}
//-->

</script>

