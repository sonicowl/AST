<?php

include ('smartReadFile.php');
$c = $_GET['c'];
if (empty($_GET['c'])) $c = "01";
smartReadFile("1/Practical Demonkeeping Ch ".$c.".mp3", "1/Practical Demonkeeping Ch ".$c.".mp3","audio/mpeg");

?>
