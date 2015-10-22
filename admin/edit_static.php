<? 
include ("includes/configuration.php"); 
$static_id=$_REQUEST['static_id'];
if(isset($_POST['update']))
{
	$text=$_POST['toons'];
	mysql_query("update toon_static set static_content='$text' where static_id='$static_id'");
}

$static=mysql_query("SELECT * FROM toon_static where static_id='$static_id'");
$content=mysql_fetch_array($static);


	 include ("includes/header.php");?>
<script language="javascript" type="text/javascript" src="javascripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
mode : "textareas",
theme : "simple",
content_css : "../styles/style.css"

});
</script>

<script>
function valid()
{
hide();
	if (document.getElementById("toons").value=="")
	{
	
	document.getElementById("entertext").style.display="block";
	return false;
	}
return true;
}

function hide()
	{
		document.getElementById("entertext").style.display="none";
	}
</script>

<form action="edit_static.php" method="post" onsubmit="return valid();">
  <table cellpadding="0" cellspacing="10" border="0" width="97%">
    <tr>
      <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
      <td align="center"valign="top"><table cellpadding="0" cellspacing="0" width="100%" class="table_border">
          <tr class="table_titlebar">
            <td class="main_heading" height="30" colspan="4">Manage Static Content</td>
          </tr>
		  <tr>
		  <td height="20" colspan="4"></td>
		  </tr>
          
          <tr>
            <td width="90%" align="center" ><table border="0" cellpadding="0" cellspacing="0" width="90%">
              <tr>
                <td height="16" colspan="5"><div id="entertext" align="center" style="display:none" class="no_details_msg">Please enter text</div></td>
              </tr>
			  <tr>
                <td width="5%">&nbsp;</td>
                <td align="left" valign="top" class="static"><?=$content[static_page];?></td>
              </tr>
              <tr >
                <td width="5%">&nbsp;</td>
                <td  align="left" valign="top" style="padding-left:20px;"><textarea name="toons" id="toons"class="textarea_to" /><?=$content[static_content];?></textarea></td>
              </tr>
              <tr>
              <td colspan="2" height="40" align="center"><input type="button" value="Back" onclick="window.location='static_contents.php'" />
              <input type="submit" value="Update" name="update" />
              </td></tr><input type="hidden" name="static_id" value="<?=$static_id;?>" />
			 </table></td>
            <td width="10%">&nbsp;</td>
          </tr>
          <tr>
            <td height="40" colspan="4"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<? include ("includes/footer.php"); ?>
