import BasicSelect from './BasicSelect.vue'
import ListSelect from './ListSelect.vue'
import MultiListSelect from './MultiListSelect.vue'
import MultiSelect from './MultiSelect.vue'

/* istanbul ignore next */
BasicSelect.install = (Vue) => {
    Vue.component(BasicSelect.name, BasicSelect);
};

/* istanbul ignore next */
ListSelect.install = (Vue) => {
    Vue.component(ListSelect.name, ListSelect);
};

/* istanbul ignore next */
MultiListSelect.install = (Vue) => {
    Vue.component(MultiListSelect.name, MultiListSelect);
};

/* istanbul ignore next */
MultiSelect.install = (Vue) => {
    Vue.component(MultiSelect.name, MultiSelect);
};

export {
    BasicSelect,
    MultiSelect,
    ListSelect,
    MultiListSelect
};
