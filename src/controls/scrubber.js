Monocle.Controls.Scrubber = function (reader) {
  if (Monocle.Controls == this) {
    return new Monocle.Controls.Scrubber(reader);
  }

  var API = { constructor: Monocle.Controls.Scrubber }
  var k = API.constants = API.constructor;
  var p = API.properties = {}


  function initialize() {
    p.reader = reader;
    p.reader.listen('monocle:turn', updateNeedles);
    updateNeedles();
  }



  function toggleMagnification(evt) {
    var opacities;
    if (!p.sheetIndex) {
      opacities = [0.3, 1]
      var reset = k.RESET_STYLESHEET;
      reset += "html body { font-size: "+k.MAGNIFICATION*100+"% !important; }";
      p.sheetIndex = p.reader.addPageStyles(reset);
    } else {
      opacities = [1, 0.3]
      p.reader.removePageStyles(p.sheetIndex);
      p.sheetIndex = null;
    }

    // for (var i = 0; i < p.buttons.length; i++) {
    //   // p.buttons[i].smallA.style.opacity = opacities[0];
    //   // p.buttons[i].largeA.style.opacity = opacities[1];
    // }
  }

  function contentsForBook(div, book) {
    while (div.hasChildNodes()) {
      div.removeChild(div.firstChild);
    }
    var list = div.dom.append('ol', 'controls_contents_list');

    var contents = book.properties.contents;
    for (var i = 0; i < contents.length; ++i) {
      chapterBuilder(list, contents[i], 0);
    }
  }


  function chapterBuilder(list, chp, padLvl) {
    var index = list.childNodes.length;
    var li = list.dom.append('li', 'controls_contents_chapter', index);
    var span = li.dom.append(
      'span',
      'controls_contents_chapterTitle',
      index,
      { html: chp.title }
    );
    span.style.paddingLeft = padLvl + "em";

    var invoked = function () {
      p.reader.skipToChapter(chp.src);
      p.reader.hideControl(API);
    }

    Monocle.Events.listenForTap(li, invoked, 'controls_contents_chapter_active');

    if (chp.children) {
      for (var i = 0; i < chp.children.length; ++i) {
        chapterBuilder(list, chp.children[i], padLvl + 1);
      }
    }
  }


  function pixelToPlace(x, cntr) {
    if (!p.componentIds) {
      p.componentIds = p.reader.getBook().properties.componentIds;
      p.componentWidth = 100 / p.componentIds.length;
    }
    var pc = (x / cntr.offsetWidth) * 100;
    var cmpt = p.componentIds[Math.floor(pc / p.componentWidth)];
    var cmptPc = ((pc % p.componentWidth) / p.componentWidth);
    return { componentId: cmpt, percentageThrough: cmptPc };
  }


  function placeToPixel(place, cntr) {
    if (!p.componentIds) {
      p.componentIds = p.reader.getBook().properties.componentIds;
      p.componentWidth = 100 / p.componentIds.length;
    }
    var componentIndex = p.componentIds.indexOf(place.componentId());
    var pc = p.componentWidth * componentIndex;
    pc += place.percentageThrough() * p.componentWidth;
    return Math.round((pc / 100) * cntr.offsetWidth);
  }


  function updateNeedles() {
    if (p.hidden || !p.reader.dom.find(k.CLS.container)) {
      return;
    }
    var place = p.reader.getPlace();
    var x = placeToPixel(place, p.reader.dom.find(k.CLS.container));
    var needle, i = 0;
    for (var i = 0, needle; needle = p.reader.dom.find(k.CLS.needle, i); ++i) {
      setX(needle, x - needle.offsetWidth / 2);
      p.reader.dom.find(k.CLS.trail, i).style.width = x + "px";
    }
  }


  function setX(node, x) {
    var cntr = p.reader.dom.find(k.CLS.container);
    x = Math.min(cntr.offsetWidth - node.offsetWidth, x);
    x = Math.max(x, 0);
    Monocle.Styles.setX(node, x);
  }

  function showTOC(){
	var rdr = p.reader;
	console.log('showTOC '+toc)
	rdr.showControl(toc);
  }


  function createControlElements(holder) {
	var cntrWrapper = holder.dom.make('div', 'bottomMenu');
	var cntrInside = cntrWrapper.dom.append('div', 'bottomMenu_Inside');
	
	var btn = cntrInside.dom.append('div', 'controls_magnifier_button');
	
	var searchBtn = cntrInside.dom.append('div', 'searchButton');
	var bookmarkBtn = cntrInside.dom.append('div', 'bookmarkButton');
	
	

	
    // btn.smallA = btn.dom.append('span', 'controls_magnifier_a', { text: 'A' });
    // btn.largeA = btn.dom.append('span', 'controls_magnifier_A', { text: 'A' });
    // p.buttons.push(btn);

    Monocle.Events.listenForTap(btn, toggleMagnification);
	
	
	var tocDiv = cntrInside.dom.append('div', 'pagePositionStatus');
	
	
	var tocDiv = cntrInside.dom.append('div', 'tocButton');
	Monocle.Events.listenForTap(tocDiv, showTOC);
    
    // contentsForBook(tocDiv, reader.getBook());
	
	
    var cntr = cntrWrapper.dom.append('div', k.CLS.container);
    var track = cntr.dom.append('div', cntr);

    var track = cntr.dom.append('div', k.CLS.track);
    var needleTrail = cntr.dom.append('div', k.CLS.trail);
    var needle = cntr.dom.append('div', k.CLS.needle);
    var bubble = cntr.dom.append('div', k.CLS.bubble);

    var cntrListeners, bodyListeners;

    var moveEvt = function (evt, x) {
      evt.preventDefault();
      x = (typeof x == "number") ? x : evt.m.registrantX;
      var place = pixelToPlace(x, cntr);
      setX(needle, x - needle.offsetWidth / 2);
      var book = p.reader.getBook();
      var chps = book.chaptersForComponent(place.componentId);
      var cmptIndex = p.componentIds.indexOf(place.componentId);
      var chp = chps[Math.floor(chps.length * place.percentageThrough)];
      if (cmptIndex > -1 && book.properties.components[cmptIndex]) {
        var actualPlace = Monocle.Place.FromPercentageThrough(
          book.properties.components[cmptIndex],
          place.percentageThrough
        );
        chp = actualPlace.chapterInfo() || chp;
      }

      if (chp) {
        bubble.innerHTML = chp.title;
      }
      setX(bubble, x - bubble.offsetWidth / 2);

      p.lastX = x;
      return place;
    }

    var endEvt = function (evt) {
      var place = moveEvt(evt, p.lastX);
      p.reader.moveTo({
        percent: place.percentageThrough,
        componentId: place.componentId
      });
      Monocle.Events.deafenForContact(cntr, cntrListeners);
      Monocle.Events.deafenForContact(document.body, bodyListeners);
      bubble.style.display = "none";
    }

    var startFn = function (evt) {
      bubble.style.display = "block";
      moveEvt(evt);
      cntrListeners = Monocle.Events.listenForContact(
        cntr,
        { move: moveEvt }
      );
      bodyListeners = Monocle.Events.listenForContact(
        document.body,
        { end: endEvt }
      );
    }

    Monocle.Events.listenForContact(cntr, { start: startFn });

    return cntrWrapper;
  }




  API.createControlElements = createControlElements;
  API.updateNeedles = updateNeedles;

  initialize();

  return API;
}

Monocle.Controls.Scrubber.CLS = {
  container: 'controls_scrubber_container',
  track: 'controls_scrubber_track',
  needle: 'controls_scrubber_needle',
  trail: 'controls_scrubber_trail',
  bubble: 'controls_scrubber_bubble'
}

Monocle.Controls.Scrubber.MAGNIFICATION = 1.15;

// NB: If you don't like the reset, you could set this to an empty string.
Monocle.Controls.Scrubber.RESET_STYLESHEET =
  "html, body, div, span," +
  //"h1, h2, h3, h4, h5, h6, " +
  "p, blockquote, pre," +
  "abbr, address, cite, code," +
  "del, dfn, em, img, ins, kbd, q, samp," +
  "small, strong, sub, sup, var," +
  "b, i," +
  "dl, dt, dd, ol, ul, li," +
  "fieldset, form, label, legend," +
  "table, caption, tbody, tfoot, thead, tr, th, td," +
  "article, aside, details, figcaption, figure," +
  "footer, header, hgroup, menu, nav, section, summary," +
  "time, mark " +
  "{ font-size: 100% !important; }" +
  "h1 { font-size: 2em !important }" +
  "h2 { font-size: 1.8em !important }" +
  "h3 { font-size: 1.6em !important }" +
  "h4 { font-size: 1.4em !important }" +
  "h5 { font-size: 1.2em !important }" +
  "h6 { font-size: 1.0em !important }";

Monocle.pieceLoaded('controls/scrubber');
