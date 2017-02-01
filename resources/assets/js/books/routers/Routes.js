import Backbone from 'backbone';
import v from '../utils/variables';
import SearchView from '../views/SearchView';

export default Backbone.Router.extend({
    routes: {
        "": "index",
        "browse/:query": "browse", // #browse/php
        "browse/subject/:query/:index": "subject",
        "browse/publisher/:query/:index": "publisher",
        "browse/author/:query/:index": "author"
    },

    index() {
        let search = new SearchView();
    },
    browse(term) {
        let search = new SearchView();
        search.browse(term, index = '0', v.MAX_DEFAULT);
    },
    subject(term, index) {
        let search = new SearchView();
        search.browse('subject:' + term, index, v.MAX_DEFAULT);
    },
    publisher(term, index) {
        let search = new SearchView();
        search.browse('inpublisher:' + term, index, v.MAX_DEFAULT);
    },
    author(term, index) {
        let search = new SearchView();
        search.browse('inauthor:' + term, index, v.MAX_DEFAULT);
    }

});