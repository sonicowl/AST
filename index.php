<!DOCTYPE html>
<html lang=en>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	
<!-- TODO MINIFY JAVASCRIPT -->
<script>
var toc;
</script>
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
var nupages;
var currentpar = 1;
var audio;
var reader;
var tt1;
var tt2;
var isPlaying;
var turned = false;
var pagenumber = 1;
var myPages=new Array();
var myTimes=new Array();
var mySelPar=new Array();
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
			pageDiv = reader.visiblePages()[0];
			doc = pageDiv.m.activeFrame.contentDocument;
			parag = doc.getElementsByTagName('p');
			for (var y=0; y<parag.length;y++){
				parag[y].innerHTML = parag[y].innerHTML.replace("background-color: #FFFB0F","background-color: #FFFFFF");
			}
			turned = false;
			document.getElementById("top_audio").setAttribute("style","background: url(monocle/styles/btn_play.png)");
		}else{
			isPlaying = true;
		    //console.log("mySelPar2[0] " + mySelPar[0]);
			//console.log("mySelPar2[1] " + mySelPar[1]);
			//console.log("mySelPar2[2] " + mySelPar[2]);
			//console.log("mySelPar2[3] " + mySelPar[3]);
			console.log("checked turned " + turned);
		    if (turned == true) {
		    if (typeof mySelPar[pagenumber-1]  == 'undefined')  currentpar = 1; else currentpar= mySelPar[pagenumber-1];
			turned = false;
			
		}
            
		 
		    //reader.moveTo({ xpath: '//p['+currentpar+']' });
		    console.log("moveTo Paragraph: " + (mySelPar[pagenumber-1]));
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
	currentpar = 1;
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
	console.log("SeekTo " + t);
	if (t == 0) timeaux = 0; else timeaux = timeline[t].start.toString()
	time = time2secs(timeaux);
	
	try {
	  audio.pause();
	console.log("turned " + turned);
	  if (turned == true) audio.currentTime = myTimes[pagenumber]; else  audio.currentTime = time;
 	  audio.play();    
   
	} catch (e) {

	}
	console.log("runProcess " + t);
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
		if (pagenumber !== (place.pageNumber() - 1)) turned = true;
		pagenumber = place.pageNumber() - 1;
		document.getElementById('pagenum').innerHTML = "Page "+ pagenumber;
		nupages = place.countPage();
	
		
		if (typeof myPages[pagenumber]  !== 'undefined') currentpar = myPages[pagenumber-1]-2;
		
		//alert(currentpar);
	});



    var readerOptions = {
      panels: Monocle.Panels.IMode
    };


    Monocle.Reader('reader', bookData, readerOptions, function (rdr) {
      reader = rdr;
      toc = Monocle.Controls.Contents(rdr);
      rdr.addControl(toc, 'popover', { hidden: true });


  	// /* MENU CONTROL */
  	//     var menu = new Monocle.Controls.Menu(rdr);
  	//     rdr.addControl(menu);

  	/* SCRUBBER CONTROL */
  	    var scrubber = new Monocle.Controls.Scrubber(rdr);
  	    rdr.addControl(scrubber);
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
pageDiv = reader.visiblePages()[0];
doc = pageDiv.m.activeFrame.contentDocument;
part1 = document.getElementById('part1');
pArr = part1.getElementsByTagName("p");


if (typeof myPages[0]  == 'undefined') {
	for (var xx=0; xx<pArr.length-1;xx++){
		if (xx !== 0) {
		    node1 = doc.evaluate('//p['+(xx-1)+']', doc, null, 9, null).singleNodeValue;
		    percent1 = pageDiv.m.dimensions.percentageThroughOfNode(node1);
		    pag1 =Math.floor(percent1 * nupages);
	    }

		node2 = doc.evaluate('//p['+xx+']', doc, null, 9, null).singleNodeValue;
		percent2 = pageDiv.m.dimensions.percentageThroughOfNode(node2);
		pag2 =Math.floor(percent2 * nupages);

		if (xx !== pArr.length){
			node3 = doc.evaluate('//p['+(xx+1)+']', doc, null, 9, null).singleNodeValue;
			percent3 = pageDiv.m.dimensions.percentageThroughOfNode(node3);
			pag3 =Math.floor(percent3 * nupages);
		}

		if (typeof myPages[pag2]  !== 'undefined') {
			myPages[pag2] =  myPages[pag2] + 1; 
		}
		else{ 
			if (typeof pag1  !== 'undefined') {
				myPages[pag2] = myPages[pag1] + 1;
			}
			else{
				myPages[pag2] = 0;
			}
		}
	}

}



console.log("myPages2[0] " + myPages[0]);
console.log("myPages2[1] " + myPages[1]);
console.log("myPages2[2] " + myPages[2]);
console.log("myPages2[3] " + myPages[3]);
console.log("myPages2[4] " + myPages[4]);

for (var xx=0; xx<nupages-1;xx++){
	if (xx == 0) {
		myTimes[0] = 0;
		mySelPar[0] = 1;
	}

   	if (xx !== 0) {
	    node1 = doc.evaluate('//p['+(myPages[xx-1])+']', doc, null, 9, null).singleNodeValue;
	    percent1 = pageDiv.m.dimensions.percentageThroughOfNode(node1);
	    pag1 =Math.floor(percent1 * nupages);

		node2 = doc.evaluate('//p['+(myPages[xx-1]+1)+']', doc, null, 9, null).singleNodeValue;
		percent2 = pageDiv.m.dimensions.percentageThroughOfNode(node2);
		pag2 =Math.floor(percent2 * nupages);
        
		b1 = node1.getBoundingClientRect().bottom;   
		b2 = node2.getBoundingClientRect().bottom;

		t1 = node1.getBoundingClientRect().top;
		t2 = node2.getBoundingClientRect().top;

		h1 = node1.getBoundingClientRect().height;
		h2 = node2.getBoundingClientRect().height;

		tt1 = timeline[(myPages[xx-1])].start;
		tt2 = timeline[(myPages[xx-1]+1)].start;

		time1 = time2secs(tt1);
		time2 = (time2secs(tt2)-time1);

		//If the top of the next paragraph is zero, that means it start on the begging of the next page.
		if (t2==0) {
			myTimes[xx] = time2secs(timeline[(myPages[xx-1]+1)].start);
			mySelPar[xx] = myPages[xx-1] + 1;
		} 

		//If the actual paragraph has the bottom more than 333, that means if ends on the next page, and has the most part of it on the current page.
		if (b1 > 333){
		    SizeOnActualPage = (333 - t1);
			SizeOnNextPage = (b1 - 333);
			newtime2 =  Math.floor((time2 * SizeOnActualPage) / (SizeOnActualPage + SizeOnNextPage));
			myTimes[xx] = (time2secs(timeline[(myPages[xx-1])].start) + newtime2);
			mySelPar[xx] = myPages[xx-1];
		}

		//If the next paragraph has the bottom less than 0, that means if ends on the next page, and has the most part of it on the next page.
		if (t2 < 0){
            SizeOnActualPage = (t2 * -1);
			SizeOnNextPage = b2;
			newtime2 =  Math.floor((time2 * SizeOnActualPage) / (SizeOnActualPage + SizeOnNextPage));
			myTimes[xx] = (time2secs(timeline[(myPages[xx-1])].start) + newtime2);
			mySelPar[xx] = myPages[xx-1] + 1;
		}
		//console.log("foi " + b1 );
	}



}

console.log("myTimes[0] " + myTimes[0]);
console.log("myTimes[1] " + myTimes[1]);
console.log("myTimes[2] " + myTimes[2]);
console.log("myTimes[3] " + myTimes[3]);
console.log("myTimes[4] " + myTimes[4]);



console.log("mySelPar1[0] " + mySelPar[0]);
console.log("mySelPar1[1] " + mySelPar[1]);
console.log("mySelPar1[2] " + mySelPar[2]);
console.log("mySelPar1[3] " + mySelPar[3]);
console.log("mySelPar1[4] " + mySelPar[4]);



t2 = timeline[i].start;
t1 = timeline[i-1].start;
time1 = time2secs(t1);
time2 = ((time2secs(t2)-time1) * 1000);
if (i!=1) {
	node1 = doc.evaluate('//p['+(i-1)+']', doc, null, 9, null).singleNodeValue;
	percent1 = pageDiv.m.dimensions.percentageThroughOfNode(node1);
	pag1 =Math.floor(percent1 * nupages)+1;

	node2 = doc.evaluate('//p['+i+']', doc, null, 9, null).singleNodeValue;
	percent2 = pageDiv.m.dimensions.percentageThroughOfNode(node2);
	pag2 =Math.floor(percent2 * nupages)+1;

	node3 = doc.evaluate('//p['+(i+1)+']', doc, null, 9, null).singleNodeValue;
	percent3 = pageDiv.m.dimensions.percentageThroughOfNode(node3);
	pag3 =Math.floor(percent3 * nupages)+1;

	b1 = node1.getBoundingClientRect().bottom;
	b2 = node2.getBoundingClientRect().bottom;
	b3 = node2.getBoundingClientRect().bottom;

	t1 = node1.getBoundingClientRect().top;
	t2 = node2.getBoundingClientRect().top;
	t3 = node3.getBoundingClientRect().top;

	h1 = node1.getBoundingClientRect().height;
	h2 = node2.getBoundingClientRect().height;
	h3 = node3.getBoundingClientRect().height;

	//means it starts in the current page and ends on the next, the most part of the text is on the current page
	if (((pag2+1) == pag3) && (t3 > 0)) {
			SizeOnActualPage = (333 - t2);
			SizeOnNextPage = (b2 - 333);
			newtime2 =  Math.floor((time2 * SizeOnActualPage) / (SizeOnActualPage + SizeOnNextPage));
		    clearTimeout(tt2);
			//Processo da pagina
			//alert('page1-'+(pag2+1).toString());
			tt2 = setTimeout("reader.moveTo({ page: "+(pag2+1)+" })",newtime2);	
	}

	//means it starts in the current page and ends on the next, the most part of the text is on the next page
	//or means it starts in the current page and ends on the next, the most part of the text is on the next page, and the next page has a paragraph that ends after the next page and the most of text are on that page
	if (((pag2 == pag3) && (t2 < 0)) || (((pag2+1) == pag3) && (t2 < 0) && (t3 < 0))) {
			SizeOnActualPage = (t2 * -1);
			SizeOnNextPage = b2;
			newtime2 =  Math.floor((time2 * SizeOnActualPage) / (SizeOnActualPage + SizeOnNextPage));
			clearTimeout(tt2);
			//Processo da pagina
			//alert('page2-'+pag2.toString());
			tt2 = setTimeout("reader.moveTo({ page: "+pag2+" })",newtime2);
		    //alert(newtime2);
	}
	if (t2 == 0){reader.moveTo({ page: pag2 })}
}


    clearTimeout(tt1);
	//alert('par2-'+i.toString());
	//Processo do paragrapho.
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
pArr[i].innerHTML = "<span style='background-color: #FFFFFF' onclick='javascript:top.seekTo(&quot;"+i.toString()+"&quot;);'>"+ (i+1).toString()+": " + pArr[i].innerHTML+ "</a>";
}


</script>

</body>
</html>






