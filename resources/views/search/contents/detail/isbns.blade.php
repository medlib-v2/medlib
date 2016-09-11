@if(isset($result->isbns) and !empty($result->isbns))
    <div class="isbns">
        <table border="0" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
                <td class="col-sm-1 col-md-1"><span class="item-summary">ISBN/ISSN/EAN&nbsp;:&nbsp;</span></td>
                <td align="justify">
                    <div>
                        @foreach($result->isbns as $isbn)
                        <span data-isbn="{{ cleanIsbn($isbn) }}">{{ $isbn }}</span>
                        @endforeach
                    </div>
                    <div id="GoogleBooksPreview-{{ cleanIsbn($isbn) }}" class="hidden">
                        <div id="viewerCanvas" style="height: 600px;"></div>
                    </div>
                    <script type="text/javascript">
                        var gbsWidget = document.getElementById("GoogleBooksPreview-{{ cleanIsbn($isbn) }}");

                        function gbsFound() {
                            
                        }
                        function gbsNotFound() {
                            gbsWidget.className = "hidden";
                        }
                        function initialize() {
                            gbsWidget.className = "";
                            var viewer = new google.books.DefaultViewer(document.getElementById('viewerCanvas'), {
                                showLinkChrome: false
                            });
                        viewer.load(["ISBN:{{ cleanIsbn($isbn) }}"], gbsNotFound, gbsFound);
                        }

                        google.load("books", "0");
                        google.setOnLoadCallback(initialize);        
                    </script>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@endif