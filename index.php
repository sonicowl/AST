<!DOCTYPE html>
<html lang=en>
<head>
 <script src="monocle/scripts/monocore.js"></script>
 <!-- MONOCLE CORE -->
    
    <script type="text/javascript" src="src/compat/env.js"></script>
    <script type="text/javascript" src="src/compat/css.js"></script>
    <script type="text/javascript" src="src/compat/stubs.js"></script>
    <script type="text/javascript" src="src/compat/browser.js"></script>

    <script type="text/javascript" src="src/core/events.js"></script>
    <script type="text/javascript" src="src/core/factory.js"></script>
    <script type="text/javascript" src="src/core/styles.js"></script>
    <script type="text/javascript" src="src/core/reader.js"></script>
    <script type="text/javascript" src="src/core/book.js"></script>
    <script type="text/javascript" src="src/core/component.js"></script>
    <script type="text/javascript" src="src/core/place.js"></script>

 <!-- MONOCLE FLIPPERS -->
    <script type="text/javascript" src="src/controls/panel.js"></script>
    <script type="text/javascript" src="src/dimensions/columns.js"></script>
    <script type="text/javascript" src="src/flippers/slider.js"></script>
    <script type="text/javascript" src="src/dimensions/vert.js"></script>
    <script type="text/javascript" src="src/flippers/legacy.js"></script>

 <!-- MONOCLE STANDARD CONTROLS -->
   <script type="text/javascript" src="src/controls/spinner.js"></script>
    <script type="text/javascript" src="src/controls/magnifier.js"></script>

    <script type="text/javascript" src="src/controls/scrubber.js"></script>
    <script type="text/javascript" src="src/controls/placesaver.js"></script>
    <script type="text/javascript" src="src/controls/contents.js"></script>
  <link rel="stylesheet" type="text/css" href="monocle/styles/monocore.css" />
  <link rel="stylesheet" type="text/css" href="monocle/styles/monoctrl.css" />
  <style>
    #reader { width: 300px; height: 400px; border: 1px solid #000; }
  </style>
<meta charset="UTF-8">

<title>AST</title>
<script src="data.php"></script>
<script>
var dontturn;
var runningP0;
var runningP1;
var runningP2;
var runningP3;
var runningP4;
var runningP5;
var runningP6;
var runningP7;
var runningP8;
var runningP9;
var audio;
function init(){
	console.log("init");
	window.reader = Monocle.Reader('reader');
	audioz = document.getElementById("audio");
	
	audioz.addEventListener("abort", 		function () {	debug(arguments, "abort"); });
	audioz.addEventListener("canplay", 		function () {	debug(arguments, "canplay"); });
	audioz.addEventListener("canplaythrough", 	function () {	debug(arguments, "canplaythrough"); });
	audioz.addEventListener("durationchange", 	function () {	debug(arguments, "durationchange"); });
	audioz.addEventListener("emptied", 		function () {	debug(arguments, "emptied"); });
	audioz.addEventListener("ended", 		function () {	debug(arguments, "ended"); });
	audioz.addEventListener("error", 		function () {	debug(arguments, "error"); });
	audioz.addEventListener("loadeddata", 		function () {	debug(arguments, "loadeddata"); });
	audioz.addEventListener("loadedmetadata", 	function () {	debug(arguments, "loadedmetadata"); });
	audioz.addEventListener("loadstart", 		function () {	debug(arguments, "loadstart"); });
	audioz.addEventListener("pause", 		function () {	debug(arguments, "pause"); });
	audioz.addEventListener("play", 			function () {	debug(arguments, "play"); });
	audioz.addEventListener("playing", 		function () {	debug(arguments, "playing"); });
	audioz.addEventListener("progress", 		function () {	debug(arguments, "progress"); });
	audioz.addEventListener("ratechange", 		function () {	debug(arguments, "ratechange"); });
	audioz.addEventListener("readystatechange", 	function () {	debug(arguments, "readystatechange"); });
	audioz.addEventListener("seeked", 		function () {	debug(arguments, "seeked"); });
	audioz.addEventListener("seeking", 		function () {	debug(arguments, "seeking"); });
	audioz.addEventListener("stalled", 		function () {	debug(arguments, "stalled"); });
	audioz.addEventListener("suspend", 		function () {	debug(arguments, "suspend"); });
	audioz.addEventListener("volumechange", 		function () {	debug(arguments, "volumechange"); });
	audioz.addEventListener("waiting", 		function () {	debug(arguments, "waiting"); });
	audioz.addEventListener("timeupdate", 		function () {	update(arguments); });
	dontturn = false;
	runningP0 = false;
 	runningP1 = false;
 	runningP2 = false;
 	runningP3 = false;
 	runningP4 = false;
 	runningP5 = false;
 	runningP6 = false;
	runningP7 = false;
 	runningP8 = false;
 	runningP9 = false;
	startRunP(0);
	//var place = reader.getPlace();
    //document.getElementById('currentpar').innerHTML = place.chapterTitle();
	//reader.addControl(new Monocle.Controls.Scrubber(reader)) 

		reader.listen(
		'monocle:pagechange',
		function (evt) {
		var place = reader.getPlace(evt.m.page);
		var section = place.componentId();
		var chapterInfo = place.chapterInfo();
		var chapterSrc = place.chapterSrc();
		var pageTopPos = place.percentAtTopOfPage();
		var pageBottomPos = place.percentAtBottomOfPage();
		var pagenumber = place.pageNumber() - 1;
		document.getElementById('pagenum').innerHTML = "Page "+ pagenumber;
		
	
		});
		
	

		  /* MAGNIFIER CONTROL */
          var magnifier = new Monocle.Controls.Magnifier(reader);
          reader.addControl(magnifier, 'page');





//setTimeout("reader.moveTo({ direction: 1 })",6000);

}



function update(){
	var status = document.getElementById("status");
	//status.innerHTML = audioz.currentTime + "<br />";
	for (var i=0; i<timeline.length; i++){
		
	}
}

function time2secs(t){
	var secs = (Number(t.toString().substr(0,2))*3600) + (Number(t.toString().substr(3,2))*60) + (Number(t.toString().substr(6,2)));
	return Number(secs) + Number(timeline.offset);
}

function debug(args,msg){
	var t = "";
	for (var o in args[0]){
		t += o + " " + args[0][o];
	}

	console.log(args.length + " - " + msg);
}


timeline.offset = 0;

function seekTo(t){	
	var time = time2secs(timeline[t].start.toString());
	try {
	  audioz.pause();
	  audioz.currentTime = time;
	  audioz.play();      
	} catch (e) {

	}
    dontturn = true;
	if (runningP9 == true) { runningP9 = false; runningP1 = true; runProcess1(t); }
	if (runningP8 == true) { runningP8 = false; runningP9 = true; runProcess9(t); }
	if (runningP7 == true) { runningP7 = false; runningP8 = true; runProcess8(t); }
	if (runningP6 == true) { runningP6 = false; runningP7 = true; runProcess7(t); }
	if (runningP5 == true) { runningP5 = false; runningP6 = true; runProcess6(t); }
	if (runningP4 == true) { runningP4 = false; runningP5 = true; runProcess5(t); }
	if (runningP3 == true) { runningP3 = false; runningP4 = true; runProcess4(t); }
	if (runningP2 == true) { runningP2 = false; runningP3 = true; runProcess3(t); }
	if (runningP1 == true) { runningP1 = false; runningP2 = true; runProcess2(t); }
	if (runningP0 == true) { runningP0 = false; runningP1 = true; runProcess1(t); }
    dontturn = false;
}

</script>

<body onload="init()">
<div id="currentpar"></div>
<div id="pagenum"></div>


<div>
	<audio controls id="audio">
		<source type="audio/mp3" preload="metadata" src="video.php"/>
		Your browser does not support HTML5 audioz.
	</audio>
</div>

<div id="status"></div>

<div id="reader">
<?php include("epub.php"); ?>
</div>

<div onclick="reader.moveTo({ direction: -1 }); ">Previous page</div>
<div onclick="reader.moveTo({ direction: 1 }); ">Next page</div>


<script>
document.getElementById('currentpar').innerHTML = "Paragraph 1, Next 0";

function startRunP(i){
    runningP0 = true;
	runProcess0(i);	
}

function runProcess(i, processname){
	var t2 = timeline[i].start;
    var t1 = timeline[i-1].start;
    var time1 = time2secs(t1);
	var time2 = ((time2secs(t2)-time1) * 1000);
	var pageDiv = reader.dom.find('component', 1);
	var doc = pageDiv.contentDocument;//contentWindow
	var node = doc.evaluate('//p['+i+']', doc, null, 9, null).singleNodeValue;
	var parag = doc.getElementsByTagName('p');
    //alert(node);
	for (var y=0; y<parag.length;y++){
			if (y!=(i-1))
				parag[y].innerHTML = parag[y].innerHTML.replace("background-color: #FFFB0F","background-color: #FFFFFF");
			else
			    parag[y].innerHTML = parag[y].innerHTML.replace("background-color: #FFFFFF","background-color: #FFFB0F");
	}			
	document.getElementById('currentpar').innerHTML = "HMP "+parag.length+", Paragraph "+i.toString()+", Next "+t2;
	if (dontturn == false) reader.moveTo({ xpath: '//p['+i+']' });
	setTimeout(processname + "("+i.toString()+")",time2);

}

function runProcess0(i)
	{
		i=Number(i) + 1;
	    if ((timeline.length > i) && (runningP0 == true)){
			console.log("Running process 0")
			runProcess(i, "runProcess0");
		}
	}

function runProcess1(i)
	{
		
		i=Number(i) + 1;
	    if ((timeline.length > i) && (runningP1 == true)){
			console.log("Running process 1")
			runProcess(i, "runProcess1");
		}
	}

function runProcess2(i)
	{
		i=Number(i) + 1;
	    if ((timeline.length > i) && (runningP2 == true)){
			console.log("Running process 2")
			runProcess(i, "runProcess2");
		}
	}

function runProcess3(i)
	{
		i=Number(i) + 1;
	    if ((timeline.length > i) && (runningP3 == true)){
			console.log("Running process 3")
			runProcess(i, "runProcess3");
		}
	}

function runProcess4(i)
	{
		i=Number(i) + 1;
	    if ((timeline.length > i) && (runningP4 == true)){
			console.log("Running process 4")
			runProcess(i, "runProcess4");
		}
	}

function runProcess5(i)
	{
		i=Number(i) + 1;
	    if ((timeline.length > i) && (runningP5 == true)){
			console.log("Running process 5")
			runProcess(i, "runProcess5");
		}
	}

function runProcess6(i)
	{
		i=Number(i) + 1;
	    if ((timeline.length > i) && (runningP6 == true)){
			console.log("Running process 6")
			runProcess(i, "runProcess6");
		}
	}

function runProcess7(i)
	{
		i=Number(i) + 1;
	    if ((timeline.length > i) && (runningP7 == true)){
			console.log("Running process 7")
			runProcess(i, "runProcess7");
		}
	}

function runProcess8(i)
	{
		i=Number(i) + 1;
	    if ((timeline.length > i) && (runningP8 == true)){
			console.log("Running process 8")
			runProcess(i, "runProcess8");
		}
	}

function runProcess9(i)
	{
		i=Number(i) + 1;
	    if ((timeline.length > i) && (runningP9 == true)){
			console.log("Running process 9")
			runProcess(i, "runProcess9");
		}
	}
	
var pArr = document.getElementsByTagName("p");
for (var i=0; i<pArr.length;i++){
	pArr[i].innerHTML = "<span onclick='javascript:top.seekTo(&quot;"+i.toString()+"&quot;)'>"+ pArr[i].innerHTML+ "</a>";
}


	
	
//function runProcess1(i)
//{
//	console.log("startRunT: " + runningT.toString());
//	i=Number(i) + 1;
	
//if ((timeline.length > i) && (runningT == false)){
  //      	var t2 = timeline[i].start;
    //        var t1 = timeline[i-1].start;
	  //      var time1 = time2secs(t1);
      // / 	var time2 = ((time2secs(t2)-time1) * 1000);
//			var pageDiv = reader.visiblePages()[0];
//			var doc = pageDiv.m.activeFrame.contentDocument;//contentWindow
//			var parag = doc.getElementsByTagName('p');
			//var place = reader.getPlace(pageDiv);
			//var pgcount = reader.dom.find('page', 0).contentDocument;
		    //var doc = reader.dom.find('page', 0).m.activeFrame.contentDocument;
			//var doccon = doc.innerHTML;//contentWindow
  	        //var cmpt = reader.dom.find('component');
		    //var doc = cmpt.contentWindow;
            
//			document.getElementById('currentpar').innerHTML = "HMP "+parag.length+", Paragraph "+i.toString()+", Next "+t2;
//			for (var y=0; y<parag.length;y++){
//					if (y!=(i-1))
//						parag[y].innerHTML = parag[y].innerHTML.replace("background-color: #FFFB0F","background-color: #FFFFFF");
//					else
//					    parag[y].innerHTML = parag[y].innerHTML.replace("background-color: #FFFFFF","background-color: #FFFB0F");
//			}
//			setTimeout("startRun("+i.toString()+")",time2);
	  	    //if (running == true) setTimeout("running = true;",time2);

		    
		   //var cmpt = window.reader.dom.find('p', 2);
		   //cmpt.style.color='red';
		   //document.getElementById('reader').innerHTML = "<p class='para'>Introduction</div></p>"
		   //reader.moveTo({ page: 2 });
		
//}



//}

 


	
		//	var but = document.createElement("button");
	//		var txt = document.createTextNode(timeline[i].start);
	//		but.appendChild(txt);
	//		but.onclick = function(){seekTo(this.firstChild.nodeValue);};
	//	   pArr[i].insertBefore(but,pArr[i].firstChild);
	


	
	
	
//		pArr[i].innerHTML = "<span onclick=&quot;javascript:seekTo("'"+timeline[i].start.toString()+"'")'&quot;>"+ pArr[i].innerHTML+ "</a>";
	//	document.getElementById('pagenum').innerHTML = "sd";
	
	

	
</script>
  
</body>

</html>






