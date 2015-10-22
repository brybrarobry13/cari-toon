<?

class AzDGCrypt{

   var $k;

   function AzDGCrypt($m){

      $this->k = $m;

   }

   function ed($t) { 

      $r = md5($this->k); 

      $c=0; 

      $v = ""; 

      for ($i=0;$i<strlen($t);$i++) { 

         if ($c==strlen($r)) $c=0; 

         $v.= substr($t,$i,1) ^ substr($r,$c,1); 

         $c++; 

      } 

      return $v; 

   } 

   function crypt($t){ 

      srand((double)microtime()*1000000); 

      $r = md5(rand(0,32000)); 

      $c=0; 

      $v = ""; 

      for ($i=0;$i<strlen($t);$i++){ 

         if ($c==strlen($r)) $c=0; 

         $v.= substr($r,$c,1) . 

             (substr($t,$i,1) ^ substr($r,$c,1)); 

         $c++; 

      } 

      return base64_encode($this->ed($v)); 

   } 
	
   function decrypt($t) { 

      $t = $this->ed(base64_decode($t)); 

      $v = ""; 

      for ($i=0;$i<strlen($t);$i++){ 

         $md5 = substr($t,$i,1); 

         $i++; 

         $v.= (substr($t,$i,1) ^ $md5); 

      } 

      return $v; 

   } 

}
function isSelected($str1, $str2)
{
	if($str1 != $str2)
		return "";
	else
		return "Selected"; 
}

 function getMonth($month)
 {
 
   switch($month){
    case "January": return "1";
	case "February": return 2;
	case "March": return 3;
	case "April": return 4;
	case "May": return 5;
	case "June": return 6;
	case "July": return 7;
	case "August": return 8;
	case "September": return 9;
	case "October": return 10;
	case "November": return 11;
	case "December": return 12;
	
   }
 }
	
function lastDayOfMonth($emonth,$eyear) 
{
			if($emonth == 4 || $emonth == 6 || $emonth == 9 || $emonth == 11) 
			   $ld = 30;
			else if($emonth == 1 || $emonth == 3 || $emonth == 5 || $emonth == 7 || $emonth == 8 || $emonth == 10 || $emonth == 12)   
			   $ld = 31;
			else if($emonth == 2 && !(($eyear % 4 ) == 0))
			   $ld = 28;
			else
			   $ld = 29;
return $ld;
}	

//////////////////////////////////////////////////////////////////////////////////////////////////////////
function databetween($break1,$break2)
{
	global $str;
	if($break1 != "")
	{
		$data = explode($break1,$str,2);
		$data = explode($break2,$data[1],2);
	}
	else
		$data = explode($break2,$str,2);
	$str = $data[1];
	return $data[0];
}

 ?>