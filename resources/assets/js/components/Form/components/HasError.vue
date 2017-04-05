<template lang="html">
    <div class="help-block text-danger" v-if="form.errors.has(field)" v-html="form.errors.get(field)"></div>
</template>

<script type="text/babel">
    export default {
        name: 'has-error',
        props: {
            form: {
                type: Object,
                required: true
            },
            field: {
                type: String,
                required: true
            }
        }
    }
</script>