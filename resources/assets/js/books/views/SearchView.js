import _ from 'lodash';
import Backbone from 'backbone';
import v from '../utils/variables';
import BookCollection from '../collections/BookCollection';
import BookModel from '../models/BookModel';
import allBooksView from './AllBooksView';
import myCollection from '../collections/BookLibrary';
import $ from 'jquery'

let Modernizr = window.Modernizr,
    bookTemplate = require('../templates/book.html'),
    welcomeTemplate = require('../templates/welcome.html'),
    apiTemplate = require('../templates/apimessage.html');

const SearchView = Backbone.View.extend({

    el: "#wrap-books",

    events: {
        "submit": "search",
        "keyup": "searchAutocomplete",
        "click #more-books": "moreBooks"
    },

    initialize: _.once(function() {
        /**
         * On first page load, load some topics
         * unless its a router
         */
        if (window.location.hash === '') {
            this.topics(v.TOPICS);
        }
    }),

    search(e) {
        let $value = $('#search_input').val();
        e.preventDefault();
        /**
         * Remove previous search results
         */
        $('#books').html('');
        /**
         * Do a search with the form input as the query
         */
        this.buildResults($value, index = '0', v.MAX_DEFAULT);
        /**
         * Reset any routes
         * @type {string}
         */
        window.location.hash = '';
    },

    browse(term, index, maxResults) {
        $('#books').html('');
        /**
         * Do a search with query passed in from a function
         */
        this.buildResults(term, index, maxResults);

        /**
         * Results appear at the top of the page
         */
        $("html, body").animate({ scrollTop: 0 }, "slow");
    },
    
    topics(terms) {
        let self = this,
            shuffle, index, maxResults;

        /**
         * Randomize topics
         * @type {Array}
         */
        shuffle = _.shuffle(terms);

        /**
         * load topics, requires an API query for each topic
         */
        _.each(shuffle, function(topic, count) {
            if (count <= 0) {
                self.buildResults('subject:' + topic, index = 0, maxResults = 3, topic);
            } else {
                return;
            }
        });
    },

    buildResults(term, index, maxResults, subject) {
        let aj,
            self = this,
            $books = $('#books'),
            url = 'https://www.googleapis.com/books/v1/volumes?',
            data = 'q=' + encodeURIComponent(term) + '&startIndex=' + index + '&maxResults=' + maxResults + '&key=' + v.API_KEY + '&projection=full&fields=totalItems,items(id,volumeInfo)',
            moreBtn = '<button data-index="' + index + '" data-term="' + term + '" data-maxresults="' + maxResults + '" class="btn btn-primary" href="#">&#43; Plus de livres</button>',
            dupBtn = moreBtn.length,
            books = new BookCollection();
        /**
         * Show loading indicator
         */
        $books.addClass('loading');

        books.fetch({
            url: url + data,
            success: function success(models, response) {
                let item = new allBooksView({ collection: models });
                item.render();

                /**
                 * If a topic and collection isn't empty,
                 * prepend with the topic title and append a 'more' link
                 */
                if (subject && models.length > 0) {
                    item.topic(subject, maxResults);
                }

                /**
                 * If the index is greater then 0 and this isn't topics,
                 * replace new books with old books. Otherwise APPEND to old books.
                 */
                if (index > 0 || subject) {
                    $books.append(item.el);
                } else {
                    $books.html(item.el);
                }

                $books.removeClass('loading');
            },
            error: function error(collection, response, xhr) {
                if (response.message === 'Daily Limit Exceeded') {
                    _.once(self.deadApi(response.message));
                }
            }
        });

        /**
         * Append a 'more' button, except if its topics or 'mybooks'
         */
        if (!subject || !dupBtn) {
            $('#more-books').empty().append(moreBtn);
        }
    },

    deadApi(message) {
        let apiMsg = _.template(apiTemplate);
        $('#books').empty().append(apiMsg);
    },

    /**
     * 'morebooks' event handler gets the query parameters
     * from data attributes stored in the 'more books' button
     * @param e
     */
    moreBooks(e) {
        let $btn = $('#more-books .more-button'),
            index = $btn.data("index"),
            term = $btn.data("term"),
            maxresults = $btn.data("maxresults"),
            newindex = index + maxresults;

        this.buildResults(term, newindex, maxresults);
        this.undelegate();
    },

    queryLocalStorage() {
        let myBooks = new myCollection(),
            self = this;

        myBooks.fetch({
            success() {
                /**
                 * If there are books in the localStorage collection
                 * then load and render them
                 */
                if (myBooks.length > 0) {
                    $("#more-books").empty();
                    let item = new allBooksView({ collection: myBooks }),
                        title = '<h1>My Books</h1>';
                    item.render();
                    $("#books").html(item.el).prepend(title);
                    /**
                     * Otherwise, load some topics with a message
                     */
                } else {
                    /**
                     * Remove previous results, since this is ajax
                     */
                    $("#books").empty();

                     let welcomeMsg = _.template(welcomeTemplate);
                     if (Modernizr.localstorage) {
                         $('#books').prepend(welcomeMsg);
                         self.topics(v.TOPICS);
                     }
                }
            }
        });

        /**
         * Results appear at the top of the page
         */
        $("html, body").animate({ scrollTop: 0 }, "slow");
    },

    searchAutocomplete(e) {
        let $searchForm = $('#search_input'),
            term = $searchForm.val(),
            self = this,
            url = 'https://www.googleapis.com/books/v1/volumes?q=' + encodeURIComponent(term) + '&maxResults=8&key=' + v.API_KEY + '&fields=totalItems,items(accessInfo,volumeInfo)';

        /**
         * Autcomplete function from jQuery UI (http://jqueryui.com/autocomplete/)
         */
        $searchForm.autocomplete({
            source(request, response) {
                $.getJSON(url + '&callback=?', function(data) {
                    let dropdown = [];
                    _.each(data.items, function(item) {
                        let ele = {},
                            /**
                             * Use the titles and subtitles for the autocomplete, if they exist
                             * @type {string}
                             */
                            subtitle = typeof item.volumeInfo.subtitle !== "undefined" ? ': ' + item.volumeInfo.subtitle : '';
                        /**
                         * Create an array of object attributes autocomplete can parse
                         * @type {*}
                         */
                        ele = item.volumeInfo.title.concat(subtitle);
                        dropdown.push(ele);
                    });
                    /**
                     * Remove duplicates
                     * @type {Array}
                     */
                    dropdown = _.uniq(dropdown);
                    response(dropdown);
                });
            },
            select(event, ui) {
                /**
                 * populate the autocomplete with an API query
                 */
                self.buildResults(ui.item.value, index = '0', v.MAX_DEFAULT);
            },
            /**
             * Trigger when the menu is hidden, remove search term
             * @param event
             * @param ui
             */
            close(event, ui) {
                $searchForm.val('');
                /**
                 * Reset any routes
                 * @type {string}
                 */
                window.location.hash = '';
            }
        });
    }
});

export default SearchView;