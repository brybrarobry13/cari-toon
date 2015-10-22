<? 
function createRandomString($stringSize=8){
$chars = "abcdefghijkmnopqrstuvwxyz0123456789";
srand((double)microtime()*1000000);
$i = 0;
$pass = '' ;
while ($i <= $stringSize)
{
$num = rand() % 33;
$tmp = substr($chars, $num, 1);
$pass = $pass . $tmp;
$i++;
}
return $pass;
}
?>