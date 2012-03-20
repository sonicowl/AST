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

  #part1, #part2 {display:none}
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
var reader;
var currentParagraph = 1;
var isPlaying = false;

function init(){
	// console.log("init");
	// window.reader = Monocle.Reader('reader');
	
	//Hide the address bar
	audioz = document.getElementById("audio");

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
			audioz.pause();
			document.getElementById("top_audio").setAttribute("style","background: url(monocle/styles/btn_play.png)");
		}else{
			isPlaying = true;
			audioz.play();
			document.getElementById("top_audio").setAttribute("style","background: url(monocle/styles/btn_pause.png)");
		}
	}
	
	//Audio Control
	document.getElementById('top_home_btn').onclick = function(e){
		window.location = "home.php"
	}

	
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
	currentParagraph = t;
	console.log('seek to');
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
		Your browser does not support HTML5 audioz.
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

<div id="part2">
	 <h3>II</h3>
	 <p>
	 Mauris ac felis et justo pulvinar adipiscing ac quis metus. Duis sollicitudin nisi vel neque posuere auctor pretium urna pharetra. Nunc bibendum, tellus a interdum ultrices, enim velit pretium lorem, ut eleifend turpis ipsum vitae turpis. Cras accumsan sem vitae sapien semper varius. Sed eget orci magna, a sodales est. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Praesent non tincidunt eros. Praesent iaculis, lectus sit amet rutrum dignissim, odio arcu auctor elit, sit amet imperdiet neque elit in lorem. Nam consectetur semper tellus, vel blandit dui porttitor eu. Quisque at metus non urna pulvinar tempus. Nunc a neque sed arcu blandit aliquam. Nam orci sapien, suscipit et suscipit sodales, tempus sed purus.
	 </p>
	 <p>
	 Integer pulvinar nisl a ante sodales id viverra justo molestie. Cras quis mauris nulla. Quisque posuere dignissim consectetur. Curabitur eget augue sed ligula consectetur pulvinar sit amet vel velit. Pellentesque id massa egestas tellus vulputate tincidunt. Vestibulum vel congue arcu. Etiam nisi turpis, consequat sed vehicula vel, congue in leo. Aenean mauris leo, adipiscing nec scelerisque sed, ultricies in nisl. Fusce mollis semper nibh, id gravida libero iaculis quis. Curabitur id mi nisi, vel varius massa. Fusce suscipit rhoncus eleifend. Sed venenatis, velit sit amet consectetur sagittis, felis lacus viverra massa, sit amet suscipit ligula risus vitae urna. In euismod enim eu felis pretium at interdum dolor faucibus. Aenean eu felis orci. Nulla posuere tellus et justo porttitor non commodo sapien elementum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris id accumsan velit. Ut eu ligula molestie risus ornare eleifend eget vitae enim.
	 </p>
	 <p>
	 Phasellus dictum, magna id venenatis egestas, ligula purus sagittis mi, ut egestas ipsum risus a nisl. Quisque aliquet imperdiet lectus, sit amet cursus leo vestibulum id. Praesent nibh purus, pulvinar in tincidunt a, pharetra et urna. Praesent ornare, nisi sed tempor laoreet, lorem nibh tempor est, lacinia ultricies erat felis quis elit. Etiam et elit et lacus lacinia lacinia at sit amet diam. Fusce laoreet ligula non sem volutpat ut porta ipsum tempor. Mauris justo nisi, ornare sodales suscipit at, fermentum placerat justo. Aliquam quis consequat nunc. Mauris turpis ligula, cursus a accumsan sed, porttitor aliquet neque. Quisque vel enim tortor, a rutrum libero. Donec et molestie justo. Sed auctor, tellus at bibendum auctor, nulla sem aliquam dui, nec viverra ante erat eu tellus. Quisque et nisi tortor. Morbi semper odio quis quam accumsan dignissim. Cras ut augue nunc, quis molestie mi. Sed felis arcu, venenatis quis ultrices eget, tempus ac felis. Nunc porta neque non neque convallis nec consectetur orci sollicitudin. Sed leo lectus, feugiat in euismod eget, semper vitae lacus. Vestibulum non lacus a dui fermentum lobortis sed sit amet felis.
	 </p>
	 <p>
	 Praesent quis odio a nulla facilisis pulvinar in in dolor. Donec lacinia mauris non turpis dignissim viverra. Pellentesque sollicitudin dolor nec ipsum sagittis vitae dapibus odio aliquet. Donec ultrices consequat ligula eu volutpat. Vestibulum vitae tortor eu mi pulvinar cursus eget sit amet est. Nulla sagittis adipiscing faucibus. Suspendisse commodo sapien in arcu euismod eleifend. Aliquam porta velit vel leo sagittis vel venenatis urna sagittis. Quisque vulputate egestas scelerisque. Fusce porttitor sagittis neque, sit amet pharetra odio imperdiet at. Cras sodales hendrerit tellus, ut aliquam velit pellentesque id. Vivamus lacus augue, semper ut hendrerit mollis, elementum et velit. Donec lorem nunc, mollis ac pharetra at, bibendum a nisi. Vivamus porta turpis nec magna tempus venenatis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aenean vitae quam viverra neque interdum ultricies eu in diam. Integer tempus metus in nibh mattis adipiscing tincidunt leo porttitor. Vivamus at velit quis risus tincidunt dapibus.
	 </p>
	 <p>
	 Aliquam erat volutpat. Maecenas nec neque nulla, eget ullamcorper ligula. Phasellus dapibus quam a odio congue consectetur. Quisque sagittis nisl elementum dolor porttitor venenatis. Sed non pulvinar urna. Suspendisse nunc nibh, lacinia id venenatis in, consectetur vitae mauris. Donec ac quam nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In porttitor dui urna, facilisis rhoncus nisl. Pellentesque elit sem, molestie nec iaculis id, laoreet sagittis massa. Integer imperdiet sollicitudin nulla non rutrum. Phasellus egestas leo vel erat viverra vel ornare lorem dignissim. Mauris justo ligula, iaculis at vulputate in, viverra ut est. Praesent hendrerit enim eget sem ultricies non ultrices purus facilisis. Pellentesque commodo egestas iaculis. Aliquam erat volutpat. Vestibulum ornare cursus elit, vel mollis lorem elementum sit amet.
	 </p>
	 <p>

	 Pellentesque ornare facilisis semper. Pellentesque lorem sem, molestie iaculis mattis vel, molestie at orci. Quisque non arcu lorem. Donec consectetur volutpat turpis, eget aliquam velit dapibus eget. Ut nec iaculis massa. Nam vel metus non augue tempor scelerisque. Vestibulum lectus neque, gravida ac tempor vitae, feugiat in lacus. Mauris vitae ipsum et massa commodo aliquet vitae ac massa. Cras ac nisi sapien, et tempus nibh. Curabitur porta nunc ac mauris porta vel pretium ligula egestas. Integer ut lacus quam. In purus diam, lacinia at congue in, placerat sed lorem. Mauris ultrices, magna in tempor malesuada, est massa dapibus augue, semper tempor turpis dui vel sapien. Nulla facilisi. Nam malesuada, nibh vitae vestibulum mattis, massa nulla interdum ipsum, et venenatis urna magna vel ante.
	 </p>
	 <p>
	 Donec cursus, eros at cursus consequat, augue massa sagittis dolor, id dapibus elit nisi ac dolor. Sed lorem velit, semper in dapibus ullamcorper, ultricies vel dolor. Vestibulum ac tortor nec magna elementum congue in volutpat tortor. Pellentesque tellus turpis, sodales interdum gravida in, aliquam a velit. Ut massa mi, blandit a rhoncus vitae, ultrices ac felis. Curabitur urna nulla, malesuada id mollis et, elementum vel augue. Aenean rhoncus feugiat augue, vitae feugiat libero aliquet non. Aliquam auctor vestibulum malesuada. Phasellus ultrices, urna sed accumsan faucibus, turpis massa rutrum nibh, sed pellentesque metus massa in quam. Morbi bibendum, diam auctor malesuada sagittis, urna tellus adipiscing est, vitae accumsan nibh erat sit amet lorem. Nulla malesuada, lorem a viverra blandit, justo est tristique est, sed lobortis risus sapien sit amet quam. Suspendisse odio enim, posuere in convallis sed, porttitor ut libero. Quisque ultricies euismod consequat. Aliquam nec nunc diam. Aenean interdum erat faucibus enim scelerisque semper. Vestibulum porttitor lorem ullamcorper metus tincidunt ut convallis nisi tempus.
	 </p>
	 <p>
	 Cras id mauris purus. Nullam id tortor tellus. Pellentesque vitae orci eu lacus pulvinar commodo. Aliquam erat volutpat. Integer tellus sapien, tincidunt non luctus nec, tempor a mauris. Nunc quis odio ut erat pellentesque aliquam quis et massa. Praesent lectus lectus, luctus non pellentesque et, facilisis auctor quam. Proin vestibulum eleifend interdum. Ut sit amet justo diam, ut pulvinar massa. Proin vel felis augue. Praesent sed quam sem, dapibus egestas quam. Mauris in magna leo. Nulla eget ipsum vel turpis commodo rutrum ut eu lorem. Morbi ultricies magna non mi eleifend eget pulvinar nulla egestas.
	 </p>
</div>

<script>

document.getElementById('currentpar').innerHTML = "Paragraph 1, Next 0";

function startRunP(i){
    runningP0 = true;
	runProcess0(i);	
}

function runProcess(i, processname){
	currentParagraph = i;
	var t2 = timeline[i].start;
    var t1 = timeline[i-1].start;
    var time1 = time2secs(t1);
	var time2 = ((time2secs(t2)-time1) * 1000);
	var pageDiv = reader.dom.find('component', 1);
	var doc = pageDiv.contentDocument;//contentWindow
	var node = doc.evaluate('//p['+i+']', doc, null, 9, null).singleNodeValue;
	var parag = doc.getElementsByTagName('p');
	
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
	
	var part1 = document.getElementById('part1');
	var pArr = part1.getElementsByTagName("p");

	for (var i=0; i<pArr.length;i++){
		pArr[i].innerHTML = "<span onclick='javascript:top.seekTo(&quot;"+i.toString()+"&quot;)'>"+ pArr[i].innerHTML+ "</a>";
	}


</script>

</body>
</html>






