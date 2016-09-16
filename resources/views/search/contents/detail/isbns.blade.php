@if(isset($result->isbns) and !empty($result->isbns))
<div class="isbns">
    <table border="0" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td class="col-sm-1 col-md-1"><span class="item-summary">ISBN/ISSN/EAN&nbsp;:&nbsp;</span></td>
                <td align="justify">
                    <div>
                        @foreach($result->isbns as $isbn)
                        <span data-isbn="{{ cleanIsbn($isbn) }}">{{ $isbn }}</span> @endforeach
                    </div>
                    <div id="GoogleBooksPreview-{{cleanIsbn($isbn)}}" class="hidden">
                        <div id="viewerCanvas-{{cleanIsbn($isbn)}}" style="width: 600px; height: 500px;"></div>
                    </div>
                    <script type="text/javascript">
                        var selector = "GoogleBooksPreview-{{cleanIsbn($isbn)}}",
                        googleBooksWidget = document.getElementById(selector), viewerCanvas = "viewerCanvas-{{cleanIsbn($isbn)}}";
                        
                        function BooksFound() {
                           /** googleBooksWidget.className = ""; **/
                            console.log("BooksFound %o", selector);
                        }
                        
                        function BooksNotFound() {
                            console.log("BooksNotFound %o", selector);
                        }
                        google.books.load({"language": "fr"});

                        function initialize() {
                            var googleViewerCanvas = document.getElementById(viewerCanvas);
                            var viewer = new google.books.DefaultViewer(googleViewerCanvas, {showLinkChrome: false}),
                            valueIsbn = "{{cleanIsbn($isbn)}}";
                            viewer.load('ISBN:'+ valueIsbn , BooksNotFound, BooksFound);
                        }
                        google.books.setOnLoadCallback(initialize);
                    </script>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endif