<?php
header("Content-type: application/javascript");
$c = $_GET['c'];
if (empty($_GET['c'])) $c = "01";
$fn = "1/Practical Demonkeeping, Ch".$c.".txt";
$f = file($fn);
echo("timeline = [");
for($i=1;$i<count($f);$i++){
	list($start,$end,$dur) = explode("\t",trim($f[$i]));
	$comma = ($i==count($f)-1) ? "" : ",";
	echo("{start:'" . $start . "',end:'" . $end . "',dur:'" . $dur . "'}" . $comma);
}
echo("]");



?>

