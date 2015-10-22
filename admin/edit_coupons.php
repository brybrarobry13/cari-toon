<?
		include('includes/configuration.php');
 		$cc_id=$_REQUEST['cc_id'];
		$cu_id=$_REQUEST['cu_id'];
 		
 		$del=$_REQUEST['del'];
	    if($del)
	    {	
	    	$row_photoname=mysql_fetch_assoc(mysql_query("SELECT `cc_photo` FROM `toon_cool_coupon` WHERE `cc_id`='$cc_id'"));
			@unlink(DIR_COUPON_IMAGES.$row_photoname['cc_photo']);
			$sql_delete="update `toon_cool_coupon` set cc_photo='' WHERE `cc_id`='$cc_id'";
			mysql_query($sql_delete);
		}
		
		if($cc_id!="")
		{
			$sql_coupons="SELECT * FROM `toon_cool_coupon` WHERE `cc_id`='$cc_id'";
			$rs_coupons = mysql_query($sql_coupons);
			$row_coupons=mysql_fetch_assoc($rs_coupons);
			$photo = $row_coupons['cc_photo'];
		}
		
		if(isset($_POST['submit']))
		{
			 	
				$ref_link_name=addslashes($_POST["ref_link_name"]);
				$ref_link=$_POST["ref_link"];
				$ref_desc=$_POST["ref_desc"];
				$ref_cat=$_POST["main_category"];
				$cc_photo = $_FILES['cc_photo']['name'];
				$photoname_split = explode('.',$cc_photo);
				$cc_photo_ext = $photoname_split[sizeof($photoname_split)-1];
				$allow_types = array("jpg","jpeg","gif","png");
				
				if($cc_id)
				{
					$sql_update="UPDATE `toon_cool_coupon` SET `cc_link_name`='$ref_link_name',`cc_link`='$ref_link',`cc_desc`='$ref_desc',`cc_category`='$ref_cat' WHERE `cc_id`='$cc_id'";	
					$update_promo=mysql_query($sql_update);
					$msg='Updated Successfully!';
				}
				else
				{
					$sql_insert="INSERT INTO `toon_cool_coupon`(`cc_flag`,`cc_link_name` ,`cc_link` ,`cc_desc`,`cc_category`)VALUES 
					('1', '$ref_link_name', '$ref_link','$ref_desc','$ref_cat')";	
					mysql_query($sql_insert);
					$cc_id=mysql_insert_id();
				}
			    if(($cc_photo && in_array($cc_photo_ext,$allow_types)) || !$cc_photo){
					if($cc_photo)
			   		{	
			    		$imagename = $_FILES['cc_photo']['name'];
						$photoName=str_replace(" ","_",$imagename);
						$newname=$cc_id.'_'.$photoName;
						move_uploaded_file($_FILES['cc_photo']['tmp_name'],DIR_COUPON_IMAGES.$cc_id.'_'.$photoName);
						mysql_query("UPDATE `toon_cool_coupon` SET `cc_photo`='$newname' WHERE `cc_id`='$cc_id'");								
	   			    }
							
                } else {
                           $error = "Photo format not supported";
                }
									
				header("Location:manage_coupons.php");
			}			

	$ez_coupouncategories=mysql_query("SELECT * FROM `toon_coupon_category` ");			

		include ('includes/header.php');
?>
<script type="text/javascript">
function valid()
{
	clear();
	var valid=true;
		if(document.getElementById("main_category").value=="")
    	{      
		 		document.getElementById("cat_div").style.display="block";
				valid=false;
     	}
		if(document.getElementById("ref_link_name").value=="")
    	{      
		 		document.getElementById("rname_div").style.display="block";
				valid=false;
     	}
		if(document.getElementById("ref_link").value=="")
    	{      
		 		document.getElementById("rlink_div").style.display="block";
				valid=false;
     	 		
		}
	 	if(document.getElementById("ref_desc").value=="")
   		{
     			document.getElementById("des_div").style.display="block";
	 			valid=false;
    	}
		
		return valid;
}
function clear()
{
		document.getElementById("cat_div").style.display="none";
		document.getElementById("rname_div").style.display="none";
		document.getElementById("rlink_div").style.display="none";
		document.getElementById("des_div").style.display="none";
			
}
function confirmation()
{
	if(confirm("Do you really want to delete?"))
	{
		return true;
	}
	return false;	
}
</script>

<form action="edit_coupons.php" method="post" onsubmit="return valid()" enctype="multipart/form-data">
  <table cellpadding="0" cellspacing="10" border="0" width="97%">
    <tr>
      <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
      <td align="center"><table cellpadding="0" cellspacing="0" width="100%" class="table_border">
          <tr class="table_titlebar">
            <td class="main_heading" height="30" colspan="4">Manage Coupons</td>
          </tr>
          <tr>
		  <td height="40px;"></td>
		 </tr>
		  <tr>
            <td width="1%">&nbsp;</td>
            <td width="98%" align="center" valign="top"><table cellpadding="5" cellspacing="0" width="60%" class="table_border">
                <tr>
				<td colspan="2">&nbsp;</td>
				<td>
                	<div id="cat_div" style="display:none" class="no_details_msg">Enter Category</div>
                    <div id="rname_div" style="display:none" class="no_details_msg">Enter Reference Name</div>
                    <div id="rlink_div" style="display:none" class="no_details_msg">Enter the Reference Link</div>
                    <div id="des_div" style="display:none" class="no_details_msg">Enter Description</div>
				</td>
				</tr>
				<tr>
				<td width="14%">&nbsp;</td>
                  <td width="33%" align="left" class="table_details">Reference Name&nbsp;:*</td>
                  <td width="53%" align="left"><input type="text" name="ref_link_name" id="ref_link_name" value="<?=$row_coupons['cc_link_name']?>" /></td>
                </tr>
                <tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">Reference Link&nbsp;:*</td>
                  <td align="left"><textarea name="ref_link" id="ref_link" rows="5" cols="25"><?=$row_coupons['cc_link']?></textarea>
				  
				  </td>
                </tr>
                <tr><td>&nbsp;</td>
                  <td align="left" class="table_details">Description&nbsp;:*</td>
                  <td align="left"><textarea name="ref_desc" id="ref_desc" rows="5" cols="25"><?=$row_coupons['cc_desc']?></textarea>
				  </td>
                </tr>
				
				<tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details" valign="top">Select Category:*</td>
                  <td align="left"><select name="main_category" id="main_category">
                  <option value="">Select Category</option>
                  <?
				  while($row_toon_coupouncategories=mysql_fetch_array($ez_coupouncategories))
				  { ?>
				  <option <? if($row_coupons['cc_category']==$row_toon_coupouncategories['cu_id']){ ?>selected="selected"<? }?> value="<?=$row_toon_coupouncategories['cu_id'];?>"><?=$row_toon_coupouncategories['cu_category_name'];?></option>
                  <? } ?>
                  </select>
                  </td>
                </tr>
                <tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">Upload Photo&nbsp;:</td>
				  <? if($photo){?>
                        <td align="left"> <img src="<?='../includes/imageProcess.php?image='.$row_coupons['cc_photo'].'&type=coupon&size=73';?>" border="0"  class="photo_border"/>
                        <a href="edit_coupons.php?del=1&&cc_id=<?=$row_coupons['cc_id'];?>" onclick="return confirmation();"><img src="images/delete.gif" border="0" width="12" /></a>
                        </td>
                    <? } else { ?>
                    <td align="left"> <input type="file" name="cc_photo" id="cc_photo"/> </td>
                    <? } ?>
				</tr>
                
				<tr height="50">
                  <td colspan="2"><input type="hidden" name="cc_id" value="<?=$row_coupons['cc_id'];?>" ></td>
                    <td><input type="submit" name="submit" value=<? if($cc_id){?>"Update" <? }else{?>"Submit"<? }?> />
                  </td>
                </tr>
            </table></td>
            <td width="1%">&nbsp;</td>
          </tr>
          <tr>
            <td height="40" colspan="4"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>

<?	include("includes/footer.php");?>
