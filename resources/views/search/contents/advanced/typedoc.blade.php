<div class="row">
    <fieldset class="col-md-6">
        <legend>Type de document&nbsp;:</legend>
        <div class="now">
            <div class="col-md-6">
                <div class="be-checkbox">
                    <input type="checkbox" name="typeDoc[a]" value="a" id="cb-doc-a1">
                    <label for="cb-doc-a1">{{ trans('search.advanced.type-doc.a') }}</label>
                </div>
                <div class="be-checkbox">
                    <input type="checkbox" name="typeDoc[c]" value="c" id="cb-doc-a2">
                    <label for="cb-doc-a2">{{ trans('search.advanced.type-doc.c') }}</label>
                </div>
                <div class="be-checkbox">
                    <input type="checkbox" name="typeDoc[i]" value="i" id="cb-doc-a3">
                    <label for="cb-doc-a3">{{ trans('search.advanced.type-doc.i') }}</label>
                </div>
                <div class="be-checkbox">
                    <input type="checkbox" name="typeDoc[e]" value="e" id="cb-doc-a4">
                    <label for="cb-doc-a4">{{ trans('search.advanced.type-doc.e') }}</label>
                </div>
                <div class="be-checkbox">
                    <input type="checkbox" name="typeDoc[g]" value="g" id="cb-doc-a5">
                    <label for="cb-doc-a5">{{ trans('search.advanced.type-doc.g') }}</label>
                </div>
                <div class="be-checkbox">
                    <input type="checkbox" name="typeDoc[h]" value="h" id="cb-doc-a6">
                    <label for="cb-doc-a6">{{ trans('search.advanced.type-doc.h') }}</label>
                </div>
                <div class="be-checkbox">
                    <input type="checkbox" name="typeDoc[s]" value="s" id="cb-doc-a7">
                    <label for="cb-doc-b1">{{ trans('search.advanced.type-doc.s') }}</label>
                </div>
                <div class="be-checkbox">
                    <input type="checkbox" name="typeDoc[r]" value="r" id="cb-doc-a8">
                    <label for="cb-doc-b2">{{ trans('search.advanced.type-doc.r') }}</label>
                </div>
                <div class="be-checkbox">
                    <input type="checkbox" name="typeDoc[t]" value="t" id="cb-doc-a9">
                    <label for="cb-doc-b3">{{ trans('search.advanced.type-doc.t') }}</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="be-checkbox">
                    <input type="checkbox" name="typeDoc[am]" value="am" id="cb-doc-b1">
                    <label for="cb-doc-b1">{{ trans('search.advanced.type-doc.am') }}</label>
                </div>
                <div class="be-checkbox">
                    <input type="checkbox" name="typeDoc[m]" value="m" id="cb-doc-b2">
                    <label for="cb-doc-b2">{{ trans('search.advanced.type-doc.m') }}</label>
                </div>
                <div class="be-checkbox">
                    <input type="checkbox" name="typeDoc[f]" value="f" id="cb-doc-b3">
                    <label for="cb-doc-b3">{{ trans('search.advanced.type-doc.f') }}</label>
                </div>
                <div class="be-checkbox">
                    <input type="checkbox" name="typeDoc[j]" value="j" id="cb-doc-b4">
                    <label for="cb-doc-b4">{{ trans('search.advanced.type-doc.j') }}</label>
                </div>
                <div class="be-checkbox">
                    <input type="checkbox" name="typeDoc[d]" value="d" id="cb-doc-b5">
                    <label for="cb-doc-b5">{{ trans('search.advanced.type-doc.d') }}</label>
                </div>
                <div class="be-checkbox">
                    <input type="checkbox" name="typeDoc[k]" value="k" id="cb-doc-b6">
                    <label for="cb-doc-b6">{{ trans('search.advanced.type-doc.k') }}</label>
                </div>
                <div class="be-checkbox">
                    <input type="checkbox" name="typeDoc[p]" value="p" id="cb-doc-b7">
                    <label for="cb-doc-b7">{{ trans('search.advanced.type-doc.p') }}</label>
                </div>
                <div class="be-checkbox">
                    <input type="checkbox" name="typeDoc[o]" value="o" id="cb-doc-b8">
                    <label for="cb-doc-b8">{{ trans('search.advanced.type-doc.o') }}</label>
                </div>
            </div>
        </div>
    </fieldset>
    <div class="col-md-1"></div>
    <fieldset class="col-md-5">
        <legend>Type de notice&nbsp;:</legend>

        <div class="be-checkbox">
            <input type="checkbox" data-site="Monographie" name="typeNotice[M]" id="cb-m3-n1">
            <label for="cb-m3-n1">
                Monographie&nbsp;<a href="#" class="pictos picto-help" data-toggle="tooltip" data-placement="top"
                                    rel="tooltip" data-hasqtip="9" oldtitle="Document décrit à l'unité." title=""
                                    aria-describedby="qtip-9"><i class="icon-help" title="" data-icon=""></i></a>
            </label>
        </div>
        <div class="be-checkbox">
            <input type="checkbox" data-site="Périodique" name="typeNotice[S]" id="cb-m3-n2">

            <label for="cb-m3-n2">
                Périodique&nbsp;<a href="#" class="pictos picto-help" data-toggle="tooltip" data-placement="top"
                                   rel="tooltip" data-hasqtip="10"
                                   oldtitle="Publication qui paraît généralement à intervalles réguliers, sous un titre donné, en fascicules numérotés et/ou datés."
                                   title="" aria-describedby="qtip-10"><i class="icon-help" title=""
                                                                          data-icon=""></i></a>
            </label>
        </div>
        <div class="be-checkbox">
            <input type="checkbox" data-site="Recueil" name="typeNotice[R]" id="cb-m3-n3">
            <label for="cb-m3-n3">
                Recueil&nbsp;<a href="#" class="pictos picto-help" data-toggle="tooltip" data-placement="top"
                                rel="tooltip" data-hasqtip="11"
                                oldtitle="Regroupement a posteriori de documents de même nature (par exemple, recueil de tracts ou d'affiches)."
                                title="" aria-describedby="qtip-11"><i class="icon-help" title="" data-icon=""></i></a>
            </label>
        </div>
        <div class="be-checkbox">
            <input type="checkbox" data-site="Collection éditoriale" name="typeNotice[C]" id="cb-m3-n4">
            <label for="cb-m3-n4">
                Collection éditoriale&nbsp;<a href="#" class="pictos picto-help" data-toggle="tooltip"
                                              data-placement="top" rel="tooltip" data-hasqtip="12"
                                              oldtitle="Regroupement éditorial de documents publiés séparément, ayant chacun son titre particulier, et dont le nombre n'est pas décidé à l'avance."
                                              title="" aria-describedby="qtip-12"><i class="icon-help" title=""
                                                                                     data-icon=""></i></a>
            </label>
        </div>
        <div class="be-checkbox">
            <input type="checkbox" data-site="Ensemble" name="typeNotice[E]" id="cb-m3-n5">
            <label for="cb-m3-n5">
                Ensemble&nbsp;<a href="#" class="pictos picto-help" data-toggle="tooltip" data-placement="top"
                                 rel="tooltip" data-hasqtip="13"
                                 oldtitle="Regroupement éditorial de documents publiés séparément (par exemple cycle de romans ou série cartographique)."
                                 title="" aria-describedby="qtip-13"><i class="icon-help" title=""
                                                                        data-icon=""></i></a>
            </label>
        </div>
    </fieldset>
</div>