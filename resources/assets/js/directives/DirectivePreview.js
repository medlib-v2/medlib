import Vue from 'vue'
import { Google } from '../utils'
import store from '../stores/PreviewStore'

Vue.directive('preview', {
  bind (el, binding, vnode) {
    let index;
    let open;

    if (store.state.books === undefined && store.state.pageId === undefined) {
      Vue.set(store.state.books, []);
      Vue.set(store.state.pageId, []);
    }
    index = store.state.books.push(el.getAttribute('isbn'));
    store.state.pageId.push(el.getAttribute('page-id'));
    open = function (i) {
      return function (e) {
        e.preventDefault();
        store.state.index = i;
      }
    };

    Google.books.load({'language': 'fr'});
    Google.books.setOnLoadCallback(initialize);

    function initialize () {
      store.state.manger = Google.books;
    }
    el.addEventListener('click', open(index - 1));
  }
});
