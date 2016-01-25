@if(isset($result->summary))
<div class="summary">
    <table border="0" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td class="col-sm-1 col-md-1"><span class="item-summary">Résumé&nbsp;:&nbsp;</span></td>
                <td align="justify">
                    <div class="more">
                        {{ $result->summary['text'] }}
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endif