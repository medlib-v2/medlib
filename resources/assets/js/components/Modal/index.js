import Modal from './Modal.vue';

/* istanbul ignore next */
Modal.install = (Vue) => {
    Vue.component(Modal.name, Modal);
};

export default Modal;
