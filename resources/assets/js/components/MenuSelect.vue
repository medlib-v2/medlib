<template>
    <div class="menu-select">
        Page {{ pageId }}
    </div>
</template>

<script>
import store from '../stores/PreviewStore'

export default {
    name: 'menu-select',
    replace: true,
    data () {
        return {
            show: false,
            selected: false,
            state: store.state,
            message: 'Menu page ici'
        }
    },
    watch: {
        state: function (val, oldVal) {
            console.log('new: %s, old: %s', val, oldVal);
        }
    },
    computed: {
        pageId () {
            if (this.state.index !== false) {
                return this.state.pageId[this.state.index].match(/(\d+)/)[1];
            }
        }
    }
}
</script>