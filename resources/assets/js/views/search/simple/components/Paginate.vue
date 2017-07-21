<template lang="html">
    <div class="content">
        <div id="pagination" class="be-list">
            <div class="be-list-panel panel-top">
                <Pagination />

                <br>
                <Pagination />
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import Pagination from './Pagination.vue';

    export default {
        name: 'Paginate',
        data () {
            return {
                msg:'hello vue'
            }
        },
        components: {
            Pagination
        }
    }
</script>
