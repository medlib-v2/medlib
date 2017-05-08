import Vue from 'vue'

let parser = new DOMParser;

Vue.filter('highlight', (value) => {
    let dom = parser.parseFromString(value, 'text/html');
    let sting = dom.body.textContent;
    delete dom.body.textContent;
    return sting;
})