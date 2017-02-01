import _ from 'lodash';
import Backbone from 'backbone';
import DetailView from './DetailView';

let $ = window.jQuery,
    bookTemplate = require('../templates/book.html');

const BookView = Backbone.View.extend({
    /**
     * each book is created inside an html list tag
     */
    tagName: "li",

    /**
     * cache the template function for a single item
     */
    template: _.template(bookTemplate),

    /**
     * the DOM events specific to this view
     */
    events: {
        "click": "clicked"
    },

    initialize() {
        /**
         * bind 'this' object to render method
         */
        _.bindAll(this, "render");
    },

    /**
     * when a book is clicked,
     * call the detail method and pass in its model
     * @param e
     */
    clicked(e) {
        e.preventDefault();
        this.detail(this.model);
    },

    /**
     * populate the cached template and append to 'this' objects html
     */
    render() {
        let book = _.template(this.template(this.model.toJSON()));
        this.$el.append(book);
    },

    detail(model) {
        /**
         * Instantiate the book details view with the book model that was clicked on
         */
        let bookDetail = new DetailView({ el: $("#book-details"), model: model });
        bookDetail.render();
        bookDetail.undelegate('.close detail', 'click'); //todo: better garbage collection
    }
});

export default BookView;