@extends('layouts.master')

@section('title', trans('search.txt.advanced-text'))

@section('content')
<div class="content">
    <div id="page-content" class="container">
        <div id="h-wrapper" class="fix-float">
            <div id="content">
                <div class="clear"><!-- --></div>
                <div class="opac_action_links">
                    <div class="returnNavigation"></div>
                    <a href="searchHistory">Search History</a>&nbsp;|&nbsp;<a target="_blank" href="#">Help</a>
                </div>
                <div id="dialog_mask"><!-- --></div>
                <h1>{{ trans('search.txt.advanced-text') }}</h1>
            </div>

            <div class="opac_form" id="col2full_left">
                <div id="searchLayout">
                    <form id="searchBasic" accept-charset="UTF-8" method="GET" action="search">
                        <div id="buildAdvancedSearch">
                            <div class="searchAdvancedInputs">
                                <label for="searchArg1">Search</label>
                                <br>
                    <span class="argument">
                    	<label for="searchArg1">Search Argument1</label>&nbsp;
                        <input type="text" id="tooltip-enabled" class="form-control" data-placement="top" data-original-title="Enter your 1st search word(s)" placeholder="Enter your 1st search word(s)" title="Enter your 1st search word(s)" name="searchArg1" size="50" accesskey="s" >
                    </span>

                                </span><label for="searchCode1">within</label>&nbsp;<select title="Select the search index to search for the 1st word(s)" name="searchCode1" id="searchCode1"><option selected="" value="GKEY">Keyword Anywhere (GKEY)</option><option value="KTIL">Title: All (KTIL)</option><option value="KNUM">LCCN-ISBN-ISSN (KNUM)</option><option value="KPNC">Name: Personal (KPNC)</option><option value="K010">LC Control No/LCCN (K010)</option><option value="KSUB">Subject: ALL (KSUB)</option><option value="KISN">Intl Standard No (KISN)</option><option value="KNAM">Name: All (KNAM)</option><option value="KPUB">Publication Info (KPUB)</option><option value="KSER">Series (KSER)</option><option value="SKEY">Subject: Authorized (SKEY)</option><option value="KCNC">Name: Corp/Meeting (KCNC)</option><option value="KTUT">Title Uniform (KTUT)</option><option value="KNOT">Notes (KNOT)</option><option value="KSGE">Subject Geographic (KSGE)</option><option value="KCON">Contents Notes (KCON)</option><option value="KPRF">Credits/Performers (KPRF)</option><option value="KURL">Electronic Access (KURL)</option><option value="HKEY">Holdings Keyword (HKEY)</option><option value="KFOR">Form/Genre (subfields v, k plus) (KFOR)</option></select>&nbsp;&nbsp;&nbsp;<input type="hidden" name="searchType" value="2">
                            </div>
                            <div class="searchAdvancedInputs">
                                <span class="argument"><input title="" name="combine2" id="combine2_1" value="and" type="radio" checked=""><label for="combine2_1" class="boolean">AND</label>&nbsp;<input title="" name="combine2" id="combine2_2" value="or" type="radio"><label for="combine2_2" class="boolean">OR</label>&nbsp;<input title="" name="combine2" id="combine2_3" value="not" type="radio"><label for="combine2_3" class="boolean">NOT</label>&nbsp;</span>
                            </div>
                            <div class="searchAdvancedInputs">
                                <span class="argument"><label for="searchArg2">Search Argument2</label>&nbsp;<input title="Enter your 2nd search word(s)" id="searchArg2" name="searchArg2" size="50" type="text"></span><span class="argument"><label for="argType2">Search Argument Type2</label>&nbsp;<select title="Select how the 2nd word(s) should be handled" name="argType2" id="argType2"><option selected="" value="all">all of these</option><option value="any">any of these</option><option value="phrase">as a phrase</option></select></span><label for="searchCode2">within</label>&nbsp;<select title="Select the search index to search for the 2nd word(s)" name="searchCode2" id="searchCode2"><option selected="" value="GKEY">Keyword Anywhere (GKEY)</option><option value="KTIL">Title: All (KTIL)</option><option value="KNUM">LCCN-ISBN-ISSN (KNUM)</option><option value="KPNC">Name: Personal (KPNC)</option><option value="K010">LC Control No/LCCN (K010)</option><option value="KSUB">Subject: ALL (KSUB)</option><option value="KISN">Intl Standard No (KISN)</option><option value="KNAM">Name: All (KNAM)</option><option value="KPUB">Publication Info (KPUB)</option><option value="KSER">Series (KSER)</option><option value="SKEY">Subject: Authorized (SKEY)</option><option value="KCNC">Name: Corp/Meeting (KCNC)</option><option value="KTUT">Title Uniform (KTUT)</option><option value="KNOT">Notes (KNOT)</option><option value="KSGE">Subject Geographic (KSGE)</option><option value="KCON">Contents Notes (KCON)</option><option value="KPRF">Credits/Performers (KPRF)</option><option value="KURL">Electronic Access (KURL)</option><option value="HKEY">Holdings Keyword (HKEY)</option><option value="KFOR">Form/Genre (subfields v, k plus) (KFOR)</option></select>&nbsp;&nbsp;&nbsp;</div>
                            <div class="searchAdvancedInputs">
                                <span class="argument"><input title="" name="combine3" id="combine3_1" value="and" type="radio" checked=""><label for="combine3_1" class="boolean">AND</label>&nbsp;<input title="" name="combine3" id="combine3_2" value="or" type="radio"><label for="combine3_2" class="boolean">OR</label>&nbsp;<input title="" name="combine3" id="combine3_3" value="not" type="radio"><label for="combine3_3" class="boolean">NOT</label>&nbsp;</span>
                            </div>
                            <div class="searchAdvancedInputs">
                                <span class="argument"><label for="searchArg3">Search Argument3</label>&nbsp;<input title="Enter your 3rd search word(s)" id="searchArg3" name="searchArg3" size="50" type="text"></span><span class="argument"><label for="argType3">Search Argument Type3</label>&nbsp;<select title="Select how the 3rd word(s) should be handled" name="argType3" id="argType3"><option selected="" value="all">all of these</option><option value="any">any of these</option><option value="phrase">as a phrase</option></select></span><label for="searchCode3">within</label>&nbsp;<select title="Select the search index to search for the 3rd word(s)" name="searchCode3" id="searchCode3"><option selected="" value="GKEY">Keyword Anywhere (GKEY)</option><option value="KTIL">Title: All (KTIL)</option><option value="KNUM">LCCN-ISBN-ISSN (KNUM)</option><option value="KPNC">Name: Personal (KPNC)</option><option value="K010">LC Control No/LCCN (K010)</option><option value="KSUB">Subject: ALL (KSUB)</option><option value="KISN">Intl Standard No (KISN)</option><option value="KNAM">Name: All (KNAM)</option><option value="KPUB">Publication Info (KPUB)</option><option value="KSER">Series (KSER)</option><option value="SKEY">Subject: Authorized (SKEY)</option><option value="KCNC">Name: Corp/Meeting (KCNC)</option><option value="KTUT">Title Uniform (KTUT)</option><option value="KNOT">Notes (KNOT)</option><option value="KSGE">Subject Geographic (KSGE)</option><option value="KCON">Contents Notes (KCON)</option><option value="KPRF">Credits/Performers (KPRF)</option><option value="KURL">Electronic Access (KURL)</option><option value="HKEY">Holdings Keyword (HKEY)</option><option value="KFOR">Form/Genre (subfields v, k plus) (KFOR)</option></select>&nbsp;&nbsp;&nbsp;</div>
                            <div id="searchLimits">
                                <span class="limits_add" id="toggleLimits"><a aria-live="polite" aria-controls="limitsContainer" role="button" aria-label="Expand/Collapse Search Limits" title="Expand/Collapse Search Limits" href="#" id="limitsToggle" aria-expanded="false">Add Limits</a></span><span aria-live="polite" role="status" class="readerMsg" id="limitsStatus">Search limits collapsed</span>
                            </div>
                            <div class="limits_container" id="limitsContainer" aria-hidden="true" style="display: none;">
                                <div class="limitDiv">
                                    <span class="label">Year Published/Created</span>
                                    <br>
                                    <span id="yearSpan"><label for="defined" class="readerMsg">Predefined Year Range</label>&nbsp;<input title="" id="defined" name="yearOption" value="defined" type="radio">&nbsp;<label for="year">Year</label>&nbsp;<select title="Limit results to a predefined year range" name="year" id="year"><option selected="" value="1515-2015">All Years</option><option value="2014-2015">Past Year</option><option value="2010-2015">Last 5 Years</option><option value="2005-2015">Last 10 Years</option></select></span><span id="yearRange"><label for="range" class="readerMsg">Custom Year Range</label>&nbsp;<input title="" id="range" name="yearOption" value="range" type="radio">&nbsp;<label for="fromYear">From</label>&nbsp;<input title="Enter a start year to limit within a range" id="fromYear" name="fromYear" size="7" type="text">&nbsp;<label for="toYear">To</label>&nbsp;<input title="Enter an end year to limit within a range" id="toYear" name="toYear" size="7" type="text"></span>
                                </div>
                                <div class="limitDiv">
                                    <label for="location">Location in the Library</label>
                                    <br>
                                    <select title="Select to limit by location" size="5" multiple="" name="location" id="location"><option selected="" value="all">All Locations</option><option value=".General Collections">.General Collections</option><option value=".Reference Collections, ALL">.Reference Collections, ALL</option><option value="African Reference Collection">African Reference Collection</option><option value="African/Middle Eastern">African/Middle Eastern</option><option value="African/Middle Eastern Reference Collection">African/Middle Eastern Reference Collection</option><option value="American Folklife">American Folklife</option><option value="American Folklife Reference Collection">American Folklife Reference Collection</option><option value="Asian">Asian</option><option value="Asian Reference Collection">Asian Reference Collection</option><option value="Business Reference Collection">Business Reference Collection</option><option value="Children's Literature Reference Collection">Children's Literature Reference Collection</option><option value="European">European</option><option value="European Reference Collection">European Reference Collection</option><option value="Geography &amp; Map">Geography &amp; Map</option><option value="Geography &amp; Map Reference Collection">Geography &amp; Map Reference Collection</option><option value="Hebraic Reference Collection">Hebraic Reference Collection</option><option value="Hispanic Reference Collection">Hispanic Reference Collection</option><option value="Law">Law</option><option value="Law Reference Collection">Law Reference Collection</option><option value="Local History &amp; Genealogy Reference Collection">Local History &amp; Genealogy Reference Collection</option><option value="Machine Readable">Machine Readable</option><option value="Main Reading Room Reference Collection">Main Reading Room Reference Collection</option><option value="Manuscript">Manuscript</option><option value="Manuscript Reference Collection">Manuscript Reference Collection</option><option value="Microform">Microform</option><option value="Microform Reference Collection">Microform Reference Collection</option><option value="Motion Picture &amp; Television">Motion Picture &amp; Television</option><option value="Motion Picture &amp; Television Reference Collection">Motion Picture &amp; Television Reference Collection</option><option value="Near East Reference Collection">Near East Reference Collection</option><option value="Newspaper &amp; Current Periodical">Newspaper &amp; Current Periodical</option><option value="Newspaper &amp; Current Periodical Reference Collection">Newspaper &amp; Current Periodical Reference Collection</option><option value="Performing Arts">Performing Arts</option><option value="Performing Arts Reference Collection">Performing Arts Reference Collection</option><option value="Prints &amp; Photographs">Prints &amp; Photographs</option><option value="Prints &amp; Photographs Reference Collection">Prints &amp; Photographs Reference Collection</option><option value="Rare Book &amp; Special Collections">Rare Book &amp; Special Collections</option><option value="Rare Book &amp; Special Collections Reference Collection">Rare Book &amp; Special Collections Reference Collection</option><option value="Recorded Sound">Recorded Sound</option><option value="Recorded Sound Reference Collection">Recorded Sound Reference Collection</option><option value="Science &amp; Technology Reference Collection">Science &amp; Technology Reference Collection</option><option value="Special Format Collections, ALL">Special Format Collections, ALL</option></select>
                                </div>
                                @include('search.advanced.content.country')
                                <div class="limitDiv">
                                    <label for="type">Type of Material</label>
                                    <br>
                                    <select title="Select to limit by type" name="type" id="type" size="5" multiple=""><option selected="" value="all">All Types</option><option value="a?">All Text (Books, Periodicals, etc.)</option><option value="p?">Archival Manuscript/Mixed Formats</option><option value="am">Book</option><option value="g?">Film or Video</option><option value="e?">Map</option><option value="f?">Map (Manuscript)</option><option value="j?">Music Recording</option><option value="c?">Music Score</option><option value="d?">Music Score (Manuscript)</option><option value="i?">Nonmusic Recording</option><option value="?s">Periodical or Newspaper</option><option value="k?">Photograph, Print, or Drawing</option><option value="t?">Rare Book or Manuscript</option><option value="m?">Software or E-Resource</option><option value="r?">3-D Object</option></select>
                                </div>
                                @include('search.advanced.content.language')
                            </div>
                            <div class="searchButtons">
                                <p class="box-btns">
                                    <span title="" class="btns-left" id="searchRecs"><label for="recCount">Records per page:</label>&nbsp;<select title="Select how many records to display per page." name="recCount" id="recCount"><option selected="" value="25">25</option><option value="50">50</option><option value="75">75</option><option value="100">100</option></select></span><button title="Clear" value="Clear" type="reset" id="page.search.clear.button">Clear</button>&nbsp;&nbsp;<button title="Search" type="submit" name="page.search.search.button" class="primary" id="page.search.search.button" value="Search">Search</button>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="pageHTMLSnippet">
                    <div class="searchTip">
                        <h2>Advanced Search Tips</h2>
                        <ol>
                            <li>Enter your search term(s) in the <strong>Search</strong> box(es):<ul>
                                    <li>Capitalization does not matter.</li>
                                    <li>Use a <em>percent sign</em> ( % ) as a single-character wildcard, either inside or at the end of a search word: wom%n<br>
                                        <em>Note</em>: If your search term contains a percent sign, remove the %. Enter <em>5% Nation</em> as <strong>5 Nation</strong>
                                    </li>
                                    <li>Use a <em>question mark</em> ( ? ) for truncation (different forms of a root word) and as a multiple-character wildcard, either inside or at the end of a search word: <strong>entrepr?</strong> or <strong>col?r</strong>
                                    </li>
                                    <li>Most punctuation marks (hyphens, slashes, periods, etc.) are replaced by spaces. Because spaces are used to divide words, remove hyphens from ISBN but not ISSN number searches. Enter <em>0394487249</em> for ISBN <strong>0-394-48724-9</strong>, but enter <em>0028-7806</em> for ISSN <strong>0028-7806</strong>
                                    </li>
                                </ul>
                            </li>
                            <li>Select <strong>all of these</strong>, <strong>any of these</strong>, or <strong>as a phrase</strong> from the drop-down list to specify how you want multiple words to be combined.</li>
                            <li>Narrow the scope of your search by changing <em>Keyword Anywhere (GKEY)</em> to the index of your choice in the next drop-down list (after <strong>within</strong>).</li>
                            <li>Add to your search by selecting a <a href="ui/en_US/htdocs/help/searchBoolean.html">Boolean operator</a> (<strong>AND</strong>, <strong>OR</strong>, <strong>NOT</strong>) and entering more search terms.</li>
                            <li>Refine your search by adding limits.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="div-maincol">

    <form name="search" id="advancedSearchForm" method="get" action="/search">
        <input name="qt" value="advanced" type="hidden">
        <input id="advancedSearchDatabasesInput" name="dblist" value="638" type="hidden">
        <!-- BEGIN search-advanced -->
        <div id="search-advanced">
            <center>
                <table class="table1" cellspacing="0">
                    <tbody><tr>
                        <td style="padding: 15px 20px;">

                            <table cellspacing="0" style="width:100%">

                                <tbody><tr>
                                    <td colspan="2">
                                        <br>
                                        <div id="dbalert_top" style="border: 1px solid rgb(255, 153, 0); margin: 0px 5px 5px; padding: 6px 10px 10px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; width: 650px; display: block; font-size: 85%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; display: none;">
                                            <img alt=" " style="float: left;" src="https://static1.worldcat.org/wcpa/rel20151119/images/database_error.png">
<span id="dbalert_top_text" style="text-align: left;">
</span>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <h1 class="search" style="margin-bottom:0;">{{ trans('search.txt.advanced-text') }}</h1>
                                    </td>
                                    <td style="padding:0; text-align:right;">
                                        <input name="submit" value="Chercher" class="btn-large" type="submit">
                                        <input name="clear" value="Effacer" class="btn-large" type="button" onclick="clearForm(this.form, 0)">
                                    </td>
                                </tr>

                                <!-- BEGIN error -->
                                <!-- END error -->

                                </tbody></table>

                            <table cellspacing="0" width="100%">
                                <tbody><tr>
                                    <th colspan="2" style="background: #ccc;">Inscrivez des termes de recherche dans au moins une des zones ci-dessous</th>
                                </tr>
                                <tr>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="label">
                                            <label class="screen-reader" for="search1">Index de recherche&nbsp;: (1)</label>
                                            <select id="search1" name="search1" style="font-weight: bold; width: 225px;">
                                                <option value="idx_no">Numéro d’accès&nbsp;:</option>
                                                <option value="idx_au">Auteur&nbsp;:</option>
                                                <option value="idx_bn">ISBN&nbsp;:</option>
                                                <option value="idx_n2">ISSN&nbsp;:</option>
                                                <option value="idx_so">Source de périodique&nbsp;:</option>
                                                <option selected="" value="idx_kw">Mot-clé&nbsp;:</option>
                                                <option value="idx_su">Sujet&nbsp;:</option>
                                                <option value="idx_ti">Titre&nbsp;:</option>
                                            </select>
                                        </div>
                                        <div id="search1description" class="description"></div>
                                    </td>
                                    <td id="text1">
                                        <label for="search1input" class="screen-reader">Inscrivez des termes de recherche&nbsp;: (1)</label>
                                        <input id="search1input" name="i1" size="50" class="text" type="text">
                                        <div id="search1example" class="eg"></div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="label">
                                            <label class="screen-reader" for="search2">Index de recherche&nbsp;: (2)</label>
                                            <select id="search2" name="search2" style="font-weight: bold; width: 225px;">
                                                <option value="idx_no">Numéro d’accès&nbsp;:</option>
                                                <option value="idx_au">Auteur&nbsp;:</option>
                                                <option value="idx_bn">ISBN&nbsp;:</option>
                                                <option value="idx_n2">ISSN&nbsp;:</option>
                                                <option value="idx_so">Source de périodique&nbsp;:</option>
                                                <option value="idx_kw">Mot-clé&nbsp;:</option>
                                                <option value="idx_su">Sujet&nbsp;:</option>
                                                <option selected="" value="idx_ti">Titre&nbsp;:</option>
                                            </select>
                                        </div>
                                        <div id="search2description" class="description"></div>
                                    </td>
                                    <td id="text2">
                                        <label for="search2input" class="screen-reader">Inscrivez des termes de recherche&nbsp;: (2)</label>
                                        <input id="search2input" name="i2" size="50" class="text" type="text">
                                        <div id="search2example" class="eg"></div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="label">
                                            <label class="screen-reader" for="search3">Index de recherche&nbsp;: (3)</label>
                                            <select id="search3" name="search3" style="font-weight: bold; width: 225px;">
                                                <option value="idx_no">Numéro d’accès&nbsp;:</option>
                                                <option selected="" value="idx_au">Auteur&nbsp;:</option>
                                                <option value="idx_bn">ISBN&nbsp;:</option>
                                                <option value="idx_n2">ISSN&nbsp;:</option>
                                                <option value="idx_so">Source de périodique&nbsp;:</option>
                                                <option value="idx_kw">Mot-clé&nbsp;:</option>
                                                <option value="idx_su">Sujet&nbsp;:</option>
                                                <option value="idx_ti">Titre&nbsp;:</option>
                                            </select>
                                        </div>
                                        <div id="search3description" class="description"></div>
                                    </td>
                                    <td id="text3">
                                        <label for="search3input" class="screen-reader">Inscrivez des termes de recherche&nbsp;: (3)</label>
                                        <input id="search3input" name="i3" size="50" class="text" type="text">
                                        <div id="search3example" class="eg"></div>
                                    </td>
                                </tr>

                                <tr>
                                    <th colspan="2" style="background: #ccc;">Limitez votre recherche <span style="font-weight: normal;">(facultatif)</span></th>
                                </tr>
                                <tr>
                                </tr>
                                <tr>
                                    <td class="optional">
                                        <div class="label"><label for="yrf">Année&nbsp;:</label></div>
                                        <div class="description">Retourner uniquement les ouvrages publiés entre</div></td>

                                    <td class="optional">
                                        <table cellspacing="0">
                                            <tbody><tr>
                                                <td style="padding: 0pt;"><input name="yrf" id="yrf" size="4" class="text" type="text">
                                                </td>
                                                <td><label for="yrt">et&nbsp;:</label>
                                                </td>
                                                <td style="padding: 0pt;"><input name="yrt" id="yrt" size="4" class="text" type="text">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 0pt;">
                                                    <div class="eg">ex.&nbsp;: 1971</div>
                                                </td>
                                                <td></td>
                                                <td style="padding: 0pt;">
                                                    <div class="eg">ex.&nbsp;: 1977</div>
                                                </td>
                                            </tr>
                                            </tbody></table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="optional">
                                        <div class="label"><label for="limit-3-mt">Public&nbsp;:</label></div>
                                        <div class="description">Retourner uniquement les ouvrages pour ce public</div></td>

                                    <td class="optional">
                                        <select name="limit-3-mt" id="limit-3-mt">
                                            <option value="" selected="">Tous les publics</option>
                                            <option value="mt:juv">Jeunesse</option>
                                            <option value="-mt:juv">Adulte</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="optional">
                                        <div class="label"><label for="limit-4-mt">Contenu&nbsp;:</label></div>
                                        <div class="description">Retourner uniquement les ouvrages avec ce contenu</div></td>

                                    <td class="optional">
                                        <select name="limit-4-mt" id="limit-4-mt">
                                            <option value="" selected="">Tous les contenus</option>
                                            <option value="mt:fic">Fiction</option>
                                            <option value="-mt:fic">Documentaire</option>
                                            <option value="mt:bio">Biographie</option>
                                            <option value="mt:deg">Thèses/dissertations</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="optional">
                                        <div class="label"><label for="limit-5-x0">Format&nbsp;:</label></div>
                                        <div class="description">Retourner uniquement les ouvrages dans ce format</div></td>

                                    <td class="optional">
                                        <select name="limit-5-x0" id="limit-5-x0">
                                            <option value="" selected="">Tous les formats</option>
                                            <option value="x0:archv">Documents d'archives</option>
                                            <option value="x0:artchap">Article</option>
                                            <option value="x0:audiobook">Livre audio</option>
                                            <option value="x0:audiobook + x4:digital">--- Livre audio électronique</option>
                                            <option value="x0:book">Livre</option>
                                            <option value="x0:book + x4:braille">---- Livre en braille</option>
                                            <option value="x0:book + x4:largeprint">---- Gros caractères</option>
                                            <option value="x0:book + x4:digital">---- Livre électronique</option>
                                            <option value="x0:compfile">Fichier d’ordinateur</option>
                                            <option value="x0:jrnl">Périodique, revue</option>
                                            <option value="x0:map">Carte géographique</option>
                                            <option value="x0:music">Musique</option>
                                            <option value="x0:msscr">Partition musicale</option>
                                            <option value="x0:news">Journal</option>
                                            <option value="(x0:web | x4:digital)">Site Web</option>
                                            <option value="(x0:snd | x0:audiobook | x0:music)">Enregistrement sonore</option>
                                            <option value="x0:game">Jeu</option>
                                            <option value="x0:vis">Matériel visuel</option>
                                            <option value="x0:image + x4:2d">---- Image téléchargeable</option>
                                            <option value="x0:video + x4:vhs">---- VHS</option>
                                            <option value="x0:video + x4:dvd">---- DVD</option>
                                            <option value="x0:vis + x4:digital">---- Matériel visuel téléchargeable</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="optional">
                                        <div class="label"><label for="limit-6-ln">Langue&nbsp;:</label></div>
                                        <div class="description">Retourner uniquement les ouvrages dans cette langue</div></td>

                                    <td class="optional">
                                        <select name="limit-6-ln" id="limit-6-ln">
                                            <option value="" selected="">Toutes les langues</option>
                                            <option value="ln:eng">Anglais</option>
                                            <option value="ln:ara">Arabe</option>
                                            <option value="ln:bul">Bulgare</option>
                                            <option value="ln:chi">Chinois</option>
                                            <option value="ln:hrv">Croate</option>
                                            <option value="ln:cze">Tchèque</option>
                                            <option value="ln:dan">Danois</option>
                                            <option value="ln:dut">Néerlandais</option>
                                            <option value="ln:eng">Anglais</option>
                                            <option value="ln:fre">Français</option>
                                            <option value="ln:ger">Allemand</option>
                                            <option value="ln:gre">Grec moderne [depuis 1453]</option>
                                            <option value="ln:heb">Hébreu</option>
                                            <option value="ln:hin">Hindi</option>
                                            <option value="ln:ind">Indonésien</option>
                                            <option value="ln:ita">Italien</option>
                                            <option value="ln:jpn">Japonais</option>
                                            <option value="ln:kor">Coréen</option>
                                            <option value="ln:lat">Latin</option>
                                            <option value="ln:nor">Norvégien</option>
                                            <option value="ln:per">Persan</option>
                                            <option value="ln:pol">Polonais</option>
                                            <option value="ln:por">Portugais</option>
                                            <option value="ln:rum">Roumain</option>
                                            <option value="ln:rus">Russe</option>
                                            <option value="ln:spa">Espagnol</option>
                                            <option value="ln:swe">Suédois</option>
                                            <option value="ln:tha">Thaï</option>
                                            <option value="ln:tur">Turc</option>
                                            <option value="ln:ukr">Ukrainien</option>
                                            <option value="ln:vie">Vietnamien</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <br>
                                        <div id="dbalert_bottom" style="border: 1px solid rgb(255, 153, 0); margin: 0px 5px 5px; padding: 6px 10px 10px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; width: 650px; display: block; font-size: 85%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; display: none;">
                                            <img alt=" " style="float: left;" src="https://static1.worldcat.org/wcpa/rel20151119/images/database_error.png">
<span id="dbalert_bottom_text" style="text-align: left;">
</span>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding:0px 0 0px 0; text-align:right;" colspan="2">
                                        <input name="submit" value="Chercher" class="btn-large" type="submit">
                                        <input name="clear" value="Effacer" class="btn-large" type="button" onclick="clearForm(this.form, 0)">
                                    </td>
                                </tr>

                                </tbody></table>
                        </td>
                    </tr>
                    </tbody></table>
            </center>
        </div>
    </form>

    <!-- END search-home -->
</div>
@endsection

@section('sytle')

@endsection

@section('script')
    <script src="/js/form-elements.js"></script>
@endsection