(function ($, undefined) {
  function loadPviewer(lang) {
    google.books.load({"language": lang});
  }

  function initialize(isbn) {
     //googleBooksWidget = $('#canvas-'+ isbn);
     googleBooksWidget = document.getElementById('canvas-'+ isbn);
     bookViewer = new google.books.DefaultViewer(googleBooksWidget, {showLinkChrome: false});
     bookViewer.load('ISBN:'+isbn, BooksNotFound, BooksFound);
  }
  function BooksFound() {

    //preview-
     /** googleBooksWidget.className = ""; **/
      console.log("BooksFound %o", googleBooksWidget);
  }

  function BooksNotFound() {
      //$(googleBooksWidget).style.display='none';
      //document.getElementById(googleBooksWidget).style.display='none';
      console.log("BooksNotFound %o", googleBooksWidget);
  }

  function BookShowPreview(isbn) {
    google.books.setOnLoadCallback(function() { initialize(isbn) });
  }

  $.createElement = function(tag, id) {
		elm = document.createElement(tag.toUpperCase());
		if (typeof(id) != "undefined") elm.id = id;
		return $(elm);
	};
//[id^="preview-"]
  $(document).filter('.list-item a[id^="preview-"]').on('click',function(e){


      console.log("reçu %o", viewer_id);
      /**
      $.books({
          selector: "#",
          language: 'fr',
          isbn: "",
          title: "",
          width: 600,
          height: 500
      });
      **/
  });

  $.books = $.fn.books = function(){
    var bookViewer, googleBooksWidget, selector, defaultOptions, viewer_link;
    defaultOptions = {selector: null, language: 'fr', isbn: null, width: 600, height: 500, title: null};
    
    $(document).off("click", '.preview');

    $(document).on({
      click: function (e){
        e.preventDefault();
        viewer_link = $(this);
        var viewer_id = viewer_link.attr('id'), dataBook = viewer_link.data('book');
        console.log("data book: %o", dataBook);
      }
    }, '.preview');

    //options = $.extend(defaultOptions, dataBook);
    //var elm = $.createElement('div', 'canvas-'+ options.isbn).attr({'style': "width: "+options.width+"px; height: "+options.height+"px;"});
    //selector.append(elm);
    //loadPviewer(options.language);
    //BookShowPreview(options.isbn);
  };
})(jQuery, undefined);
