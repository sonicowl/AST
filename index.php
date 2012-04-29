<?php $full_url_path = "http://" . $_SERVER['HTTP_HOST'] . preg_replace("#/[^/]*\.php$#simU", "/", $_SERVER["PHP_SELF"]); ?>
<!DOCTYPE html>
<html lang=en>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
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
var currentTimeIndex = 0;
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
var hackCounter = 0;
</script>

<script src="lib/cookie.js"></script>
<script src="lib/util.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
<?php include("lib/monoclescripts.php"); ?>
<link rel="stylesheet" type="text/css" href="styles/ast.css" />
<meta charset="UTF-8">
<title>AST</title>

<script>
timeline = <?php include("data.php"); ?>;
function insertSeekEventToParagraphsOfChapter(){
	var divName = Get_Cookie('currentChapterSource');
	var i = 0;
	if (divName == null) divName = "part_01";
	$('.monelem_component').slice(0).contents().find('#'+divName).find('p').each(function(index){
		// console.log("this content "+$(this).html());
		$('span.selectParagraph', $(this)).remove();
		var content = $(this).find('.hiddenInfo').text();
		if (content == ""){content = $(this).html();
														}
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
}

function populatearrays(){
pageDiv = reader.visiblePages()[0];
doc = pageDiv.m.activeFrame.contentDocument;
var divName = 'part_'+currentDivPositionNumber;
var pag1;
var pag2;
var pag3;
part1 = document.getElementById(divName);
pArr = part1.getElementsByTagName("p");
myPages=new Array();
myTimes=new Array();
mySelPar=new Array();
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
} //End For

//console.log("myPages[0] " + myPages[0]);
//console.log("myPages[1] " + myPages[1]);
//console.log("myPages[2] " + myPages[2]);
//console.log("myPages[3] " + myPages[3]);
//console.log("nupages " + nupages);
for (var xx=0; xx<nupages-1;xx++){
	//console.log('1 ' +myPages[xx-1]);
	if (xx == 0) {
		myTimes[0] = 0;
		mySelPar[0] = 1;
			console.log('0 ' +myPages[0]);
	}
	if (xx !== 0) {
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

function playUpdateUI(){
//console.log("bbb");
if (isPlaying == true){
	//document.getElementById('reader_wrapper').setAttribute("style","display: none");
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
}
else
{
	//document.getElementById('reader_wrapper').setAttribute("style","display: block");
	document.getElementById("topMenu").setAttribute("style","opacity:0;-webkit-transform: translateY(-47px)");
	buttonState = "playing";
	setAttributeForClass("monelem_bottomMenu", "opacity:0; -webkit-transform: translateY(47px)")
	populatearrays();
	document.getElementById("top_audio").setAttribute("style","background: url(monocle/styles/btn_play2.png)");
	// console.log("mySelPar2[0] " + mySelPar[0]);
	// console.log("mySelPar2[1] " + mySelPar[1]);
	// console.log("mySelPar2[2] " + mySelPar[2]);
	// console.log("mySelPar2[3] " + mySelPar[3]);
	//console.log("checked turned " + parag.length);
	if (turned == true) {
    	currentpar= mySelPar[pagenumber-1];
		turned = false;
	}
	//reader.moveTo({ xpath: '//p['+currentpar+']' });
	var seekToP;
	if (isNaN(currentpar - 1) == true ) seekToP = 0; else seekToP = currentpar - 1;
    seekTo(seekToP,myTimes[pagenumber-1]);
}
}
function init(){
console.log("init");
audio = document.getElementById("audio");
function fullscreen(){
	var a=document.getElementsByTagName("a");
	for(var i=0;i<a.length;i++){
		if(a[i].className.match("noeffect")){
		}
		else{
			a[i].onclick=function(){
			window.location=this.getAttribute("href");
			return false;
			}
			}
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
	
	audio.addEventListener("abort", function () { debug(arguments, "abort"); });
	audio.addEventListener("canplay", function () { debug(arguments, "canplay"); });
	audio.addEventListener("canplaythrough", function () { debug(arguments, "canplaythrough"); });
	audio.addEventListener("durationchange", function () { debug(arguments, "durationchange"); });
	audio.addEventListener("emptied", function () { debug(arguments, "emptied"); });
	audio.addEventListener("ended", function () { debug(arguments, "ended"); });
	audio.addEventListener("error", function () { debug(arguments, "error"); });
	audio.addEventListener("loadeddata", function () { debug(arguments, "loadeddata"); });
	audio.addEventListener("loadedmetadata", function () { debug(arguments, "loadedmetadata"); });
	audio.addEventListener("loadstart", function () { debug(arguments, "loadstart"); });
	audio.addEventListener("pause", function () { debug(arguments, "pause"); });
	audio.addEventListener("play", function () { debug(arguments, "play"); });
	audio.addEventListener("playing", function () { debug(arguments, "playing"); });
	audio.addEventListener("progress", function () { debug(arguments, "progress"); });
	audio.addEventListener("ratechange", function () { debug(arguments, "ratechange"); });
	audio.addEventListener("readystatechange", function () { debug(arguments, "readystatechange"); });
	audio.addEventListener("seeked", function () { debug(arguments, "seeked"); });
	audio.addEventListener("seeking", function () { debug(arguments, "seeking"); });
	audio.addEventListener("stalled", function () { debug(arguments, "stalled"); });
	audio.addEventListener("suspend", function () { debug(arguments, "suspend"); });
	audio.addEventListener("volumechange", function () { debug(arguments, "volumechange"); });
	audio.addEventListener("waiting", function () { debug(arguments, "waiting"); });
	audio.addEventListener("timeupdate", function () {
		var parag = doc.getElementsByTagName('p');
		update(arguments);
		var i;
		if ((currentTimeIndex+1) != parag.length) {
			i = currentTimeIndex;
			var nextIndex = parseInt(i)+1;
			var start = timeline[i].start;
			var end = timeline[nextIndex].start;
			var time1 = time2secs(start);
			var time2 = time2secs(end);
			if (Math.round(audio.currentTime) == Math.round(time2)) currentTimeIndex++
		}
		else
		{
			i = currentTimeIndex;
		}

		for (var y=0; y<parag.length;y++){
			if (y!=(i))
				parag[y].innerHTML = parag[y].innerHTML.replace("background-color: #FFFFDD","background-color: #FFFFFF");
			else
				parag[y].innerHTML = parag[y].innerHTML.replace("background-color: #FFFFFF","background-color: #FFFFDD");
		}
	});
	currentpar = 1;
}

function update(){
var status = document.getElementById("status");
}

function debug(args,msg){
var t = "";
for (var o in args[0]){
	t += o + " " + args[0][o];
}

if(msg == 'ended')
{
	//turn chapter.
	reader.moveTo({ direction: 2 }); 
	insertedSeekEvent.push(2);
	insertSeekEventToParagraphsOfChapter();
}
}

timeline.offset = 0;
function seekTo(t,btime){
console.log('seekTo '+t + ' Time ' + btime)
if (buttonState == "paused"){showHideMenu();return false;}
if (currentpar-1 == t && isPlaying == true){
	console.log('3')
	showHideMenu();
	return false
}

if (isPlayerFirstTime == true){
	var timeaux;
	if (t == 0) timeaux = 0; else timeaux = timeline[t].start.toString()
	time = time2secs(timeaux);
	try {
		audio.play();
		function checkAudio1(){
			if (btime != 0) audio.currentTime = btime; else   audio.currentTime = time;audio.play();audio.volume=1; isPlayerFirstTime=false;
	}
 	var tzz=setTimeout(checkAudio1(),1000);
} catch (e) {
	audio.play();
	audio.pause();
	setTimeout("audio.currentTime = time;",2000);
	setTimeout("audio.play();",1500);
	isPlayerFirstTime=false;
}

}
else
{
	var timeaux;
	if (t == 0) timeaux = 0; else timeaux = timeline[t].start.toString()
	//console.log("SeekTo timeaux " + timeaux);
	time = time2secs(timeaux);
	//console.log("SeekTo time " + time);
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
//console.log("runProcess " + t);
}
currentTimeIndex = t;
isPlaying = true;
document.getElementById("top_audio").setAttribute("style","background: url(monocle/styles/btn_play2.png)");
runProcess(t);
 
}

</script>
<script src="lib/currentbook.js"></script>
<script>
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
		nupages = place.countPage();
		if (pagenumber ==0)pagenumber = 1
		$('.monelem_pagePositionStatus').html("Page "+ pagenumber + ' of ' +nupages);
			populatearrays();
		console.log('change page '+ currentPage);
		currentpar = mySelPar[pagenumber-1];
		console.log('currentpar '+ currentpar);
		currentPage = pagenumber;
		if (currentPage != "0" && currentPage != "1"){
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

Monocle.Reader('reader', bookData, readerOptions, function (rdr) {
	reader = rdr;
	toc = Monocle.Controls.Contents(rdr);
	rdr.addControl(toc, 'popover', { hidden: true });
	if (Get_Cookie('currentChapterSource') ){
		reader.skipToChapter(Get_Cookie('currentChapterSource'));
		if (Get_Cookie('currentPage') ){
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
			function handler()	{
				if (oReq.readyState == 4 /* complete */) {
       				if (oReq.status == 200) {
            			//console.log('got new timeline');
  						timeline = eval(oReq.responseText);
						var audio = document.getElementsByTagName('audio')[0];
						var src = audio.getElementsByTagName('source')[0];
						audio.innerHTML = "";
						var sourceElement = document.createElement('source');
						var sourceElementAttr = sourceElement.setAttribute("src", "video.php?c="+place.chapterSrc().split('_')[1])
						audio.appendChild(sourceElement);
						audio.pause();
						audio.load();
       				}
   				}
			}
			$('.monelem_component').contents().find('p').each(function(index){
				$(this).click(function(e){
					// Return if it's a child that's clicked:
   					if (e.target !== this) {return;}
					console.log('1')
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
			currentDivPositionNumber = place.chapterSrc().split('_')[1];
			Set_Cookie('currentChapterSource', 'part_'+currentDivPositionNumber);
			if (currentTitle !== place.chapterTitle()){
				currentTitle = place.chapterTitle();
				// insertSeekEventToParagraphsOfChapter();
				$('.monelem_component').contents().find('p').each(function(index){
					$(this).click(function(e){
						// Return if it's a child that's clicked:
   						if (e.target !== this) {return;}
						console.log('2')
						showHideMenu();
					})
				})
 				document.getElementById('top_title').innerHTML = place.chapterTitle();
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
	/* SCRUBBER CONTROL */
	var scrubber = new Monocle.Controls.Scrubber(rdr);
	rdr.addControl(scrubber);
	// 
	});
	}
);

</script>

<body style="padding:0; margin:0;" onload="init()">
<div id="reader"></div>
<div id="main_audio">
<audio controls id="audio">
<source type="audio/mp3" preload="metadata" src="video.php?c=<?php echo $_GET['c'] ?>"/>
Your browser does not support HTML5 audio.
</audio>
</div>
<div id="status"></div>
<?php include("lib/currentbookhtml.php"); ?>

<script>
function runProcess(i){
 console.log ('runProcess ' +i);
 i=Number(i) + 1;
 currentpar = i;
 populatearrays();
 //console.log('runProcess timeline'+timeline);
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
		SizeOnActualPage = (doc.body.scrollHeight - t2);
		SizeOnNextPage = (b2 - doc.body.scrollHeight);
		newtime2 =  Math.floor((time2 * SizeOnActualPage) / (SizeOnActualPage + SizeOnNextPage));
		clearTimeout(tt2);
		//Processo da pagina
		//console.log ('runProcess c ' +newtime2);
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
		//console.log ('runProcess d ' +newtime2);
 		tt2 = setTimeout("reader.moveTo({ page: "+pag2+" })",newtime2);
 	}
 	if (t2 == 0){reader.moveTo({ page: pag2 })}
 }

	clearTimeout(tt1);
	//Processo do paragrapho.
	tt1 = setTimeout("runProcess("+i.toString()+")",time2);
	parag = doc.getElementsByTagName('p');
 }
</script>

</body>
</html>