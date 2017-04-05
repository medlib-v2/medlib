import _ from 'lodash';
import Backbone from 'backbone';
import BookModel from '../models/BookModel';
import v from '../utils/variables';
import myCollection from '../collections/BookLibrary';
import helpers from '../utils/helpers';
import $ from 'jquery'

let detailsTemplate = require('../templates/details.html'),
    Modernizr = window.Modernizr;

const DetailView = Backbone.View.extend({

    /**
     * attach this view to the following html id
     */
    el: $("#book-details"),

    /**
     * DOM events for this view
     */
    events: {
        "click .close-detail": "hide",
        "click #overlay": "hide",
        "click .save-book": "saveBook",
        "click .remove-book": "removeBook"
    },

    initialize() {
        /** Add a faded overlay **/
        let overlay = '<div id="overlay" style="display: none;"></div>';
        this.$el.find('#overlay').remove(); //Remove previous overlay
        this.$el.append(overlay).find('#overlay').fadeIn('slow');

        /** css3 transforms are buggy with z-index, need to remove them under the overlay **/
        this.$el.next().find('li').find('.book').addClass('removeTransform');

        /** Define JSON objects, this prevents ajax errors **/
        this.model.attributes.description = this.model.attributes.description || {};
        this.model.attributes.volumeInfo = this.model.attributes.volumeInfo || {};
        this.model.attributes.volumeInfo.imageLinks = this.model.attributes.volumeInfo.imageLinks || {};
    },

    render() {
        let localExists = this.localBook(),
            self = this,
            $details = $("#book-details");

        /**
         * Remove previous instances of this template
         */
        $details.find('#detail-view-template').remove();

        /**
         * If book is in localStorage, get it there
         */
        if (localExists) {
            let localBook = new myCollection();

            localBook.fetch({
                success: function() {
                    let data = localBook.get(self.model.id),
                        book = data.toJSON();

                    /**
                     * localStorage booleans let details template know
                     * which button to show
                     * @type {boolean}
                     */
                    book.localstorage = true;
                    book.localbook = true;

                    let view = _.template(detailsTemplate, book);
                    $details.append(view).find('#detail-view-template').show().addClass('down');

                    helpers.shortSynopsis();
                }
            });
            /**
             * Otherwise, do an API query
             */
        } else {
            let data = this.queryApi(this.model);
            data.done(function() {
                let book = data.responseJSON;

                book.localstorage = Modernizr.localstorage;
                book.localbook = localExists;

                let detail = new BookModel(book);
                /**
                 * Load the books model into the details template
                 * @type {Function}
                 */
                let view = _.template(detailsTemplate, detail.toJSON());

                $details.append(view).find('#detail-view-template').show().addClass('down');

                helpers.shortSynopsis();
            });
        }
    },

    /**
     * Request Ajax
     * @param url
     * @param data
     * @returns {*}
     */
    doAjax(url, data) {
        return $.ajax({
            dataType: 'jsonp',
            data: data,
            url: url
        });
    },
    /**
     * Request Books Google
     * @param model
     * @returns {*}
     */
    queryApi(model) {
        let aj,
            url = 'https://www.googleapis.com/books/v1/volumes/' + model.id,
            data = 'fields=accessInfo,volumeInfo&key=' + v.API_KEY;

        aj = this.doAjax(url, data);
        return aj;
    },

    /**
     * Checks the localstorage keys to see if the book is there,
     * returns boolean
     * @returns {boolean}
     */
    localBook() {
        let self = this,
            exists;

        _.each(Object.keys(localStorage), function(key, value) {
            if (key === 'myBooks-' + self.model.id) {
                exists = true;
            }
        });

        if (exists) {
            return true;
        }

        return false;
    },

    removeBook(e) {
        e.preventDefault();

        /**
         * Remove the book from localStorage
         */
        localStorage.removeItem('myBooks-' + this.model.id);

        /**
         * Make it a 'save' button instead
         * @type {string}
         */
        e.currentTarget.className = 'btn save-book';
        e.currentTarget.textContent = '+ Save book to my library';
    },

    saveBook(e) {
        let self = this,
            welcomeMsg = $('.welcome').length;

        e.preventDefault();

        let data = this.queryApi(this.model);

        data.done(function() {
            let book = data.responseJSON;

            /**
             * Sets boolean values so template knows which button to show
             * @type {*}
             */
            book.localstorage = Modernizr.localstorage;
            book.localbook = true;

            let newBook = new BookModel(book);

            /**
             * Unique model ID's are required for localStorage to work properly
             */
            newBook.set({ id: self.model.id });

            let addBook = new myCollection();

            addBook.fetch({
                success() {
                    addBook.create(newBook);
                    newBook.save();
                }
            });

            /**
             * Refresh local books if were in the 'mybooks' page
             * with welcome message present
             */
            if (window.location.hash === '#mybooks' && welcomeMsg) {
                location.reload();
            }
        });

        /**
         * Now make it a 'remove' button instead
         * @type {string}
         */
        e.currentTarget.className = 'btn remove-book';
        e.currentTarget.textContent = '- Remove book from my library';
    },

    hide(e) {
        let localExists = this.localBook();
        e.preventDefault();

        this.$el.find('#detail-view-template').removeClass('down').addClass('up');
        this.$el.find('#overlay').fadeOut('slow');
        this.$el.next().find('li').find('.book').removeClass('removeTransform');
        this.$el.undelegate(); // Todo: do better garbarge collection
        /**
         * Refresh local books if they've removed one
         */
        if (window.location.hash === '#mybooks' && !localExists) {
            location.reload();
        }
    }
});

export default DetailView;