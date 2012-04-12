<?php
$full_url_path = "http://" . $_SERVER['HTTP_HOST'] . preg_replace("#/[^/]*\.php$#simU", "/", $_SERVER["PHP_SELF"]);
?>
<!DOCTYPE html>
<html lang=en>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- TODO MINIFY JAVASCRIPT -->
<script>
var isPlaying;
var currentTitle;
var currentPage;
var timeline;
var toc;
var isMenuShowing = false;
var buttonState = 'paused';
var currentDivPositionNumber = '01';
var pathInfo = "<?php echo $full_url_path;?>";
var isPlayerFirstTime = true;


	function Set_Cookie( name, value, expires, path, domain, secure )
	{
		// set time, it's in milliseconds
		var today = new Date();
		today.setTime( today.getTime() );

		/*
		if the expires variable is set, make the correct
		expires time, the current script below will set
		it for x number of days, to make it for hours,
		delete * 24, for minutes, delete * 60 * 24
		*/
		if ( expires )
		{
			expires = expires * 1000 * 60 * 60 * 24;
		}
		var expires_date = new Date( today.getTime() + (expires) );

		document.cookie = name + "=" +escape( value ) +
		( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) +
		( ( path ) ? ";path=" + path : "" ) +
		( ( domain ) ? ";domain=" + domain : "" ) +
		( ( secure ) ? ";secure" : "" );
	}
	
	
	// this function gets the cookie, if it exists
	// don't use this, it's weak and does not handle some cases
	// correctly, this is just to maintain legacy information
	function Get_Cookie( name ) {
		var start = document.cookie.indexOf( name + "=" );
		var len = start + name.length + 1;
		if ( ( !start ) &&
		( name != document.cookie.substring( 0, name.length ) ) )
		{
		return null;
		}
		if ( start == -1 ) return null;
		var end = document.cookie.indexOf( ";", len );
		if ( end == -1 ) end = document.cookie.length;
		return unescape( document.cookie.substring( len, end ) );
	}
	
	
	// this deletes the cookie when called
	function Delete_Cookie( name, path, domain ) {
		if ( Get_Cookie( name ) ) document.cookie = name + "=" +
		( ( path ) ? ";path=" + path : "") +
		( ( domain ) ? ";domain=" + domain : "" ) +
		";expires=Thu, 01-Jan-1970 00:00:01 GMT";
	}



</script>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>


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


#reader { 
/*width: 320px; height: 416px;*/ 
position: absolute;
width: 100%;
height: 100%;
}

.hiddenInfo {display:none}

/*Ipad*/
@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
	#reader {
		position: absolute;
		width: 100%;
		height: 100%;
	}
}

/*Iphone */
@media only screen and (max-device-width: 480px) {
	#reader {
		width: 320px; height: 416px; position: absolute;

	}
}


  #part_01, #part_02, #part_03,  #part_04,  #part_05,  #part_06,  #part_07,  #part_08,  #part_09,  #part_10,  #part_11,  #part_12,  #part_13,  #part_14,  #part_15,  #part_16 ,  
#part_17,  #part_18, #part_19,  #part_20,  #part_21, #part_22, #part_23,  #part_24, #part_25, #part_26,  #part_27, #part_28,#part_29,#part_30,#part_31,#part_32,#part_33, #part_34, #part_35, #part_36, #part_37{display:none}
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


<script>
	timeline = <?php include("data.php"); ?>;
</script>

<script>

/* GLOBAL VARIABLES */
var nupages;
var currentpar = 1;
var audio;
var reader;
var tt1;
var tt2;
var turned = false;
var pagenumber = 1;
var myPages=new Array();
var myTimes=new Array();
var mySelPar=new Array();
var insertedSeekEvent = new Array();

function insertSeekEventToParagraphsOfChapter(){
	
				var divName = Get_Cookie('currentChapterSource');
				var i = 0;

				$('.monelem_component').slice(0).contents().find('#'+divName).find('p').each(function(index){
						// console.log("this content "+$(this).html());
						$('span.selectParagraph', $(this)).remove();
						var content = $(this).find('.hiddenInfo').text();
						if (content == ""){content = $(this).html();}
						$('span.hiddenInfo', $(this)).remove();
						
						$(this).html("<span class='selectParagraph' style='background-color: #FFFFFF' onclick='javascript:top.seekTo(&quot;"+index.toString()+"&quot;,0);'>"+content+ "</span><span class='hiddenInfo' style='display:none'>"+content+"</span>");
				})
				
				$('.monelem_component').slice(1).contents().find('#'+divName).find('p').each(function(index){
					$('span.selectParagraph', $(this)).remove();
					var content = $(this).find('.hiddenInfo').text();
					if (content == ""){content = $(this).html();}
					$('span.hiddenInfo', $(this)).remove();
					
					$(this).html("<span class='selectParagraph' style='background-color: #FFFFFF' onclick='javascript:top.seekTo(&quot;"+index.toString()+"&quot;,0);'>"+content+ "</span><span class='hiddenInfo' style='display:none'>"+content+"</span>");
				})
				
				// part1 = document.getElementById(divName);
				// pArr = part1.getElementsByTagName("p");
				// 
				// console.log('insertSeekEventToParagraphsOfChapter number of p '+ pArr.length);
				// 
				// for (var i=0; i<pArr.length;i++){
				// 	pArr[i].innerHTML = "<span style='background-color: #FFFFFF' onclick='javascript:top.seekTo(&quot;"+i.toString()+"&quot;,0);'>"+i.toString()+pArr[i].innerHTML+ "</span>";
				// }
}


function populatearrays(){
		pageDiv = reader.visiblePages()[0];
		doc = pageDiv.m.activeFrame.contentDocument;
		var divName = 'part_'+currentDivPositionNumber;
		part1 = document.getElementById(divName);
		
		// console.log('populatearrays' +divName)
		pArr = part1.getElementsByTagName("p");
		myPages=new Array();
		
		for (var xx=0; xx<pArr.length-1;xx++){
			if (xx !== 0) {
			    node1 = document.evaluate('//p['+(xx-1)+']', doc, null, 9, null).singleNodeValue;
			    percent1 = pageDiv.m.dimensions.percentageThroughOfNode(node1);
			    pag1 =Math.floor(percent1 * nupages);
		    }

			node2 = document.evaluate('//p['+xx+']', doc, null, 9, null).singleNodeValue;
			percent2 = pageDiv.m.dimensions.percentageThroughOfNode(node2);
			pag2 =Math.floor(percent2 * nupages);
			if (xx !== pArr.length){
				node3 = document.evaluate('//p['+(xx+1)+']', doc, null, 9, null).singleNodeValue;
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
		//console.log("myPages[0] " + myPages[0]);
		//console.log("myPages[1] " + myPages[1]);
		//console.log("myPages[2] " + myPages[2]);
		//console.log("myPages[3] " + myPages[3]);
		//console.log("myPages[4] " + myPages[4]);
		
		for (var xx=0; xx<nupages-1;xx++){
			if (xx == 0) {
				myTimes[0] = 0;
				mySelPar[0] = 1;
			}
		   	if ((xx !== 0) && (typeof timeline[(myPages[xx-1]+1)]  != 'undefined')) {
			    node1 = doc.evaluate('//p['+(myPages[xx-1])+']', doc, null, 9, null).singleNodeValue;
				percent1 = pageDiv.m.dimensions.percentageThroughOfNode(node1);
				pag1 =Math.floor(percent1 * nupages);
					
				if (node1!=null) {
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
					myTimes[xx] = time2secs(timeline[(myPages[xx-1])].start);
					mySelPar[xx] = myPages[xx-1] + 1;
				} 

				//If the actual paragraph has the bottom more than doc.body.scrollHeight, that means if ends on the next page, and has the most part of it on the current page.
				if (b1 > doc.body.scrollHeight){
					SizeOnActualPage = (doc.body.scrollHeight - t1);
					SizeOnNextPage = (b1 - doc.body.scrollHeight);

					newtime2 =  Math.floor((time2 * SizeOnActualPage) / (SizeOnActualPage + SizeOnNextPage));
					//console.log("foi1 " + time2secs(timeline[(mySelPar[xx-1]+1)].start)  );
					//console.log("foi2 " + newtime2 );

					myTimes[xx] = (time2secs(timeline[(mySelPar[xx-1]+1)].start) + newtime2);
					mySelPar[xx] = myPages[xx-1];
				}

				//If the next paragraph has the bottom less than 0, that means if ends on the next page, and has the most part of it on the next page.
				if (t2 < 0){
		            SizeOnActualPage = (t2 * -1);
					SizeOnNextPage = b2;
					newtime2 =  Math.floor((time2 * SizeOnActualPage) / (SizeOnActualPage + SizeOnNextPage));
					myTimes[xx] = (time2secs(timeline[(mySelPar[xx-1]+1)].start) + newtime2);
					mySelPar[xx] = myPages[xx-1] + 1;
				}
				//console.log("foi " + b1 );
			}

		}

		}

		//console.log("myTimes[0] " + myTimes[0]);
		//console.log("myTimes[1] " + myTimes[1]);
		//console.log("myTimes[2] " + myTimes[2]);
		//console.log("myTimes[3] " + myTimes[3]);
		//console.log("myTimes[4] " + myTimes[4]);

		//console.log("mySelPar1[0] " + mySelPar[0]);
		//console.log("mySelPar1[1] " + mySelPar[1]);
		//console.log("mySelPar1[2] " + mySelPar[2]);
		//console.log("mySelPar1[3] " + mySelPar[3]);
		//console.log("mySelPar1[4] " + mySelPar[4]);
}

	
	
	function setAttributeForClass(theClass, attribute) {
		//Create Array of All HTML Tags
		var allHTMLTags=document.getElementsByTagName("*");
		for (i=0; i<allHTMLTags.length; i++) {
			if (allHTMLTags[i].className==theClass) {
				allHTMLTags[i].setAttribute("style",attribute);;
			}
		}
  	}

	function showHideMenu(){
		console.log('showHideMenu isMenuShowing '+isMenuShowing)
		if (isMenuShowing == true) {
			console.log('hide menu')
			document.getElementById("topMenu").setAttribute("style","opacity:0;-webkit-transform: translateY(-47px)");
			setAttributeForClass("monelem_bottomMenu", "opacity:0; -webkit-transform: translateY(47px)")
			isMenuShowing = false;
	      // return;
	    }else{
		    isMenuShowing = true;
			document.getElementById("topMenu").setAttribute("style","opacity:0.9; -webkit-transform: translateY(0px)");
			// document.getElementById("monelem_bottomMenu").setAttribute("style","opacity:0.9;");
			setAttributeForClass("monelem_bottomMenu", "opacity:0.9; -webkit-transform: translateY(0px)")
		}
	}

	
	
	function playUpdateUI(){
		if (isPlaying == true){
			// document.getElementById('reader_wrapper').setAttribute("style","display: none");
			buttonState = "paused";
			isPlaying = false;
			audio.pause();
			clearTimeout(tt1);
			clearTimeout(tt2);
			pageDiv = reader.visiblePages()[0];
			doc = pageDiv.m.activeFrame.contentDocument;
			parag = doc.getElementsByTagName('p');
			//console.log("checked turned " + parag.length);
			for (var y=0; y<parag.length;y++){
				parag[y].innerHTML = parag[y].innerHTML.replace("background-color: #FFFFDD","background-color: #FFFFFF");
			}
			turned = false;
			document.getElementById("top_audio").setAttribute("style","background: url(monocle/styles/btn_pause2.png)");
		}else{
			// document.getElementById('reader_wrapper').setAttribute("style","display: block");
			document.getElementById("topMenu").setAttribute("style","opacity:0;-webkit-transform: translateY(-47px)");
			buttonState = "playing";
			
			setAttributeForClass("monelem_bottomMenu", "opacity:0; -webkit-transform: translateY(47px)")
			
			populatearrays();
			
			document.getElementById("top_audio").setAttribute("style","background: url(monocle/styles/btn_play2.png)");
			
			// 		    console.log("mySelPar2[0] " + mySelPar[0]);
			// console.log("mySelPar2[1] " + mySelPar[1]);
			// console.log("mySelPar2[2] " + mySelPar[2]);
			// console.log("mySelPar2[3] " + mySelPar[3]);
			//console.log("checked turned " + parag.length);
		    if (turned == true) {
		    	currentpar= mySelPar[pagenumber-1];
				turned = false;
			}
		    //reader.moveTo({ xpath: '//p['+currentpar+']' });
		    console.log("moveTo Paragraph: " + (mySelPar[pagenumber-1]));
			console.log('call to seekto' +currentpar);
			var seekToP;
			if (isNaN(currentpar - 1) == true ){
				seekToP = 0
			}else{
				seekToP = currentpar - 1;
			}
	   	    seekTo(seekToP,myTimes[pagenumber-1]);	
		}
	}
	
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
		playUpdateUI();

	}
	
	//Audio Control
	document.getElementById('top_home_btn').onclick = function(e){
		window.location = "home.php"
	}

	// for(p in paragraphElems){
	// 	p.addEventListener("click", modeOn, true);
	// }
	
	
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
	// for (var i=0; i<timeline.length; i++){
	// 	
	// }
}

function time2secs(t){
	console.log('time2secs '+t);
	var secs = (Number(t.toString().substr(0,2))*3600) + (Number(t.toString().substr(3,2))*60) + (Number(t.toString().substr(6,2)));
	var number = Number(secs) + Number(timeline.offset);
	
	console.log('time2secs secs '+Number(secs));
	console.log('time2secs timeline.offset '+Number(timeline.offset));
	
	// console.log('time2secs final number '+number);
	return Number(secs);
	// return Number(secs) + Number(timeline.offset);
}


function debug(args,msg){
	var t = "";
	for (var o in args[0]){
		t += o + " " + args[0][o];
	}
	console.log(args.length + " - " + msg);
}


timeline.offset = 0;

function seekTo(t,btime){
	// console.log('isPlaying '+isPlaying)
	if (buttonState == "paused"){showHideMenu();return false;s}
	if (currentpar-1 == t && isPlaying == true){
		console.log('paragrah is already playing')
		showHideMenu();
		return false
	}

	if (isPlayerFirstTime == true){

		var timeaux;
		console.log("SeekTo " + t);
		console.log("SeekTo timeline " + timeline);
		console.log("SeekTo timeline 2 " + timeline[t]);

		if (t == 0) timeaux = 0; else timeaux = timeline[t].start.toString()

		console.log("SeekTo timeaux " + timeaux);

		time = time2secs(timeaux);
		console.log("SeekTo time " + time);

		try {
			
		  audio.play();
		
		function checkAudio1(){
			if (btime != 0) audio.currentTime = btime; else   audio.currentTime = time;audio.play();audio.volume=1; isPlayerFirstTime=false;
		}
		  var tzz=setTimeout(checkAudio1(),1000);

		} catch (e) {
			// alert('catch')
			audio.play();
		    audio.pause();
		    setTimeout("audio.currentTime = time;",2000);
		    setTimeout("audio.play();",1500);
		isPlayerFirstTime=false;
		}
		console.log("runProcess " + t);
	    runProcess(t);
	}else{
		


		var timeaux;
		console.log("SeekTo " + t);
		console.log("SeekTo timeline " + timeline);
		console.log("SeekTo timeline 2 " + timeline[t]);

		if (t == 0) timeaux = 0; else timeaux = timeline[t].start.toString()

		console.log("SeekTo timeaux " + timeaux);

		time = time2secs(timeaux);
		console.log("SeekTo time " + time);

		try {
		  audio.pause();
		  btime = 0;
		  console.log("turned " + turned);
		  if (btime != 0) audio.currentTime = btime; else   audio.currentTime = time;
	 	  //setTimeout("audio.play()", 1000); 
	      audio.play();

		} catch (e) {
			audio.play();
		    audio.pause();
		    setTimeout("audio.currentTime = time;",500);
		    setTimeout("audio.play();",1000);
		}
		console.log("runProcess " + t);
	    runProcess(t);
	}
	
	
	isPlaying = true;
	document.getElementById("top_audio").setAttribute("style","background: url(monocle/styles/btn_play2.png)");

 
}

//*TODO = GET BOOK DATA FROM ALL CHAPTERS *//

var bookData = {
  getComponents: function () {
    return [
      'part_01', 
	  'part_02',
	  'part_03', 
	  'part_04', 
	  'part_05',
	  'part_06',
	  'part_07', 
	  'part_08',
	  'part_09',
	  'part_10',
	  'part_11', 
	  'part_12',
	  'part_13', 
	  'part_14', 
	  'part_15',
	  'part_16',
	  'part_17', 
	  'part_18',
	  'part_19',
	  'part_20',
	  'part_21', 
	  'part_22',
	  'part_23', 
	  'part_24', 
	  'part_25',
	  'part_26',
	  'part_27', 
	  'part_28',
	  'part_29',
	  'part_30',
	  'part_31', 
	  'part_32', 
	  'part_33',
	  'part_34',
	  'part_35', 
	  'part_36',
	  'part_37'
    ];
  },
  getContents: function () {
    return [
      {
        title: "1 - THE BREEZE",
        src: 'part_01',
		chp: '01'
      }
	,
	 {
       title: "2 - PINE COVE",
        src: 'part_02',
		chp: '02'
	 },
	{
       title: "3 - TRAVIS",
        src: 'part_03',
		chp: '03'
	 }
	,
	{
       title: "4 - ROBERT",
        src: 'part_04',
		chp: '04'
	 }
	,
	{
       title: "5 - AUGUSTUS BRINE",
       src: 'part_05',
		chp: '05'
	 }
	,
	{
       title: "6 - THE DJINN'S STORY",
       src: 'part_06',
		chp: '06'
	 }
	,
	{
       title: "7 - ARRIVAL",
       src: 'part_07',
		chp: '07'
	 }
	,
	{
       title: "8 - ROBERT",
       src: 'part_08',
		chp: '08'
	 }
	,
	{
       title: "9 - THE HEAD OF THE SLUG",
       src: 'part_09',
		chp: '09'
	 }
	,
	{
       title: "10 - AUGUSTUS BRINE",
       src: 'part_10',
		chp: '10'
	 }
	,
	{
       title: "11 - EFFROM",
       src: 'part_11',
		chp: '11'
	 }
	,
	{
       title: "12 - JENNIFER",
       src: 'part_12',
		chp: '12'
	 }
	,
	{
       title: "13 - NIGHTFALL",
       src: 'part_13',
		chp: '13'
	 }
	,
	{
       title: "14 - DINNER",
       src: 'part_14',
		chp: '14'
	 }
	,
	{
       title: "15 - RACHEL",
       src: 'part_15',
		chp: '15'
	 }
	,
	{
       title: "16 - HOWARD",
       src: 'part_16',
		chp: '16'
	 }
	,
	{
       title: "17 - BILLY",
       src: 'part_17',
		chp: '17'
	 }
	,
	{
       title: "18 - RACHEL",
       src: 'part_18',
		chp: '18'
	 }
	,
	{
       title: "19 - JENNY'S HOUSE",
       src: 'part_19',
		chp: '19'
	 }
	,
	{
       title: "20 - EFFROM",
       src: 'part_20',
		chp: '20'
	 }
	,
	{
       title: "21 - AUGUSTUS BRINE",
       src: 'part_21',
		chp: '21'
	 }
	,
	{
       title: "22 - TRAVIS AND JENNY",
       src: 'part_22',
		chp: '22'
	 }
	,
	{
       title: "23 - RIVERA",
       src: 'part_23',
		chp: '23'
	 }
	,
	{
       title: "24 - AUGUSTUS BRINE",
       src: 'part_24',
		chp: '24'
	 }
	,
	{
       title: "25 - AMANDA",
       src: 'part_25',
		chp: '25'
	 }
	,
	{
       title: "26 - TRAVIS'S STORY",
       src: 'part_26',
		chp: '26'
	 }
	,
	{
       title: "27 - AUGUSTUS",
       src: 'part_27',
		chp: '27'
	 }
	,
	{
       title: "28 - EFFROM",
       src: 'part_28',
		chp: '28'
	 }
	,
	{
       title: "29 - RIVERA",
       src: 'part_29',
		chp: '29'
	 }
	,
	{
       title: "30 - JENNY",
       src: 'part_30',
		chp: '30'
	 }
	,
	{
       title: "31 - GOOD GUYS",
       src: 'part_31',
		chp: '31'
	 }
	,
	{
       title: "32 - THE HEAD OF THE SLUG",
       src: 'part_32',
		chp: '32'
	 }
	,
	{
       title: "33 - RIVERA",
       src: 'part_33',
		chp: '33'
	 }
	,
	{
       title: "34 - U-PICK-EM",
       src: 'part_34',
		chp: '34'
	 }
	,
	{
       title: "35 - BAD GUYS, GOOD GUYS",
       src: 'part_35',
		chp: '35'
	 }
	,
	{
       title: "36 - JENNY, ROBERT, RIVERA, AMANDA, TRAVIS, HOWARD, AND THE SPIDER",
       src: 'part_36',
		chp: '36'
	 }
	,
	{
       title: "37 - GOOD GUYS",
       src: 'part_37',
		chp: '37'
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
	

	
	var hackCounter = 0;
	
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
			nupages = place.countPage();
			
			// if (pagenumber == 0){pagenumber = nupages;}
			
			document.getElementById('pagenum').innerHTML = "Page "+ pagenumber;

			if (pagenumber ==0)pagenumber = 1
			
			$('.monelem_pagePositionStatus').html("Page "+ pagenumber + ' of ' +nupages);
			
			
			currentpar = mySelPar[pagenumber-1];
			//alert(currentpar);
			currentPage = pagenumber;
			console.log('monocle:pagechange  currentPage' +currentPage );
			if (currentPage != "0" && currentPage != "1"){
				console.log('getCookie for Current page ' +Get_Cookie('currentPage'));
				Set_Cookie('currentPage', currentPage, '', '/', '', '' );
			}else{
				if (hackCounter >3){
					Set_Cookie('currentPage', currentPage, '', '/', '', '' );
				}
			}
			insertSeekEventToParagraphsOfChapter();

			hackCounter = hackCounter+1;

	});
	reader.listen(
		'monocle:componentchange',
		function (evt) {
			if(insertedSeekEvent.indexOf(Get_Cookie('currentChapterSource')) == -1){
				insertedSeekEvent.push(Get_Cookie('currentChapterSource'))
			 	insertSeekEventToParagraphsOfChapter();
			}

	});
	

	


    var readerOptions = {
      panels: Monocle.Panels.IMode
    };

	currentTitle = "1 - THE BREEZE";
	
    Monocle.Reader('reader', bookData, readerOptions, function (rdr) {
      reader = rdr;
      toc = Monocle.Controls.Contents(rdr);
      rdr.addControl(toc, 'popover', { hidden: true });

	if (Get_Cookie('currentChapterSource') ){
		
		reader.skipToChapter(Get_Cookie('currentChapterSource'));
		      	if (Get_Cookie('currentPage') ){
			console.log('move to page '+Get_Cookie('currentPage'));
			var t=setTimeout(function(){
						var pageN = Number(Get_Cookie('currentPage'));
						reader.moveTo({ page: pageN })
			},300);
			
		}
	}

	
      /* CHAPTER TITLE RUNNING HEAD */
      var chapterTitle = {
        runners: [],
        createControlElements: function (page) {
          var cntr = document.createElement('div');
          // cntr.className = "chapterTitle";
          // var runner = document.createElement('div');
          // runner.className = "runner";
          // cntr.appendChild(runner);
          // this.runners.push(runner);
          // this.update(page);
          return cntr;
        },
        update: function (page) {
          var place = reader.getPlace(page);
		  // console.log('place.chapterTitle()' +place.chapterTitle());
		
		function handler()
		{
		    if (oReq.readyState == 4 /* complete */) {
		        if (oReq.status == 200) {
		             // console.log('got new timeline');
		  			timeline = eval(oReq.responseText);
					var audio = document.getElementsByTagName('audio')[0];
					var src = audio.getElementsByTagName('source')[0];
					// console.log('audio src 1' +src.getAttribute('src'));
					audio.innerHTML = "";
					var sourceElement = document.createElement('source');
					var sourceElementAttr = sourceElement.setAttribute("src", "video.php?c="+place.chapterSrc().split('_')[1])
					audio.appendChild(sourceElement);
					// console.log('audio src 2' +src.getAttribute('src'));
					audio.pause();
					audio.load();
		        }
		    }
		}
		
		$('.monelem_component').contents().find('p').each(function(index){
				$(this).click(function(e){
					
					// Return if it's a child that's clicked:
				    if (e.target !== this) {return;}
						showHideMenu();
				})
		})
		var newChapterTitle = "";
		if (place.chapterTitle().length > 14 ){
			newChapterTitle = place.chapterTitle().substring(0,14) +'...';
		}else{
			newChapterTitle = place.chapterTitle();
		}
		document.getElementById('top_title').innerHTML = newChapterTitle;
		// console.log('place chapter metadata '+place.chapterSrc().split('_')[1]);
		currentDivPositionNumber = place.chapterSrc().split('_')[1];
		 
		Set_Cookie('currentChapterSource', 'part_'+currentDivPositionNumber);
		
		// console.log('currentTitle '+currentTitle);
		// console.log('place.chapterTitle() '+place.chapterTitle());
		
		if (currentTitle !== place.chapterTitle()){
			currentTitle = place.chapterTitle();
			// insertSeekEventToParagraphsOfChapter();
			$('.monelem_component').contents().find('p').each(function(index){
					$(this).click(function(e){
						
						// Return if it's a child that's clicked:
					    if (e.target !== this) {return;}
							showHideMenu();
					})
			})
		  document.getElementById('top_title').innerHTML = place.chapterTitle();
		  // console.log('timeline = ' +timeline);
		  timeline = {};
		  var oReq = new XMLHttpRequest();
			if (oReq != null) {
			    oReq.open("GET", pathInfo+"timeline_generator.php?c="+place.chapterSrc().split('_')[1], true);
			    oReq.onreadystatechange = handler;
			    oReq.send();
			}
        }
		}
      }

      reader.addControl(chapterTitle, 'page');
      reader.listen(
        'monocle:pagechange',
        function (evt) { chapterTitle.update(evt.m.page); }
      );


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

<body style="padding:0; margin:0;" onload="init()">
	<div id="reader">

	</div>
	<div id="currentpar" style="display:none"></div>
	<div id="pagenum" style="display:none"></div>

<div id="main_audio">
	<audio controls id="audio">
		<source type="audio/mp3" preload="metadata" src="video.php?c=<?php echo $_GET['c'] ?>"/>
		Your browser does not support HTML5 audio.
	</audio>
</div>

<div id="status"></div>

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



<script>

document.getElementById('currentpar').innerHTML = "Paragraph 1, Next 0";

function runProcess(i){
	console.log ('runProcess' +i);
i=Number(i) + 1;
currentpar = i;
populatearrays();
console.log('runProcess timeline'+timeline);
t2 = timeline[i].start;
t1 = timeline[i-1].start;

console.log ('runProcess t2' +t2);

console.log ('runProcess t1' +t1);

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
			SizeOnActualPage = (doc.body.scrollHeight - t2);
			SizeOnNextPage = (b2 - doc.body.scrollHeight);
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
				parag[y].innerHTML = parag[y].innerHTML.replace("background-color: #FFFFDD","background-color: #FFFFFF");
			else
			    parag[y].innerHTML = parag[y].innerHTML.replace("background-color: #FFFFFF","background-color: #FFFFDD");
	}			
	//document.getElementById('currentpar').innerHTML = "HMP "+parag.length+", Paragraph "+i.toString()+", Next "+t2;


}

// if(insertedSeekEvent.indexOf(Get_Cookie('currentChapterSource')) == -1){
// 	insertedSeekEvent.push(Get_Cookie('currentChapterSource'))
 	// insertSeekEventToParagraphsOfChapter();
// }
// insertSeekEventToParagraphsOfChapter();
</script>

</body>
</html>





