<template lang="html">
    <div class="offline-ui offline-ui-down offline-ui-waiting">
        <div class="offline-ui-content" data-retry-in-value="9" data-retry-in-unit="second"></div>
        <a href="#" class="offline-ui-retry"></a>
    </div>
</template>

<script type="text/babel">
export default {
    data(){
        return{
            msg:'hello vue'
        }
    },
    components: {}
}
</script>
