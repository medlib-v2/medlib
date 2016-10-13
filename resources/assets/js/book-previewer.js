(function ($, undefined) {
  var bookViewer = null, googleBooksWidget = null;

  function loadBPviewer(lang, brand) {
    google.books.load({"language": lang}, {"cobrand":brand});
    //google.load("books", "0", {"language":lang}, {"cobrand":brand});
  }

  function initialize(isbn) {
     googleBooksWidget = document.getElementById("viewerCanvas");
     bookViewer = new google.books.DefaultViewer(canvas, {showLinkChrome: false}),
     bookViewer.load('ISBN:'+isbn, BooksNotFound,BooksFound);
  }

  function BooksFound() {
     /** googleBooksWidget.className = ""; **/
      console.log("BooksFound %o", googleBooksWidget);
  }

  function BooksNotFound() {
      $(canvas).style.display='none';
      document.getElementById(googleBooksWidget).style.display='none';
      console.log("BooksNotFound %o", googleBooksWidget);
  }

  function BookShowPreview(isbn) {
    google.books.setOnLoadCallback(function() { initialize(isbn) });
}

  //google.books.setOnLoadCallback(initialize);

  $.books = $.fn.books = function(options){
    console.log("chargement", this);
  };
})(jQuery, undefined);
