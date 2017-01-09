let _ = require('lodash'),
    $ = window.jQuery,
    BookView = require('./BookView'),
    Backbone = require('backbone'),
    Modernizr = window.Modernizr;

const AllBooksView = Backbone.View.extend({

    /**
     * all books go inside an unordered list tag
     */
    tagName: "ul",

    /**
     *
     * bind 'this' object to book method
     */
    initialize: function() {
        _.bindAll(this, "book");
    },

    /**
     * Call the book method on each book in this collection
     */
    render: function() {
        this.collection.each(this.book);
    },

    /**
     * For frontpage topics, prepend a title and append a 'more' button
     * @param topic
     * @param maxResults
     */
    topic: function(topic, maxResults) {
        this.$el.prepend('<h1>' + topic + '</h1>').append('<a href="#browse/subject/' + topic + '/' + maxResults + '">Voir plus &raquo;</a>');
    },

    /**
     * Instantiate a book view and populate it with a model,
     * then render it and append it to this views html element
     *
     * @param model
     */
    book: function(model) {
        let bookItem = new BookView({ model: model });
        bookItem.render();
        this.$el.append(bookItem.el);
    }
});

module.exports = AllBooksView;