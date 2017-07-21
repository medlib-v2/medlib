<template lang="html">
    <input
            class="form-control"
            :type="type"
            :value="value"
            :disabled="disabled"
            :required="required"
            :placeholder="placeholder"
            :maxlength="maxlength"
            @focus="onFocus"
            @blur="onBlur"
            @input="onInput"
            @keydown.up="onInput"
            @keydown.down="onInput">
</template>

<script type="text/babel">
    import common from './common';
    import getClosestVueParent from '../../../utils/getClosestVueParent';

    export default {
        name: 'be-input',
        mixins: [common],
        props: {
            type: {
                type: String,
                default: 'text'
            }
        },
        mounted() {
            this.$nextTick(() => {
                this.parentContainer = getClosestVueParent(this.$parent, 'form-group');
                if (!this.parentContainer) {
                    this.$destroy();
                    throw new Error('You should wrap the be-input in a form-group');
                }
                this.setParentDisabled();
                this.setParentRequired();
                this.setParentPlaceholder();
                this.handleMaxLength();
                this.updateValues();
            });
        }
    };
</script>