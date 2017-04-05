<div class="form-group">
    <label for="language">@lang('search.advanced.date_of_publication_creation')</label>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <div class="be-radio inline">
                            <input name="datePub[yearOption]" id="predefined" value="predefined" type="radio">
                            <label for="predefined" class="screen-readers-only">@lang('search.advanced.predefined_year')</label>
                        </div>
                    </div>
                    <div id="predefined-date" class="col-md-4 is-active">
                        <select title="Limiter les résultats à une année prédéfinie" class="form-control input-sm select2 inline" id="year" name="datePub[year]">
                            <option selected value="1516-{{ date('Y') }}">@lang('search.advanced.every_year')</option>
                            <option value="{{ date('Y') -1 }}-{{ date('Y') }}">@lang('search.advanced.last_year')</option>
                            <option value="{{ date('Y') -5 }}-{{ date('Y') }}">@lang('search.advanced.five_last_years')</option>
                            <option value="{{ date('Y') -10 }}-{{ date('Y') }}">@lang('search.advanced.ten_last_years')</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-12">
                        <div class="be-radio inline">
                            <input name="datePub[yearOption]" id="range" value="range" type="radio">
                            <label for="range" class="screen-readers-only">@lang('app.custom')</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="group-form" id="range-date">
                            <span>
                                <label for="from-year">@lang('search.advanced.from')</label>
                                <input title="Année" name="datePub[fromYear]" class="form-control input-sm" id="from-year" size="9" type="text" placeholder="AAAA" maxlength="4">
                                <label for="to-year">@lang('search.advanced.to')</label>
                                <input title="Année" name="datePub[toYear]" class="form-control input-sm" id="to-year" size="9" type="text" placeholder="AAAA" maxlength="4">
                            </span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>