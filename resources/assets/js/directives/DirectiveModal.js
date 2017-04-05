import Vue from 'vue'
import target from './_target';
const listen_types = {click: true};

Vue.directive('modal', {
    bind(el, binding) {
        target(el, binding, listen_types, ({targets, vm}) => {
            targets.forEach(target => {
                vm.$root.$emit('show::modal', target);
            });
        });
    }
});