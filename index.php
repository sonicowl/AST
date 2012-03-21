<!DOCTYPE html>
<html lang=en>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	
<!-- TODO MINIFY JAVASCRIPT -->

 <!-- MONOCLE CORE -->
 <script type="text/javascript" src="src/core/monocle.js"></script>
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
 <script type="text/javascript" src="src/panels/twopane.js"></script>
 <script type="text/javascript" src="src/panels/marginal.js"></script>
 <script type="text/javascript" src="src/panels/imode.js"></script>
 <script type="text/javascript" src="src/panels/eink.js"></script>
 <script type="text/javascript" src="src/dimensions/columns.js"></script>
 <script type="text/javascript" src="src/flippers/slider.js"></script>
 <script type="text/javascript" src="src/flippers/instant.js"></script>
 <script type="text/javascript" src="src/dimensions/vert.js"></script>
 <script type="text/javascript" src="src/flippers/legacy.js"></script>

 <!-- MONOCLE STANDARD CONTROLS -->
<script type="text/javascript" src="src/controls/spinner.js"></script>
<script type="text/javascript" src="src/controls/menu.js"></script>

<script type="text/javascript" src="src/controls/magnifier.js"></script>
<script type="text/javascript" src="src/controls/scrubber.js"></script>
<script type="text/javascript" src="src/controls/placesaver.js"></script>
<script type="text/javascript" src="src/controls/contents.js"></script>

<link rel="stylesheet" type="text/css" href="monocle/styles/monocore.css" />
<link rel="stylesheet" type="text/css" href="monocle/styles/monoctrl.css" />

<style>
  #reader { width: 320px; height: 358px; }

  #part1 {display:none}
  .bookTitle {
    position: absolute;
    top: 0;
    width: 100%;
	padding:1px;
    text-align: center;
    cursor: pointer;
	font-size:0.8em;
	color:#cc0000;
  }
  #main_audio{display:none}
</style>

<meta charset="UTF-8">

<title>AST</title>

<script src="data.php"></script>

<script>

/* GLOBAL VARIABLES */
var currentpar = 1;
var audio;
var reader;
var tt1;
var tt2;
var isPlaying;
var isFirstTime;
function init(){
	// console.log("init");
	// window.reader = Monocle.Reader('reader');
	
	//Hide the address bar
	audio = document.getElementById("audio");

	function fullscreen(){
		var a=document.getElementsByTagName("a");
		for(var i=0;i<a.length;i++){
			if(a[i].className.match("noeffect")){
			
			}
			else{a[i].onclick=function(){
				window.location=this.getAttribute("href");
				return false;
			}}
		}
	}
		
	function hideURLbar(){
		window.scrollTo(0,0.9)
	}
	fullscreen();
	hideURLbar();

	
	//Audio Control
	document.getElementById('top_audio').onclick = function(e){
		if (isPlaying == true){
			isPlaying = false;
			audio.pause();
			clearTimeout(tt1);
			clearTimeout(tt2);
			document.getElementById("top_audio").setAttribute("style","background: url(monocle/styles/btn_play.png)");
		}else{
			isPlaying = true;
		    //alert((currentpar + 1));
		    seekTo(currentpar - 1);	
			document.getElementById("top_audio").setAttribute("style","background: url(monocle/styles/btn_pause.png)");
		}
	}
	
	//Audio Control
	document.getElementById('top_home_btn').onclick = function(e){
		window.location = "home.php"
	}

	
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
	var timeaux;
	//alert(i);
	if (i == 1) timeaux = 0; else timeaux = timeline[t].start.toString()
	time = time2secs(timeaux);
	try {
	  audio.pause();
	  audio.currentTime = time;
	  audio.play();    
   
	} catch (e) {

	}
    runProcess(t);
 
}

//*TODO = GET BOOK DATA FROM ALL CHAPTERS *//

var bookData = {
  getComponents: function () {
    return [
      'part1'
    ];
  },
  getContents: function () {
    return [
      {
        title: "I",
        src: 'part1'
      }
    ]
  },
  getComponent: function (cmptId) {
    return { nodes: [document.getElementById(cmptId).cloneNode(true)] };
  },
  getMetaData: function(key) {
    return {
      title: "Practical Demonkeeping",
      creator: "Sonic Owl"
    }[key];
  }
}


function createBookTitle(reader, contactListeners) {
  var bt = {}
  bt.createControlElements = function () {
    cntr = document.createElement('div');
    cntr.className = "bookTitle";
    runner = document.createElement('div');
    runner.className = "runner";
    runner.innerHTML = reader.getBook().getMetaData('title');
    cntr.appendChild(runner);
    if (contactListeners) {
      Monocle.Events.listenForContact(cntr, contactListeners);
    }
    return cntr;
  }
  reader.addControl(bt, 'page');
  return bt;
}

// Initialize the reader element.
Monocle.Events.listen(
  window,
  'load',
  function () {

    // I-MODE
    window.reader = Monocle.Reader(
      'reader',
      bookData,
      { panels: Monocle.Panels.IMode }
    );

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



    var readerOptions = {
      panels: Monocle.Panels.IMode
    };


    Monocle.Reader('reader', bookData, readerOptions, function (rdr) {
      reader = rdr;
      var toc = Monocle.Controls.Contents(rdr);
      rdr.addControl(toc, 'popover', { hidden: true });


  	// /* MENU CONTROL */
  	//     var menu = new Monocle.Controls.Menu(rdr);
  	//     rdr.addControl(menu);

  	/* SCRUBBER CONTROL */
  	//     var scrubber = new Monocle.Controls.Scrubber(rdr);
  	//     rdr.addControl(scrubber);
  	// 
  	// /* MAGNIFIER CONTROL */
  	//     var magnifier = new Monocle.Controls.Magnifier(rdr);
  	//     rdr.addControl(magnifier);
  	// 
  	// /* TOC CONTROL */
  	//     var readerOptions = {
  	//       panels: Monocle.Panels.IMode
  	//     };
  	// 
  	//       createBookTitle(
  	//         rdr,
  	//         {
  	//           start: function () {
  	//             rdr.showControl(toc);
  	//           }
  	//         }
  	//       );

    });


  }
);

</script>

<body style="padding:0; margin:0" onload="init()">
	<div id="currentpar" style="display:none"></div>
	<div id="pagenum" style="display:none"></div>

<div id="main_audio">
	<audio controls id="audio">
		<source type="audio/mp3" preload="metadata" src="video.php"/>
		Your browser does not support HTML5 audio.
	</audio>
</div>

<div id="status"></div>

<div id="topMenu">
	<div id="top_home_btn"></div>
	<div id="top_title">Chapter Title</div>
	<div id="top_audio"></div>
	<div style="clear:both"></div>
</div>

<div id="reader">

</div>

<!-- <div onclick="reader.moveTo({ direction: -1 }); ">Previous page</div>
<div onclick="reader.moveTo({ direction: 1 }); ">Next page</div> -->

  <div id="part1">
	<?php include("epub.php"); ?>
 </div>


<script>

document.getElementById('currentpar').innerHTML = "Paragraph 1, Next 0";

function runProcess(i){
i=Number(i) + 1;
currentpar = i;
//alert(i);
pageDiv = reader.visiblePages()[0];
doc = pageDiv.m.activeFrame.contentDocument;
t2 = timeline[i].start;
t1 = timeline[i-1].start;
time1 = time2secs(t1);
time2 = ((time2secs(t2)-time1) * 1000);
if (i!=1) {
	node1 = doc.evaluate('//p['+(i-1)+']', doc, null, 9, null).singleNodeValue;
	paragraphcontents1 = node1.textContent;
	percent1 = pageDiv.m.dimensions.percentageThroughOfNode(node1);
	pag1 =Math.floor(percent1 * 30) + 2;

	node2 = doc.evaluate('//p['+i+']', doc, null, 9, null).singleNodeValue;
	paragraphcontents2 = node2.textContent;
	percent2 = pageDiv.m.dimensions.percentageThroughOfNode(node2);
	pag2 =Math.floor(percent2 * 30) + 2;

	node3 = doc.evaluate('//p['+(i+1)+']', doc, null, 9, null).singleNodeValue;
	paragraphcontents3 = node3.textContent;
	percent3 = pageDiv.m.dimensions.percentageThroughOfNode(node3);
	pag3 =Math.floor(percent3 * 30) + 2;

	b1 = node1.getBoundingClientRect().bottom;
	b2 = node2.getBoundingClientRect().bottom;
	b3 = node3.getBoundingClientRect().bottom;

	t1 = node1.getBoundingClientRect().top;
	t2 = node2.getBoundingClientRect().top;
	t3 = node3.getBoundingClientRect().top;

	h1 = node1.getBoundingClientRect().height;
	h2 = node2.getBoundingClientRect().height;
	h3 = node3.getBoundingClientRect().height;


	//If the next paragraph is all on the same page
	//if ((pag2 == pag3) && (b3<333) && (b3>0)) goto fim;

	//If the next paragraph is on the same page (the most), but the rest of the next paragraphg is on the next page.
	//if ((pag2 == pag3) && (b3>333))  goto fim;

	//If the next paragraph is on the next page, and the rest of the next paragraph is on the next page (the most)
	//if (((pag2+1) == pag3) && (t3 < 0)) goto fim;

	//means it starts in the current page and ends on the next, the most part of the text is on the current page
	if (((pag2+1) == pag3) && (t3 > 0)) {
			SizeOnActualPage = (333 - t2);
			SizeOnNextPage = (b2 - 333);
			newtime2 =  Math.floor((time2 * SizeOnActualPage) / (SizeOnActualPage + SizeOnNextPage));
		    clearTimeout(tt2);
			tt2 = setTimeout("reader.moveTo({ page: "+(pag2+1)+" })",newtime2);
			
	}

	//means it starts in the current page and ends on the next, the most part of the text is on the next page
	//or means it starts in the current page and ends on the next, the most part of the text is on the next page, and the next page has a paragraph that ends after the next page and the most of text are on that page
	if (((pag2 == pag3) && (t2 < 0)) || (((pag2+1) == pag3) && (t2 < 0) && (t3 < 0))) {
			SizeOnActualPage = (t2 * -1);
			SizeOnNextPage = b2;
			newtime2 =  Math.floor((time2 * SizeOnActualPage) / (SizeOnActualPage + SizeOnNextPage));
			clearTimeout(tt2);
			tt2 = setTimeout("reader.moveTo({ page: "+pag2+" })",newtime2);
		//	alert(newtime2);
	}
	

	if (t2 == 0){reader.moveTo({ page: pag2 })}

    
	//fim:	
}

clearTimeout(tt1);
tt1 = setTimeout("runProcess("+i.toString()+")",time2);

    parag = doc.getElementsByTagName('p');
	for (var y=0; y<parag.length;y++){
			if (y!=(i-1))
				parag[y].innerHTML = parag[y].innerHTML.replace("background-color: #FFFB0F","background-color: #FFFFFF");
			else
			    parag[y].innerHTML = parag[y].innerHTML.replace("background-color: #FFFFFF","background-color: #FFFB0F");
	}			
	//document.getElementById('currentpar').innerHTML = "HMP "+parag.length+", Paragraph "+i.toString()+", Next "+t2;

}

	part1 = document.getElementById('part1');
	pArr = part1.getElementsByTagName("p");
	for (var i=0; i<pArr.length;i++){
		pArr[i].innerHTML = "<span style='background-color: #FFFFFF' onclick='javascript:top.seekTo(&quot;"+i.toString()+"&quot;);'>"+ pArr[i].innerHTML+ "</a>";
	}


</script>

</body>
</html>






