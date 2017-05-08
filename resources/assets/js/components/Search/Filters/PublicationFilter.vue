<template lang="html">
    <div id="public-refinement">
        <div class="head"><strong>Publication</strong></div>
        <ul class="refinement">
            <li v-for="(value, item, index) in places">
                <a v-if="index < 8" rel="nofollow" :title="item.replace(/\[|\]|,/gi, '')" href="#">{{ item.replace(/\[|\]|,/gi, '') }}</a>
                <a v-else rel="nofollow" :title="item.replace(/\[|\]|,/gi, '')" href="#" style="display: none">{{ item.replace(/\[|\]|,/gi, '') }}</a>
                ({{ value }})
            </li>
            <li><a rel="nofollow" href="#"><strong>Plus ...</strong></a></li>
        </ul>
    </div>
</template>

<script type="text/babel">
    import { Form } from '@/components/Form'
    export default {
        name: 'publication-filter',
        data() {
            return {
                from: new Form(Object.assign(this.$route.query, {publisher: 'pb'}))
            }
        },
        props:{
            places: {
                type: Object,
                required: true
            }
        }
    }
</script>
