

<script language="javascript" type="text/javascript">

function startUpload(){
		
	  document.getElementById('f1_upload_process_1').style.visibility = 'visible';
	  document.getElementById('f1_upload_form_1').style.visibility = 'hidden';
     
      return true;
}

function stopUpload(success,file_name){
//alert(file_name);
      var result = '';
      if (success == 1)
	  {
	  	window.open('templates/jcrop_main.php?file_name='+file_name,'CROP IMAGE','width=1000,height=620,scrollbars=0');
      }
      else 
	  {
         result = '<span class="emsg">There was an error during file upload!<\/span><br/><br/>';
      }
      document.getElementById('f1_upload_process_1').style.visibility = 'hidden';
      document.getElementById('f1_upload_form_1').style.visibility = 'visible';  
	 
	  if(file_name.substr(0,5)=='artist')
	  {
	 	 document.getElementById('photo_1').value=file_name;
		 document.getElementById("cropped").value="no";
		// alert(file_name);
	  }
	  
	  /*alert(document.getElementById("cropped_1").value);
	  alert(document.getElementById("cropped_2").value);*/
      return true;   
}

function set_cropped_no(img_id)
{
	if(img_id=='1')
	{
		document.getElementById("cropped_1").value="no";
	}
	
	if(img_id=='2')
	{
		document.getElementById("cropped_2").value="no";
	}
}
</script>  

	
			
               
			<div id="rlink_div" style="display:none" class="no_details_msg">Enter the Reference Link</div>
				
				<table>
				<tr>
				
				 <td id="new_image" style="padding-left:40px;">
					<form action="upload.php?type=befor" method="post" enctype="multipart/form-data" target="upload_target" onsubmit="startUpload(1);" >
                     <p id="f1_upload_process_1" style="display:none;">Loading...<br/><img src="images/loader.gif" /><br/></p>
                     <p id="f1_upload_form_1" class="text_blue"></p>
                         <label>New Image:
                              <input name="myfile" type="file" id="myfile_1" onchange="set_cropped_no(1)" size="30"  />
                         </label>
						 
                         <label>
                             <input type="submit" name="submitBtn" class="sbtn" value="Crop Image" />
                         </label>
                         <input type="hidden" name="sess_val" value="<?=$_GET['ti_id']?>" />
						 <input type="hidden" name="cropped" id="cropped" value="no" />
                     
                     <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                 </form>
				 </td>
				</tr>
			
            </table>