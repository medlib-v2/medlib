<template lang="html">
    <div>
        <section class="content-search-section" role="search">
            <header class="search">
                <h1 class="search-title"><span>{{ trans('app.name') }}<br> {{ trans('app.description') }}</span></h1>
                <form class="form-group" id="search_form" @submit.prevent="search" @keydown="form.errors.clear($event.target.name)" name="search_input" role="form">
                    <div class="input-group">
                        <input
                                autofocus="true"
                                id="ssearch"
                                autocomplete="off"
                                v-model="form.query"
                                type="text"
                                name="query"
                                class="form-search"
                                :placeholder="trans('search.txt.criteria')" />
                        <span class="input-group-btn">
                        <button id="submitButton" type="submit" class="btn btn-search"><i class="fa fa-search text-gray"></i></button>
                    </span>
                        <has-error :form="form" field="query"></has-error>
                    </div>
                    <div class="row no-margin">
                        <div class="col-xs-7 col-md-8 col-sm-8 no-padding">
                            <select
                                    v-model="form.qdb"
                                    name="qdb" :data-placeholder="trans('search.txt.library')"
                                    class="select2 form-control select2-offscreen"
                                    v-select2>
                                <option value disabled>{{ trans('search.txt.library') }}</option>
                                <option v-for="(instance, name) in datasource" :value="name">
                                    {{ instance.fullname }}
                                </option>
                            </select>
                            <has-error :form="form" field="qdb"></has-error>
                        </div>
                        <div class="col-xs-5 col-md-4 col-sm-4 no-padding">
                            <ul class="icons">
                                <li class="all active" title="Web Search" data-search-type="all">{{ trans('search.icons.all') }}</li>
                                <li class="images" title="Image Search" data-search-type="images">{{ trans('search.icons.images') }}</li>
                                <li class="books" title="Book Search" data-search-type="books">{{ trans('search.icons.books') }}</li>
                                <li class="videos" title="Video Search" data-search-type="videos">{{ trans('search.icons.videos') }}</li>
                            </ul>
                        </div>
                    </div>
                    <ul class="search-menu">
                        <li>
                            <a id="advenced-options" href="#advence-options" class="dropdown-toggle" data-toggle="dropdown">{{ trans('search.txt.advanced') }}</a>
                            <div id="description-options" class="description" style="display:none">
                                <div class="col-xs-12 col-sm-6 col-md-4 checkbox checkbox-primary">
                                    <input v-model="form.title" name="title" value="ti" checked="checked" type="checkbox" id="title">
                                    <label for="title">{{ trans('search.txt.title') }}</label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 checkbox checkbox-primary">
                                    <input name="author" value="au" type="checkbox" id="author">
                                    <label for="author">{{ trans('search.txt.author') }}</label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 checkbox checkbox-primary">
                                    <input name="publisher" value="pb" type="checkbox" id="publisher">
                                    <label for="publisher">{{ trans('search.txt.publisher') }}</label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 checkbox checkbox-primary">
                                    <input name="uniforme" value="ut" type="checkbox" id="uniforme">
                                    <label for="uniforme">{{ trans('search.txt.uniforme') }}</label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 checkbox checkbox-primary">
                                    <input name="dofpublisher" value="yr" type="checkbox" id="dofpublisher">
                                    <label for="dofpublisher">{{ trans('search.txt.dofpublisher') }}</label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 checkbox checkbox-primary">
                                    <input name="keywords" value="kw" type="checkbox" id="keywords">
                                    <label for="keywords">{{ trans('search.txt.keywords') }}</label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 checkbox checkbox-primary">
                                    <input name="abstract" value="nt" type="checkbox" id="abstract">
                                    <label for="abstract">{{ trans('search.txt.abstract') }} </label>
                                </div>
                            </div>
                        </li>
                        <li><a href="#/search/advanced">{{ trans('search.txt.advanced_search') }}</a></li>
                    </ul>
                </form>
            </header>
        </section>
        <main id="content" class="content" role="main">
            <div class="form-group">
                <div class="now">
                    <div id="wrapper" class="col-sm-6 col-md-6">
                        <div id="book-details"></div>
                        <div id="books" class="books-items"></div>
                        <div id="more-books"></div>
                        <div class="information">
                            <h6 v-html="trans('app.explore_universe')"></h6>
                            <hr>
                            <p class="paraf" v-html="trans('app.universe')"></p>
                        </div>
                    </div>
                    <div class="col-sm-1 col-md-1"></div>
                    <div class="col-sm-6 col-md-6 pull-right" style="padding-top: 60px;">
                        <div class="information">
                            <h6 v-html="trans('app.discover_suggestions')"></h6>
                            <hr>
                            <p class="paraf" v-html="trans('app.discover_suggestions_content')"></p>
                        </div>
                        <div class="books-items">
                            <div class="images-social">
                                <img src="/images/reader-no-bg.png" alt="social icone">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script type="text/babel">
    import lang from '@/mixins/lang'
    import { Form } from '@/components/Form'
    import { Setting } from  '@/utils'

    export default {
        mixins: [lang],

        data () {
            return {
                /**
                 * Create the form instance
                 */
                form: new Form({
                    qdb: '',
                    query: '',
                    title: 'ti'
                }),
                datasource: Setting.datasource
            }
        },
        methods : {
            search () {
                this.$router.push({
                    name: 'search.simple',
                    query: this.form.data()
                })
            }
        }
    }
</script>
