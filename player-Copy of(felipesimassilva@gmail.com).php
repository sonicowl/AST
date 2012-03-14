<!DOCTYPE html>
<html lang=en>
<head>
	
  <script src="monocle/scripts/monocore.js"></script>
 <script type="text/javascript" src="src/monocle.js"></script> 
   
  <link rel="stylesheet" type="text/css" href="monocle/styles/monocore.css" />
  <style>
    #reader { width: 300px; height: 400px; border: 1px solid #000; }
  </style>
<meta charset="UTF-8">

<title>Simple Audio Player</title>
<script src="data.php"></script>
<script>

var audio;

function init(){
	console.log("init");

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



		window.reader = Monocle.Reader('reader');
		setTimeout(alert('d'),3000);

//setTimeout("reader.moveTo({ direction: 1 })",6000);

}
function gostart(){
	var pArr = document.getElementsByTagName("p");
	for (var i=0; i<pArr.length;i++){
	   pArr[i].innerHTML = pArr[i].innerHTML+"(";
	}
	alert('1');
}

function update(){
	var status = document.getElementById("status");
	//status.innerHTML = audio.currentTime + "<br />";
	for (var i=0; i<timeline.length; i++){
		
	}
}

function time2secs(t){
	var secs = (Number(t.substr(0,2))*3600) + (Number(t.substr(3,2))*60) + (Number(t.substr(6,2)));
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
	var time = time2secs(t);
	audio.currentTime = time;
	audio.pause();
	audio.play();
}

</script>

<body onload="init()">



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
<div onclick="reader.moveTo({ direction: -1 }); alert(reader.getPlace().pageNumber());">Previous page</div>
<div onclick="reader.moveTo({ direction: 1 }); alert(reader.getPlace().pageNumber());">Next page</div>
<script>


	var pArr = document.getElementsByTagName("p");
	for (var i=0; i<pArr.length;i++){
			var but = document.createElement("button");
			var txt = document.createTextNode(timeline[i].start);
			but.appendChild(txt);
			but.onclick = function(){seekTo(this.firstChild.nodeValue);};
		    pArr[i].insertBefore(but,pArr[i].firstChild);
	}


</script>
  
</body>

</html>






