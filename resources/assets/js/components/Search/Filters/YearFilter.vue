<template lang="html">
    <div id="year-refinement">
        <div class="head"><strong>Année</strong></div>
        <ul class="refinement">
            <li v-for="(value, item, index) in years">
                <a v-if="index < 8" rel="nofollow" :title="item" href="#">{{ item }}</a>
                <a v-else rel="nofollow" :title="item" href="#" style="display: none">{{ item }}</a>
                ({{ value }})
            </li>
            <li><a rel="nofollow" href="#"><strong>Plus ...</strong></a></li>
        </ul>
    </div>
</template>

<script type="text/babel">

    export default {
        name: 'year-filter',
        props:{
            years: {
                type: Object,
                required: true
            }
        }
    }
</script>
