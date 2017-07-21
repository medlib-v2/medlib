import beInputContainer from './components/beInputContainer.vue';
import beInput from './components/beInput.vue';
import beTextarea from './components/beTextarea.vue';

/* istanbul ignore next */
beInputContainer.install = (Vue) => {
    Vue.component(beInputContainer.name, beInputContainer);
};

/* istanbul ignore next */
beInput.install = (Vue) => {
    Vue.component(beInput.name, beInput);
};

/* istanbul ignore next */
beTextarea.install = (Vue) => {
    Vue.component(beTextarea.name, beTextarea);
};

export {
    beInputContainer,
    beInput,
    beTextarea
};
