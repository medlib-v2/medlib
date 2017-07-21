<template lang="html">
    <select class="select2">
        <slot></slot>
    </select>
</template>

<script type="text/babel">
    import $ from 'jquery';

    export default {
        name: 'select2',
        props: {
            options: {
                type: Object,
                required: true
            },
            value: {
                type: String,
                required: true
            }
        },
        mounted() {
            let vm = this;

            $(this.$el)
                    .select2({ data: this.options })
                    .val(this.value)
                    .trigger('change')
                    .on('change', function () {
                        vm.$emit('input', this.value)
                    })
        },
        watch: {
            value(value) {
                $(this.$el).val(value).trigger('change');
            },
            options (options) {
                $(this.$el).select2({ data: options });
            }
        },
        destroyed () {
            $(this.$el).off().select2('destroy')
        }
    }
</script>
