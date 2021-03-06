define(function(require) {
    'use strict';
    var _ = require('lodash'),
        $ = require('jquery'),
        Backbone = require('backbone'),
        v = require('app/utils/variables'),
        BookCollection = require('app/collections/BookCollection'),
        BookModel = require('app/models/BookModel'),
        allBooksView = require('app/views/AllBooksView'),
        myCollection = require('app/collections/myLibrary'),
        bookTemplate = require('text!app/templates/book.html'),
        //welcomeTemplate = require('text!app/templates/welcome.html'),
        apiTemplate = require('text!app/templates/apimessage.html'),
        SearchView;

    require('browser');
    require('modernizr');

    SearchView = Backbone.View.extend({

        el: "#wrap-books",

        events: {
            "submit": "search",
            "keyup": "searchAutocomplete",
            "click #more-books": "moreBooks"
        },

        initialize: _.once(function() {
            //On first page load, load some topics
            //unless its a router
            if (window.location.hash === '') {
                this.topics(v.TOPICS);
            }
        }),

        search: function(e) {
            var $value = $('#search_input').val();
            e.preventDefault();
            console.log('search: %o', e);
            //Remove previous search results
            $('#books').html('');
            //Do a search with the form input as the query
            this.buildResults($value, index = '0', v.MAX_DEFAULT);
            //Reset any routes
            window.location.hash = '';
        },

        browse: function(term, index, maxResults) {
            $('#books').html('');
            //Do a search with query passed in from a function
            this.buildResults(term, index, maxResults);

            //Results appear at the top of the page
            $("html, body").animate({ scrollTop: 0 }, "slow");
        },

        topics: function(terms) {
            var self = this,
                shuffle, index, maxResults;

            //Randomize topics
            shuffle = _.shuffle(terms);

            //load topics, requires an API query for each topic
            _.each(shuffle, function(topic, count) {
                if (count <= 0) {
                    self.buildResults('subject:' + topic, index = 0, maxResults = 3, topic);
                } else {
                    return;
                }
            });
        },

        buildResults: function(term, index, maxResults, subject) {
            var aj,
                self = this,
                $books = $('#books'),
                url = 'https://www.googleapis.com/books/v1/volumes?',
                data = 'q=' + encodeURIComponent(term) + '&startIndex=' + index + '&maxResults=' + maxResults + '&key=' + v.API_KEY + '&projection=full&fields=totalItems,items(id,volumeInfo)',
                moreBtn = '<button data-index="' + index + '" data-term="' + term + '" data-maxresults="' + maxResults + '" class="btn more-button" href="#">&#43; Plus de livres</button>',
                dupBtn = moreBtn.length,
                books = new BookCollection();

            //Show loading indicator
            $books.addClass('loading');

            books.fetch({
                url: url + data,
                'success': function success(models, response) {
                    var item = new allBooksView({ collection: models });
                    item.render();

                    //If a topic and collection isn't empty, 
                    //prepend with the topic title and append a 'more' link
                    if (subject && models.length > 0) {
                        item.topic(subject, maxResults);
                    }

                    //If the index is greater then 0 and this isn't topics, 
                    //replace new books with old books. Otherwise APPEND to old books.
                    if (index > 0 || subject) {
                        $books.append(item.el);
                    } else {
                        $books.html(item.el);
                    }

                    $books.removeClass('loading');
                },
                'error': function error(collection, response, xhr) {
                    if (response.message === 'Daily Limit Exceeded') {
                        _.once(self.deadApi(response.message));
                    }
                }
            });

            //Append a 'more' button, except if its topics or 'mybooks'
            if (!subject || !dupBtn) {
                $('#more-books').empty().append(moreBtn);
            }
        },

        deadApi: function(message) {
            var apiMsg = _.template(apiTemplate);
            $('#books').empty().append(apiMsg);
        },

        //'morebooks' event handler gets the query parameters
        //from data attributes stored in the 'more books' button
        moreBooks: function(e) {
            var $btn = $('#more-books .more-button'),
                index = $btn.data("index"),
                term = $btn.data("term"),
                maxresults = $btn.data("maxresults"),
                newindex = index + maxresults;

            this.buildResults(term, newindex, maxresults);
            this.undelegate();
        },

        queryLocalStorage: function() {
            var myBooks = new myCollection(),
                self = this;

            myBooks.fetch({
                success: function() {
                    //If there are books in the localStorage collection
                    //then load and render them
                    if (myBooks.length > 0) {
                        $("#more-books").empty();
                        var item = new allBooksView({ collection: myBooks }),
                            title = '<h1>My Books</h1>';
                        item.render();
                        $("#books").html(item.el).prepend(title);
                        //Otherwise, load some topics with a message
                    } else {
                        $("#books").empty(); //Remove previous results, since this is ajax
                        /**
                        var welcomeMsg = _.template(welcomeTemplate);
                        if (Modernizr.localstorage) {
                            $('#books').prepend(welcomeMsg);
                            self.topics(v.TOPICS);
                        }
                        **/
                    }
                }
            });

            //Results appear at the top of the page
            $("html, body").animate({ scrollTop: 0 }, "slow");
        },

        searchAutocomplete: function(e) {
            var $searchForm = $('#search_input'),
                term = $searchForm.val(),
                self = this,
                url = 'https://www.googleapis.com/books/v1/volumes?q=' + encodeURIComponent(term) + '&maxResults=8&key=' + v.API_KEY + '&fields=totalItems,items(accessInfo,volumeInfo)';

            //Autcomplete function from jQuery UI (http://jqueryui.com/autocomplete/)
            $searchForm.autocomplete({
                source: function(request, response) {
                    $.getJSON(url + '&callback=?', function(data) {
                        var dropdown = [];
                        _.each(data.items, function(item) {
                            var ele = {},
                                //Use the titles and subtitles for the autocomplete, if they exist
                                subtitle = typeof item.volumeInfo.subtitle !== "undefined" ? ': ' + item.volumeInfo.subtitle : '';
                            //Create an array of object attributes autocomplete can parse
                            ele = item.volumeInfo.title.concat(subtitle);
                            dropdown.push(ele);
                        });
                        //Remove duplicates
                        dropdown = _.uniq(dropdown);
                        response(dropdown);
                    });
                },
                select: function(event, ui) {
                    //populate the autocomplete with an API query
                    self.buildResults(ui.item.value, index = '0', v.MAX_DEFAULT);
                },
                //Trigger when the menu is hidden, remove search term
                close: function(event, ui) {
                    $searchForm.val('');
                    //Reset any routes
                    window.location.hash = '';
                }
            });
        }
    });

    return SearchView;
});