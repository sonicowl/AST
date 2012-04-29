function time2secs(t){
//console.log('time2secs '+t);
var secs = (Number(t.toString().substr(0,2))*3600) + (Number(t.toString().substr(3,2))*60) + (Number(t.toString().substr(6,2)));
var number = Number(secs) + Number(timeline.offset);
return Number(secs);
}

function showHideMenu(){
if (isMenuShowing == true) {
	document.getElementById("topMenu").setAttribute("style","opacity:0;-webkit-transform: translateY(-47px)");
	setAttributeForClass("monelem_bottomMenu", "opacity:0; -webkit-transform: translateY(47px)")
	isMenuShowing = false;
    // return;
}
else
{
   isMenuShowing = true;
	document.getElementById("topMenu").setAttribute("style","opacity:0.9; -webkit-transform: translateY(0px)");
	setAttributeForClass("monelem_bottomMenu", "opacity:0.9; -webkit-transform: translateY(0px)")
}
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