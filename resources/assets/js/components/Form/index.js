import Form from './Form'
import HasError from './components/HasError.vue'
import AlertError from './components/Error.vue'
import AlertErrors from './components/Errors.vue'
import AlertSuccess from './components/Success.vue'

/* istanbul ignore next */
HasError.install = (Vue) => {
    Vue.component(HasError.name, HasError);
};

/* istanbul ignore next */
AlertError.install = (Vue) => {
    Vue.component(AlertError.name, AlertError);
};

/* istanbul ignore next */
AlertErrors.install = (Vue) => {
    Vue.component(AlertErrors.name, AlertErrors);
};

/* istanbul ignore next */
AlertSuccess.install = (Vue) => {
    Vue.component(AlertSuccess.name, AlertSuccess);
};

export {
    Form,
    HasError,
    AlertError,
    AlertErrors,
    AlertSuccess,
    Form as default
}