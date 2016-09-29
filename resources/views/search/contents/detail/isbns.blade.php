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
                    <div id="books-{{cleanIsbn($isbn)}}" data-isbn="{{ cleanIsbn($isbn) }}" class="hidden"></div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endif
