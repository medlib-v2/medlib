import Icon from './components/Icon.vue'
import './icons/index.js'

/* istanbul ignore next */
Icon.install = (Vue) => {
    Vue.component(Icon.name, Icon);
};

export default Icon;
