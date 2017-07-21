import Vue from 'vue';

import bButton from './Button';
import { HasError, AlertError, AlertErrors, AlertSuccess } from './Form';
import Icon from './Icons';
import { beInputContainer, beInput, beTextarea } from './InputContainer';
import { BasicSelect, MultiSelect, ListSelect, MultiListSelect } from './InputSelect';
import Modal from './Modal';
import NavBar from './Navbar';
import SearchFilter from './Search';
import UploadImage from './UploadImage';
import Select2 from './Select2';
import TypeSearch from './TypeSearch'

const components = [
    bButton,
    HasError,
    AlertError,
    AlertErrors,
    AlertSuccess,
    Icon,
    beInputContainer,
    beInput,
    beTextarea,
    BasicSelect,
    MultiSelect,
    ListSelect,
    MultiListSelect,
    Modal,
    NavBar,
    SearchFilter,
    UploadImage,
    Select2,
    TypeSearch
];

const install = (Vue, opts = {}) => {
    /* istanbul ignore if */
    if (install.installed) return;
    /**
    locale.use(opts.locale);
    locale.i18n(opts.i18n);
    **/

    components.map(component => {
        Vue.component(component.name, component);
    });

    /**
    Vue.use(Loading.directive);

    Vue.prototype.$loading = Loading.service;
    Vue.prototype.$msgbox = MessageBox;
    Vue.prototype.$alert = MessageBox.alert;
    Vue.prototype.$confirm = MessageBox.confirm;
    Vue.prototype.$prompt = MessageBox.prompt;
    Vue.prototype.$notify = Notification;
    Vue.prototype.$message = Message;
    **/
};

install(Vue);