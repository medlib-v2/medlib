import bButton from './Button.vue';

/* istanbul ignore next */
bButton.install = (Vue) => {
    Vue.component(bButton.name, bButton);
};

export default bButton;