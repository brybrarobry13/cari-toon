<?
include('includes/configuration.php');
$ez_catid=$_REQUEST['ez_catid'];
$mcatid=$_REQUEST['m_catid'];
if($ez_catid=="")
{
header("Location:ez_categories.php");
}
if(isset($_POST['submit']))
	{
			$product_cat= addslashes($_POST["product_cat"]);
			$ez_catid=$_POST["ez_catid"];
			$product_des= addslashes($_POST['product_des']);
			$product_display = $_POST['product_display'];
			$main_category=$_POST['main_category'];
			if($product_display == '')
			$product_display = 0;
			if($_FILES['product_img']['name']!='')
			{
				if ($_FILES['product_img']["type"] == "image/gif" || $_FILES['product_img']["type"] == "image/jpeg" || $_FILES['product_img']["type"] == "image/pjpeg" || $_FILES['product_img']["type"] == "image/png")
								
					
				{
					if($_FILES['product_img']['size'] < 10485760)
					// IF PHOTO SIZE LESS THAN ALLOWED SIZE THEN CONTINUE
					{	
						$photoName1=$_FILES['product_img']['name'];
						$photoName=str_replace(" ","_",$photoName1);
						move_uploaded_file($_FILES['product_img']['tmp_name'],DIR_EZPRINTS_CAT_IMAGES.$ez_catid.'_'.$photoName);
						$newname=$ez_catid.'_'.$photoName;
						$sql_insert="UPDATE `toon_ez_categories` SET `ecat_name` = '$product_cat',`ecat_description`='$product_des',`ecat_image`='$newname',`ecat_display`='$product_display',`mcat_id`='$main_category' WHERE `ecat_id`='$ez_catid'";
						mysql_query($sql_insert);
						header("Location:ez_categories.php");
					}
					else
					{
						$error="Please Upload Images Less Than 10 MB";
					}
				}
				else
				{
					$error="Invalid Image Format";
				}
			}
			else
			{
				$sql_insert="UPDATE `toon_ez_categories` SET `ecat_name` = '$product_cat',`ecat_description`='$product_des',`ecat_display`='$product_display',`mcat_id`='$main_category' WHERE `ecat_id`='$ez_catid'";
				mysql_query($sql_insert);
				header("Location:ez_categories.php");
			}
			
			
			
			
	}
	
$ez_maincategories=mysql_query("SELECT * FROM `toon_main_category` ");
$ez_categories=mysql_query("SELECT * FROM `toon_ez_categories` WHERE `ecat_id`='$ez_catid'");
$row_categories=mysql_fetch_assoc($ez_categories);
include ('includes/header.php');
?>
<script type="text/javascript">
function hide()
  {
	document.getElementById("product_cat_err").style.display="none";
	document.getElementById("product_des_err").style.display="none";
  }
function verify()
	{
		k=0;
		if(document.getElementById("product_cat").value=='')
		{
			document.getElementById("product_cat_err").style.display="block";
			k=1
		}
		if(document.getElementById("product_des").value=='')
		{
			document.getElementById("product_des_err").style.display="block";
			k=1
		}
		if(k==1)
		{
		return false
		}
		else
		{
		return true
		}
    }
</script>
<link rel="stylesheet" type="text/css" href="../styles/highslide.css" />
<script type="text/javascript" src="../javascripts/highslide-with-html.js"></script>
<script type="text/javascript">
	hs.graphicsDir = '../images/graphics/';
	hs.align = 'center';
	hs.transitions = ['expand', 'crossfade'];
	hs.outlineType = 'rounded-white';
	hs.fadeInOut = true;
	hs.numberPosition = 'caption';
	hs.dimmingOpacity = 0.75;

	// Add the controlbar
	if (hs.addSlideshow) hs.addSlideshow({
		//slideshowGroup: 'group1',
		interval: 5000,
		repeat: false,
		useControls: true,
		fixedControls: 'fit',
		overlayOptions: {
			opacity: .75,
			position: 'bottom center',
			hideOnMouseOut: true
		}
	});
</script>
<script type="text/javascript" src="javascripts/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
// General options
mode : "exact",
elements: "product_des",

theme : "advanced",
plugins : "safari,style,table,save,advimage,advlink,inlinepopups,insertdatetime,preview,searchreplace,print,contextmenu,noneditable,visualchars,xhtmlxtras,template",
// Theme options
theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
theme_advanced_buttons3 : "",
theme_advanced_buttons4 : "",
theme_advanced_toolbar_location : "top",
theme_advanced_toolbar_align : "left",
theme_advanced_statusbar_location : "bottom",
theme_advanced_resizing : true,
extended_valid_elements : "input[type|name|id|size|class|alt|maxlength|onclick|value],a[name|href|target|title|onclick|onmousedown|class|style],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
//extended_valid_elements : "a[name|href|target|title|onclick|class], img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style],input[type|name|value]",

// Example content CSS (should be your site CSS)
content_css : "style/style.css",
// Replace values for the template plugin
template_replace_values : {
username : "Some User",
staffid : "991234"
}
});
</script>
<script language="javascript" type="text/javascript">
function popitup(url) {
newwindow=window.open(url,'name','height=600,width=900,scrollbars=1');
newwindow.moveTo(100,200);
newwindow.status=1
if (window.focus) {newwindow.focus()}
return false;
}
</script>
<form action="edit_ezcategories.php" method="post"  onsubmit="return verify();" enctype="multipart/form-data">
  <table cellpadding="0" cellspacing="10" border="0" width="97%">
    <tr>
      <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
      <td align="center"><table cellpadding="0" cellspacing="0" width="100%" class="table_border">
          <tr class="table_titlebar">
            <td class="main_heading" height="30" colspan="4">Add EZ Category</td>
          </tr>
          <tr>
		  <td height="40px;"></td><td align="center" style="color:#FF0000"><?=$error?></td>
		 </tr>
		  <tr>
            <td width="1%">&nbsp;</td>
            <td width="98%" align="center" valign="top"><table cellpadding="5" cellspacing="0" width="60%" class="table_border">
                <tr>
				<td colspan="2">&nbsp;</td>
				<td>	
			<div id="product_cat_err" style="display:none;color:#FF0000" >Enter EZ Category</div>
			<div id="product_des_err" style="display:none;color:#FF0000" >Enter EZ Category Description</div>
				</td>
				</tr>
				<tr>
				<td width="14%">&nbsp;</td>
                  <td width="33%" align="left" class="table_details">EZ Category Name&nbsp;:*</td>
                  <td width="53%" align="left"><input type="text" name="product_cat" id="product_cat" value="<?=$row_categories['ecat_name']?>"/></td>
                </tr>
				<tr>
				<td width="14%">&nbsp;</td>
                  <td width="33%" align="left" class="table_details">EZ Category Image&nbsp;:*</td>
                  <td width="53%" align="left"><a href="../z_uploads/EZ_category_images/<?=$row_categories['ecat_image']?>" onclick="return hs.expand(this)"><img src="<?='../includes/imageProcess.php?image='.$row_categories['ecat_image'].'&type=ez_category&size=100';?>"  border="0" /></a></td>
                </tr>
                <tr>
				<td width="14%">&nbsp;</td>
                  <td width="33%" align="left" class="table_details">Change EZ Category Image&nbsp;:*</td>
                  <td width="53%" align="left"><input type="file" name="product_img" id="product_img"/></td>
                </tr>
				<tr>
				<td width="14%">&nbsp;</td>
                  <td width="33%" align="left" class="table_details">EZ Product Description&nbsp;:*</td>
                  <td width="53%" align="left"><textarea name="product_des" id="product_des" ><?=$row_categories['ecat_description']?></textarea></td>
                </tr>
				<tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details" valign="top">Select EZ Main Category:*</td>
                  <td align="left"><select name="main_category" id="main_category">
                  <option value="">Select EZ Main Category</option>
                  <?
				  while($row_toon_categories=mysql_fetch_array($ez_maincategories))
				  {
				  
				  ?>
				  <option <? if($row_categories['mcat_id']==$row_toon_categories['mcat_id']){ ?>selected="selected"<? }?> value="<?=$row_toon_categories['mcat_id'];?>"><?=$row_toon_categories['mcat_name'];?></option>
                  
                  <?
				  }
				  ?>
                  </select>
                  </td>
                </tr>
				
                <tr>
				<td width="14%">&nbsp;</td>
                  <td width="33%" align="left" class="table_details">&nbsp;</td>
                  <td width="53%" align="left"><input type="checkbox" name="product_display" <? if($row_categories['ecat_display']=='1'){?>checked="checked" <? }?>value="1" /> Show in Website</td>
                </tr>
                <input type="hidden" name="ez_catid" value="<?=$ez_catid?>">
                <tr><td>&nbsp;</td>
                  <td align="left" class="table_details">&nbsp;</td>
                  <td align="left" ><input type="submit" name="submit" value="Save"/>
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
