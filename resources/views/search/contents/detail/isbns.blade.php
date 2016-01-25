@if(isset($result->isbns) and !empty($result->isbns))
    <div class="isbns">
        <table border="0" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
                <td class="col-sm-1 col-md-1"><span class="item-summary">ISBN/ISSN/EAN&nbsp;:&nbsp;</span></td>
                <td align="justify">
                    <div>
                        @foreach($result->isbns as $isbn)
                        <span>{{ $isbn }}</span>
                        @endforeach
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@endif