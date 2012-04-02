<?php
$c = $_request['c'];
if (empty($_request['c'])) $c = "01";
$xml = "1/chapter".$c.".xhtml";
$xsl = "epub.xsl";
function transDoc($xml_filename,$xsl_filename){
	$xp = new XsltProcessor();
	$xsl = new DomDocument;
	$xsl->load($xsl_filename);
	$xp->importStylesheet($xsl);
	$xml_dom = new DomDocument;
	$xml_dom->load($xml_filename);
	
	return $xp->transformToXML($xml_dom);
}

echo transDoc($xml,$xsl);


?>
