<div id="topMenu">
<div id="top_home_btn"></div>
<div id="top_title">1 - THE BREEZE</div>
<div id="top_audio"></div>
<div style="clear:both"></div>
</div>

<div id="reader_wrapper">
<div id="sound_image"></div>


</div>

<!-- <div onclick="reader.moveTo({ direction: -1 }); ">Previous page</div>
<div onclick="reader.moveTo({ direction: 1 }); ">Next page</div> -->

  <div id="part_01">
<?php 
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
$xml = "1/chapter01.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>


  <div id="part_02">
<?php 
$xml = "1/chapter02.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>


  <div id="part_03">
<?php 
$xml = "1/chapter03.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>


  <div id="part_04">
<?php 
$xml = "1/chapter04.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>


  <div id="part_05">
<?php 
$xml = "1/chapter05.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>


  <div id="part_06">
<?php 
$xml = "1/chapter06.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>

  <div id="part_07">
<?php 
$xml = "1/chapter07.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>

  <div id="part_08">
<?php 
$xml = "1/chapter08.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>

  <div id="part_09">
<?php 
$xml = "1/chapter09.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>

  <div id="part_10">
<?php 
$xml = "1/chapter10.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>

  <div id="part_11">
<?php 
$xml = "1/chapter11.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>

  <div id="part_12">
<?php 
$xml = "1/chapter12.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>

  <div id="part_13">
<?php 
$xml = "1/chapter13.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>

  <div id="part_14">
<?php 
$xml = "1/chapter14.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>

  <div id="part_15">
<?php 
$xml = "1/chapter15.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>

  <div id="part_16">
<?php 
$xml = "1/chapter16.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>

  <div id="part_17">
<?php 
$xml = "1/chapter17.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>

  <div id="part_18">
<?php 
$xml = "1/chapter18.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>

  <div id="part_19">
<?php 
$xml = "1/chapter19.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>

  <div id="part_20">
<?php 
$xml = "1/chapter20.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>

  <div id="part_21">
<?php 
$xml = "1/chapter21.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>

  <div id="part_22">
<?php 
$xml = "1/chapter22.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>


  <div id="part_23">
<?php 
$xml = "1/chapter23.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>

  <div id="part_24">
<?php 
$xml = "1/chapter24.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>
  <div id="part_25">
<?php 
$xml = "1/chapter25.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>
  <div id="part_26">
<?php 
$xml = "1/chapter26.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>


  <div id="part_27">
<?php 
$xml = "1/chapter27.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>

  <div id="part_28">
<?php 
$xml = "1/chapter28.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>
  <div id="part_29">
<?php 
$xml = "1/chapter29.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>
  <div id="part_30">
<?php 
$xml = "1/chapter30.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>

  <div id="part_31">
<?php 
$xml = "1/chapter31.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>

  <div id="part_32">
<?php 
$xml = "1/chapter32.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>

  <div id="part_33">
<?php 
$xml = "1/chapter33.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>
  <div id="part_34">
<?php 
$xml = "1/chapter34.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>
  <div id="part_35">
<?php 
$xml = "1/chapter35.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>

  <div id="part_36">
<?php 
$xml = "1/chapter36.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>

  <div id="part_37">
<?php 
$xml = "1/chapter37.xhtml";
echo transDoc($xml,$xsl);
?>

 </div>