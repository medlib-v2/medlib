import Vue from 'vue'

Vue.directive('select2', {
    bind (el, binding, vnode) {
        //let s = $(el.select);

        //s.select2({
        //    width: '100%'
        //});

        //console.log(s, 'DirectiveSelect2')
        /**
        $('select2').select2({
            width: '100%'
        })
        **/
    },
    update (nv, ov) {
        //let s = $(this);
        //$(s).trigger("change");
    }
})
