<template lang="html">
    <div class="alert alert-danger" v-if="form.errors.any()" role="alert">
        <button v-if="dismissible" type="button" class="close" aria-label="Close" @click="dismiss">
            <span aria-hidden="true">&times;</span>
        </button>
        <div v-if="form.errors.has('error')" v-html="form.errors.get('error')"></div>
        <div v-else v-html="message"></div>
    </div>
</template>

<script type="text/babel">
    import Alert from './Alert'
    import Lang from '../../../mixins/lang'

    export default {
        mixins: [Alert, Lang],
        name: 'alert-error',
        props: {
            message: {
                type: String,
                default: trans('messages.problems_with_input')
            }
        }
    }
</script>