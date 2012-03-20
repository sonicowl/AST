Monocle.Controls.Menu = function (reader) {
  if (Monocle.Controls == this) {
    return new Monocle.Controls.Menu(reader);
  }

  var API = { constructor: Monocle.Controls.Menu }
  var k = API.constants = API.constructor;
  var p = API.properties = {
    reader: reader
  }


  function createControlElements() {
    var div = reader.dom.make('div', 'controls_menu_container');
    MenuForBook(div, reader.getBook());
    return div;
  }


  function MenuForBook(div, book) {
    // while (div.hasChildNodes()) {
    //   div.removeChild(div.firstChild);
    // }
    // var list = div.dom.append('ol', 'controls_Menu_list');
    // 
    // var Menu = book.properties.Menu;
    // for (var i = 0; i < Menu.length; ++i) {
    //   chapterBuilder(list, Menu[i], 0);
    // }
  }


  function chapterBuilder(list, chp, padLvl) {
    // var index = list.childNodes.length;
    // var li = list.dom.append('li', 'controls_Menu_chapter', index);
    // var span = li.dom.append(
    //   'span',
    //   'controls_Menu_chapterTitle',
    //   index,
    //   { html: chp.title }
    // );
    // span.style.paddingLeft = padLvl + "em";
    // 
    // var invoked = function () {
    //   p.reader.skipToChapter(chp.src);
    //   p.reader.hideControl(API);
    // }
    // 
    // Monocle.Events.listenForTap(li, invoked, 'controls_Menu_chapter_active');
    // 
    // if (chp.children) {
    //   for (var i = 0; i < chp.children.length; ++i) {
    //     chapterBuilder(list, chp.children[i], padLvl + 1);
    //   }
    // }
  }


  API.createControlElements = createControlElements;

  return API;
}

Monocle.pieceLoaded('controls/Menu');
