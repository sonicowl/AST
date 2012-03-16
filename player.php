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

<title>Simple Audio Player</title>
<script src="data.php"></script>
<script>
var runningT;
var audio;
function init(){
	console.log("init");
	window.reader = Monocle.Reader('reader');
	audio = document.getElementById("audio");
	
	audio.addEventListener("abort", 		function () {	debug(arguments, "abort"); });
	audio.addEventListener("canplay", 		function () {	debug(arguments, "canplay"); });
	audio.addEventListener("canplaythrough", 	function () {	debug(arguments, "canplaythrough"); });
	audio.addEventListener("durationchange", 	function () {	debug(arguments, "durationchange"); });
	audio.addEventListener("emptied", 		function () {	debug(arguments, "emptied"); });
	audio.addEventListener("ended", 		function () {	debug(arguments, "ended"); });
	audio.addEventListener("error", 		function () {	debug(arguments, "error"); });
	audio.addEventListener("loadeddata", 		function () {	debug(arguments, "loadeddata"); });
	audio.addEventListener("loadedmetadata", 	function () {	debug(arguments, "loadedmetadata"); });
	audio.addEventListener("loadstart", 		function () {	debug(arguments, "loadstart"); });
	audio.addEventListener("pause", 		function () {	debug(arguments, "pause"); });
	audio.addEventListener("play", 			function () {	debug(arguments, "play"); });
	audio.addEventListener("playing", 		function () {	debug(arguments, "playing"); });
	audio.addEventListener("progress", 		function () {	debug(arguments, "progress"); });
	audio.addEventListener("ratechange", 		function () {	debug(arguments, "ratechange"); });
	audio.addEventListener("readystatechange", 	function () {	debug(arguments, "readystatechange"); });
	audio.addEventListener("seeked", 		function () {	debug(arguments, "seeked"); });
	audio.addEventListener("seeking", 		function () {	debug(arguments, "seeking"); });
	audio.addEventListener("stalled", 		function () {	debug(arguments, "stalled"); });
	audio.addEventListener("suspend", 		function () {	debug(arguments, "suspend"); });
	audio.addEventListener("volumechange", 		function () {	debug(arguments, "volumechange"); });
	audio.addEventListener("waiting", 		function () {	debug(arguments, "waiting"); });
	audio.addEventListener("timeupdate", 		function () {	update(arguments); });
	
		audio.play();
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
	//status.innerHTML = audio.currentTime + "<br />";
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
	audio.currentTime = time;
	audio.pause();
	audio.play();
	if (runningT == true){
	   runningT = false;
	   startRun(t);
	}
	else{
	   runningT = true;
	   startRunT(t);
	}

}

</script>

<body onload="init()">
<div id="currentpar"></div>
<div id="pagenum"></div>


<div>
	<audio controls id="audio">
		<source type="audio/mp3" preload="metadata" src="video.php"/>
		Your browser does not support HTML5 audio.
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
    runningT = false;
	startRun(i);	
}

function startRunT(i)
	{
		console.log("startRunT: " + runningT.toString());
	i=Number(i) + 1;
	if ((timeline.length > i) && (runningT == true)){
				var t2 = timeline[i].start;
	            var t1 = timeline[i-1].start;
		        var time1 = time2secs(t1);
	        	var time2 = ((time2secs(t2)-time1) * 1000);
				var pageDiv = reader.visiblePages()[0];
				var doc = pageDiv.m.activeFrame.contentDocument;//contentWindow
				var parag = doc.getElementsByTagName('p');
			//	alert('1');
				for (var y=0; y<parag.length;y++){
						if (y!=(i-1))
							parag[y].innerHTML = parag[y].innerHTML.replace("background-color: #FFFB0F","background-color: #FFFFFF");
						else
						    parag[y].innerHTML = parag[y].innerHTML.replace("background-color: #FFFFFF","background-color: #FFFB0F");
				}
			
				document.getElementById('currentpar').innerHTML = "HMP "+parag.length+", Paragraph "+i.toString()+", Next "+t2;
			   // if (running == false)	setTimeout("startRunT("+(i-1).toString()+")",time2);
			    	setTimeout("startRunT("+i.toString()+")",time2);
	}


	}
	
	
function startRun(i)
{
	console.log("startRunT: " + runningT.toString());
	i=Number(i) + 1;
	
if ((timeline.length > i) && (runningT == false)){
        	var t2 = timeline[i].start;
            var t1 = timeline[i-1].start;
	        var time1 = time2secs(t1);
        	var time2 = ((time2secs(t2)-time1) * 1000);
			var pageDiv = reader.visiblePages()[0];
			var doc = pageDiv.m.activeFrame.contentDocument;//contentWindow
			var parag = doc.getElementsByTagName('p');
			//var place = reader.getPlace(pageDiv);
			//var pgcount = reader.dom.find('page', 0).contentDocument;
		    //var doc = reader.dom.find('page', 0).m.activeFrame.contentDocument;
			//var doccon = doc.innerHTML;//contentWindow
  	        //var cmpt = reader.dom.find('component');
		    //var doc = cmpt.contentWindow;
            
			document.getElementById('currentpar').innerHTML = "HMP "+parag.length+", Paragraph "+i.toString()+", Next "+t2;
			setTimeout("startRun("+i.toString()+")",time2);
	  	    //if (running == true) setTimeout("running = true;",time2);
				for (var y=0; y<parag.length;y++){
						if (y!=(i-1))
							parag[y].innerHTML = parag[y].innerHTML.replace("background-color: #FFFB0F","background-color: #FFFFFF");
						else
						    parag[y].innerHTML = parag[y].innerHTML.replace("background-color: #FFFFFF","background-color: #FFFB0F");
				}
		    
		   //var cmpt = window.reader.dom.find('p', 2);
		   //cmpt.style.color='red';
		   //document.getElementById('reader').innerHTML = "<p class='para'>Introduction</div></p>"
		   //reader.moveTo({ page: 2 });
		
}



}

 


	var pArr = document.getElementsByTagName("p");
	for (var i=0; i<pArr.length;i++){
		//	var but = document.createElement("button");
	//		var txt = document.createTextNode(timeline[i].start);
	//		but.appendChild(txt);
	//		but.onclick = function(){seekTo(this.firstChild.nodeValue);};
	//	   pArr[i].insertBefore(but,pArr[i].firstChild);
	


	
	pArr[i].innerHTML = "<span onclick='javascript:top.seekTo(&quot;"+i.toString()+"&quot;)'>"+ pArr[i].innerHTML+ "</a>";
	
//		pArr[i].innerHTML = "<span onclick=&quot;javascript:seekTo("'"+timeline[i].start.toString()+"'")'&quot;>"+ pArr[i].innerHTML+ "</a>";
	//	document.getElementById('pagenum').innerHTML = "sd";
	}
	

	
	
	
</script>
  
</body>

</html>






