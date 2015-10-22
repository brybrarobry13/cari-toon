<?php
include("includes/configuration.php");

if((isset($_GET))&&(($_GET['id']!='')&&($_GET['type']!='')))
{
$id=$_GET['id'];
$type=$_GET['type'];
$text=$_GET['text'];
if($type==2){
$after=mysql_query("UPDATE `toon_artist_gallery` SET `text_after` = '$text' WHERE `agal_id` ='$id'");
}elseif($type==1){
$before=mysql_query("UPDATE `toon_artist_gallery` SET `text_before` = '$text' WHERE `agal_id` ='$id'");
}
if($after){
echo "saved...";
}elseif($before){
echo "saved...";
}else{
echo "Error in saving...";
}

}


?>