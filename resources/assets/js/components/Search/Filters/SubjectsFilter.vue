<template lang="html">
    <div id="sujet-refinement">
        <div class="head"><strong>Sujet</strong></div>
        <ul class="refinement">
            <li v-for="(value, item, index) in subjects">
                <a v-if="index < 8" rel="nofollow" :title="item.replace(/--|./gi, ' ')" href="#">{{ item.replace(/--|./gi, ' ') }}</a>
                <a v-else rel="nofollow" :title="item.replace(/--|./gi, ' ')" href="#" style="display: none">{{ item.replace(/--|./gi, ' ') }}</a>
                ({{ value }})
            </li>
            <li><a rel="nofollow" href="#"><strong>Plus ...</strong></a></li>
        </ul>
    </div>
</template>

<script type="text/babel">

    export default{
        name: 'subjects-filter',
        props:{
            subjects: Object,
            required: true
        }
    }
</script>
