<td class="spacer"></td>
<td class="content">
    <div id="pagination" class="jplist">
        <div class="jplist-panel panel-top">
            <!-- Begin results info -->
            @include('search.contents.pagination')
            <!-- End results info -->
            <div class="results-actions">
                <table cellspacing="0" width="100%">
                    <tbody>
                        <tr>
                            @include('search.contents.menu')
                        </tr>
                    </tbody>
                </table>
            </div>
            <br>
            <!-- END results-actions -->
            <div class="text-shadow">
                <div class="">
                    <div>
                        <p>Une erreur est survenue. Veuillez réessayer votre recherche plus tard.</p>
                    </div>
                </div>
            </div>
            <!-- Begin results info -->
            @include('search.contents.pagination')
            <!-- End results info -->
        </div>
    </div>
</td>