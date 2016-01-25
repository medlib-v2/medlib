<div class="">
    <div class="clearfix">
        <ul id="tabs1" class="nav nav-tabs pull-left"> <!-- remove pull-left to get a cool effect too -->
            <li class="active"><a href="#simple" data-toggle="tab">Recherche simple</a></li>
            <li class=""><a href="#advanced" data-toggle="tab">Recherche avancée</a></li>
        </ul>
    </div>
    <div id="tabs1c" class="tab-content mb-lg">
        <div class="tab-pane clearfix active" id="simple">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-sm-10">
                    @include('search.header.search-simple')
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
        <div class="tab-pane" id="advanced">
            @include('search.header.search-advanced')
        </div>
    </div>
</div>