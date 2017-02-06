import Vue from 'vue'


// eslint-disable-line no-new
window.app = new Vue({
    name: 'app',
    el: '#app',
    data(){
        return {
            console: console
        }
    },
    created(){
        this.console.log("created vm");
    }
});