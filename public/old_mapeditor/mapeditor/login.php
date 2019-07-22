<?php
// Connect to database;

$dblocation = "localhost";
$dbname = "clanwars";
$dbuser = "autification"; //autification
$dbpasswd = "yX7Cd2dOMugPCWwj"; //yX7Cd2dOMugPCWwj
$dbcnx = @mysql_connect($dblocation,$dbuser,$dbpasswd);
if (!$dbcnx) die("<P>MySQL server is not reachable. Connect with administrator to solve this problem.</P>");
if (!@mysql_select_db($dbname, $dbcnx)) die($returnstrok = "<P>MySQL database is not reachable. Connect with administrator to solve this problem.</P>");

// Get form info
$param = json_decode($_REQUEST["param"]); $param->login = trim($param->login);

$sql = mysql_query("SELECT * FROM `players` WHERE `players`.`nickname` = '".$param->login."'");

$loginexists = !!$sql;
if($loginexists) $player = mysql_fetch_array($sql);

if($loginexists){
	if($player['password'] == $param->password){
		if($param->signup == 1){
			$returnval = SaveMap($param->map, $player['id'], $param->mapname);
			if(!$returnval)
				echo "Saving succeeded";
			else 
				echo "Failed with saving: ".$returnval;
		} else 
		echo("<span style=\"color:green;\">Success</span>");
	}  else echo("Wrong password");
} else echo("There is no such player");

mysql_close($dbcnx);
exit();

/*__________________________________.
									|
	Functions: Saving map			|
  __________________________________|
*/

function SaveMap($map , $ownerid, $mapname)
{
	$MapArr = ConvertStringToMap($map);
	$baseArr = FindBases($MapArr);

	$sql = mysql_query("INSERT INTO `maps` (`id`, mapR, `name`, `owner`, `bases`, `color`, `dateofcreation`) 
		VALUES (NULL, '".$map."', '".$mapname."', '".$ownerid."', '".$baseArr[0]."', '".$baseArr[1]."', '".time()."')");
	if(!$sql) return mysql_errno()." ".mysql_error() ;
	$sql = mysql_query("SELECT * FROM `maps` ORDER BY `id` DESC ");
	DrawMapImage($MapArr, GetMaxMinX_MaxMinY($MapArr), mysql_fetch_array($sql)['id'].'map');
}

function ConvertMapToString($value)
{

}

function ConvertStringToMap($strok)
{
	$returnArr = array();

	$xTrashy = explode('"', $strok); // ("x|y;type;type|y;type;type|...","x|y;type;type")
	foreach ($xTrashy as $value) {
		$xTrash = explode('|', $value); // ("x", "y;type;type", "y;type;type", ...)
		// $smth[0] - column
		$x = intval($xTrash[0], 10);
		if($x == 0) continue;
		$returnArr += [ $x => array() ];
		$xTrashLenght = count($xTrash);
		for ($i=1; $i < $xTrashLenght ; $i++) { 
			$hex = explode(';',$xTrash[$i]); // ("y", "type", "type")
			$y = intval($hex[0], 10);
			$returnArr[$x] += [ $y => array($hex[1],$hex[2]) ];
		}

	}
	//print_r($returnArr);
	return $returnArr;
}

function FindBases($map = false)
{
	 $baseStrok = "";
	$colorStrok = "";

	if(!$map) return "";
	foreach ($map as $i => $mapI) {
		foreach ($mapI as $j => $mapJ) {
			if($mapJ[1] == 7 && $mapJ[0] != 0){
				$baseStrok  .= '|'.$i.','.$j;
				$colorStrok .= '|'.$mapJ[0];
			}
		}
	}
	unset($mapI,$mapJ,$i,$j);

	return [$baseStrok, $colorStrok];
}

/*__________________________________.
									|
	Functions: Drawing map			|
  __________________________________|
*/

function GetMaxMinX_MaxMinY($map)
{
$X = array(0,0); $firstIt = true;
$Y = array(0,0); $isLCE = 2; // is left column empty
				 $isRCE = 2; // right column empty
//Костыль для взятия первого элемента массива ;-;
foreach ($map as $mapI) {
	foreach ($mapI as $j => $mapJ) {
		if(!($j & 1)) { $isLCE = 0;
						  goto theExit;} 
	}
	goto theExit;
}
	theExit:
	unset($mapI,$mapJ,$j);

foreach ($map as $i => $mapI) {
	if($firstIt)$X[0] = $i;
				$X[1] = $i;
	foreach ($mapI as $j => $mapJ) {
		if($Y[0] > $j || $firstIt) $Y[0] = $j;
		if($Y[1] < $j) $Y[1] = $j;
		$firstIt = false;
	}
}

	unset($mapI,$mapJ,$j);

foreach ($map[$i] as $j => $mapJ) {
	//echo $j."<br>";
	if(!!($j & 1)) { $isRCE = 0; break; }
}
	unset($mapJ,$j);

	return array($X,$Y,$isLCE,$isRCE);
}

function DrawMapImage($map, $maxmins, $filename)
{
	$X = $maxmins[0];
	$Y = $maxmins[1];

	// 1. Создать "холст" для карты размерами (maxX - minX)*3 + 1 , аналогично для Y ( +  пикселя)
	$im = imagecreatetruecolor( ($X[1] - $X[0] + 1)*4+3-$maxmins[2]-$maxmins[3], ($Y[1] - $Y[0] + 1)*4+1); 
	//imagefill($im, 0, 0, imagecolorallocatealpha($im, 255, 255, 255, 127));
	//echo ((($X[1] - $X[0] + 1)*4+3)." , ".(($Y[1] - $Y[0] + 1)*4+1)."\n");
	// 1,5. Поставить цвета для прямоугольников
	$colors = array(
		imagecolorallocate($im, 195, 195, 195),  // $grey
		imagecolorallocate($im, 128, 0  , 255), // $purple
		imagecolorallocate($im, 237, 28 , 36 ), // $red
	 	imagecolorallocate($im, 255, 255, 0  ), // $yellow
		imagecolorallocate($im, 0  , 255, 64 ), // $green
		imagecolorallocate($im, 0  , 255, 255), // $cyan
		imagecolorallocate($im, 0  , 128, 255), // $blue
				);
	// 2. Цикл рисовки прямоугольничков
	foreach ($map as $i => $mapI) {
		foreach ($mapI as $j => $mapJ) {
			$isOdd = ($j & 1)*2;
			imagefilledrectangle($im,($i-$X[0])*4+$isOdd-$maxmins[2],($j-$Y[0])*4,($i-$X[0])*4+4+$isOdd-$maxmins[2],($j-$Y[0])*4+4,imagecolorallocate($im, 155, 155, 155));
			imagefilledrectangle($im,($i-$X[0])*4+1+$isOdd-$maxmins[2],($j-$Y[0])*4+1,($i-$X[0])*4+3+$isOdd-$maxmins[2],($j-$Y[0])*4+3,$colors[$mapJ[0]]);
		}
	}

	// Сохраняем изображение в 'simpletext.jpg'
	imagepng($im, '../useful/maps/'.$filename.'.png');
	imagedestroy($im);

	unset($mapI,$mapJ,$i,$j);
}