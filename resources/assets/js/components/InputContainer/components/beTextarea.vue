<template lang="html">
  <textarea
          class="be-input"
          :value="value"
          :disabled="disabled"
          :required="required"
          :placeholder="placeholder"
          :maxlength="maxlength"
          @focus="onFocus"
          @blur="onBlur"
          @input="onInput"></textarea>
</template>

<script type="text/babel">
    //import autosize from 'autosize';
    import common from './common';
    import getClosestVueParent from '../../../utils/getClosestVueParent';

    export default {
        name: 'be-textarea',
        mixins: [common],
        watch: {
            value() {
                this.$nextTick(() => {
                    //autosize.update(this.$el);
                });
            }
        },
        mounted() {
            this.$nextTick(() => {
                this.parentContainer = getClosestVueParent(this.$parent, 'form-group');
                if (!this.parentContainer) {
                    this.$destroy();
                    throw new Error('You should wrap the be-textarea in a form-group');
                }
                this.setParentDisabled();
                this.setParentRequired();
                this.setParentPlaceholder();
                this.handleMaxLength();
                this.updateValues();
                if (!this.$el.getAttribute('rows')) {
                    this.$el.setAttribute('rows', '1');
                }
                //autosize(this.$el);
            });
        },
        beforeDestroy() {
            //autosize.destroy(this.$el);
        }
    };


</script>