<template lang="html">
    <div>
        <section class="content-search-results" role="search">
            <header class="result">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <form class="form-group" id="search" role="form">
                            <div class="input-group xs-mb-15">
                                <input id="ssearch"
                                       autocomplete="off"
                                       autofocus="true"
                                       class="form-control"
                                       :placeholder="trans('search.txt.criteria')"
                                       v-model="form.query"
                                       type="text" name="query" />
                                <span class="input-group-btn">
                                    <button id="submitButton" type="submit" class="btn btn-search"><i class="fa fa-search text-gray"></i></button>
                                </span>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-md-8 col-sm-8">
                                </div>
                                <div class="col-xs-12 col-md-4 col-sm-4">
                                    <ul class="icons">
                                        <li class="all active" title="Web Search" data-search-type="all">{{ trans('search.icons.all') }}</li>
                                        <li class="images" title="Image Search" data-search-type="images">{{ trans('search.icons.images') }}</li>
                                        <li class="books" title="Book Search" data-search-type="books">{{ trans('search.icons.books') }}</li>
                                        <li class="videos" title="Video Search" data-search-type="video">{{ trans('search.icons.videos') }}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-12 col-sm-12" style="padding-left: 0px;">
                                <div id="AdvencedOptions" class="panel-title AdvencedOptions">
                                    <img src="/images/tree_plus.gif" />
                                    <label><span> {{ trans('search.txt.advanced') }}</span></label>
                                </div>
                                <div id="danger" class="col-xs-12 col-md-8 col-sm-8">&nbsp;</div>
                                <!-- begin advenced options -->
                                <div id="DescriptionOptions" class="description" style="display:none">
                                    <div class="col-xs-12 col-sm-6 col-md-4 checkbox checkbox-primary">
                                        <input name="title" value="ti" checked="checked" type="checkbox" id="title">
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
                                        <label for="abstract">{{ trans('search.txt.abstract') }}</label>
                                    </div>
                                </div>
                                <!-- and advenced options -->
                            </div>
                            <input type="hidden" name="qdb" v-model="form.qdb">
                        </form>
                    </div>
                    <div class="col-md-1"></div>
                </div>
            </header>
        </section>
        <main id="content" class="content" role="main">
            <div class="content-results">
                <div class="row">
                    <!-- Starting filter -->
                    <div class="col-md-2">
                        <search-filter/>
                    </div>
                    <!-- Ending filter -->
                    <!-- Beginning content search -->
                    <div class="col-md-10">
                        <Paginate />
                    </div>
                    <!-- Ending content search -->
                </div>
            </div>
        </main>
    </div>
</template>

<script type="text/babel">
    import { Form } from '@/components/Form';
    import { mapActions, mapGetters } from 'vuex';
    import Lang from '@/mixins/lang';
    import Paginate from './Paginate.vue';

    export default {
        name: 'Simple',

        components: {
            Paginate
        },

        mixins: [Lang],

        data () {
            return {
                form: new Form(this.$route.query)
            }
        },

        head: {
            title: {
                inner: 'Simple Search'
            },
            meta: [
                // ...
            ]
        },

        computed: {
            ...mapGetters(['loading'])
        },

        mounted () {
            this.form.clear();
            this.form.get('/api/search/simple').then(({ data: { data } }) => {
                this.setResults(data.results);
                this.setFilters(data.filter);
            }).catch((error) => {
                console.log(error);
            })
        },

        methods: {
                ...mapActions(['setResults', 'setFilters'])
        }
    };
</script>
