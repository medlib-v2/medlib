<template lang="html">
    <div id="auteur-refinement">
        <div class="head"><strong>Auteur</strong></div>
        <ul class="refinement">
            <li v-for="(value, item, index) in creators">
                <span  v-if="index < 8"><router-link rel="nofollow" :title="item.replace(/\[|\]|,/gi, '') | highlight" :to="{ path: '/search/simple', query: query(item)}">{{ item.replace(/\[|\]|,/gi, '') | highlight }}</router-link> ({{ value }})</span>
                <span v-else style="display: none"><router-link rel="nofollow" :title="item.replace(/\[|\]|,/gi, '') | highlight" :to="{ path: '/search/simple', query: query(item)}">{{ item.replace(/\[|\]|,/gi, '') | highlight }}</router-link> ({{ value }})</span>
            </li>
            <li><a rel="nofollow" href="#"><strong>Plus ...</strong></a></li>
        </ul>
    </div>
</template>
<script type="text/babel">
    export default{
        name: 'creators-filter',
        data() {
            return {
                //
            }
        },
        props:{
            creators: {
                type: Object,
                required: true
            }
        },
        methods: {
            query (item) {
                return function () {
                    let query = {
                        query: item,
                        title: 'au'
                    };
                    return Object.assign(this.$route.query, query);
                }.call(this);
            }
        }
    }
</script>
