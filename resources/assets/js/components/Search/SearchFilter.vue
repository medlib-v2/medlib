<template lang="html">
    <div class="panel panel-default panel-border-color panel-border-color-primary">
        <div class="panel-heading panel-heading-divider">
            <h3 class="panel-title">{{ trans('search.txt.refine') }}</h3>
        </div>
        <div class="panel-body">
            <div class="facet-panel">
                <td class="box">
                    <creators-filter v-if="filters.hasOwnProperty('creators')" :creators="filters.creators" />

                    <year-filter v-if="filters.hasOwnProperty('year')" :years="filters.year"/>

                    <language-filter v-if="filters.hasOwnProperty('language')" />

                    <div id="content-refinement">
                        <div class="head"><strong>Contenu</strong></div>
                        <ul class="refinement">
                            <li><a rel="nofollow" title="Biographie" href="#">Biographie</a> (8)</li>
                            <li><a rel="nofollow" title="Fiction" href="#">Fiction</a> (3)</li>
                            <li><a rel="nofollow" title="Documentaire" href="#">Documentaire</a> (2182)</li>
                        </ul>
                    </div>

                    <publication-filter v-if="filters.hasOwnProperty('placeOfPublication')" :places="filters.placeOfPublication" />

                    <subjects-filter v-if="filters.hasOwnProperty('subjects')" :subjects="filters.subjects" />
                </td>
            </div>
        </div>
    </div>
</template>
<script type="text/babel">
    import Lang from '@/mixins/lang'
    import CreatorsFilter from './Filters/CreatorsFilter.vue'
    import YearFilter from './Filters/YearFilter.vue'
    import LanguageFilter from './Filters/LanguageFilter.vue'
    import PublicationFilter from './Filters/PublicationFilter.vue'
    import SubjectsFilter from './Filters/SubjectsFilter.vue'
    import { mapGetters } from 'vuex'
    export default {
        name: 'search-filter',
        mixins: [Lang],
        components: {
            CreatorsFilter,
            YearFilter,
            LanguageFilter,
            PublicationFilter,
            SubjectsFilter
        },
        computed: {
            ...mapGetters({
                filters: 'getFilters'
            })
        },
    }
</script>
