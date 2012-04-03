Monocle.Controls.Contents = function (reader) {
  if (Monocle.Controls == this) {
    return new Monocle.Controls.Contents(reader);
  }

  var API = { constructor: Monocle.Controls.Contents }
  var k = API.constants = API.constructor;
  var p = API.properties = {
    reader: reader
  }

 var closeBtn;


  function createControlElements() {
    var div = reader.dom.make('div', 'controls_contents_container');
    contentsForBook(div, reader.getBook());
    return div;
  }


  function contentsForBook(div, book) {
    while (div.hasChildNodes()) {
      div.removeChild(div.firstChild);
    }

    var textH = div.dom.append('div', 'tableOfContentsTitle');

    closeBtn = div.dom.append('div', 'closeBtn');

    textH.innerHTML = 'Table Of Contents';

    var list = div.dom.append('ol', 'controls_contents_list');

    var contents = book.properties.contents;
    for (var i = 0; i < contents.length; ++i) {
      chapterBuilder(list, contents[i], 0);
    }
  }


  function chapterBuilder(list, chp, padLvl) {
    var index = list.childNodes.length;
    var li = list.dom.append('li', 'controls_contents_chapter', index);

 
    // var span = li.dom.append(
    //   'span',
    //   'controls_contents_chapterTitle',
    //   index,
    //   { html: '<a href="index.php?c='+chp.chp+'">'+chp.title+'</a>' }
    // );
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

    Monocle.Events.listenForTap(closeBtn, function(){p.reader.hideControl(API);});

    if (chp.children) {
      for (var i = 0; i < chp.children.length; ++i) {
        chapterBuilder(list, chp.children[i], padLvl + 1);
      }
    }
  }


  API.createControlElements = createControlElements;

  return API;
}

Monocle.pieceLoaded('controls/contents');
