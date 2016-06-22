(function ($, undefined) {
    /** Global veriables **/
    var defaultOptions, API_BASE_URL, sum = 0, weight = 10, check;
    var regex = /^(?:ISBN(?:-1[03])?:? )?(?=[0-9X]{10}$|(?=(?:[0-9]+[- ]){3})[- 0-9X]{13}$|97[89][0-9]{10}$|(?=(?:[0-9]+[- ]){4})[- 0-9]{17}$)(?:97[89][- ]?)?[0-9]{1,5}[- ]?[0-9]+[- ]?[0-9]+[- ]?[0-9X]$/;

    /**
     * Default Options
     * @type {{key: null, query: null, offset: number, limit: number, type: string, order: string, lang: string, rootUrl: string, apiName: string, apiVersion: string, resourcePath: string}}
     */
    defaultOptions = {
        /**
         * Search in a specified field (title, author, publisher, subject or isbn) (Optional)
         */
        key : null,
        query: null,
        /**
         * Search in a specified field (title, author, publisher, subject or isbn) (Optional)
         */
        field: null,
        /**
         * The position in the collection at which to start the list of results (Default: 0)
         */
        offset: 0,
        /**
         * The maximum number of results to return (Max 1) (Defult: 1)
         */
        limit: 1,
        /**
         * Restrict results to books or magazines (Default: all)
         */
        type: 'all',
        /**
         * Order results by relevance or newest (Default: relevance)
         */
        order: 'relevance',
        /**
         * Restrict results to a specified language (two-letter ISO-639-1 code) (Default: en)
         */
        lang: 'fr',
        rootUrl:'https://www.googleapis.com',
        apiName: 'books',
        apiVersion : 'v1',
        resourcePath: 'volumes'
    };

    /**
     * Special Keywords
     * @type {{title: string, author: string, publisher: string, subject: string, isbn: string}}
     */
    var fields = {
        title: 'intitle:',
        author: 'inauthor:',
        publisher: 'inpublisher:',
        subject: 'subject:',
        isbn: 'isbn:'
    };

    $.books = $.fn.books = function(options){
        var elements = $(this), element, isbns, isbn;
        if(elements.length !== undefined)  {

            if (elements.length == 1) {
                element = elements;
                isbns = $(element).find('span');
                isbns.each(function (index, span) {
                    if (!$(span).hasClass('item-summary')) {
                        isbn = $(span).attr('data-isbn');
                        if(isISBN10(isbn)) {
                            (function (isbn) {
                                searchByISBN(isbn, options, function (data, status) {
                                    console.log('isISBN10', data, status);
                                });
                            })(isbn);
                        }
                        else if(isISBN13(isbns)) {
                            (function (isbn) {
                                searchByISBN(isbn, options, function (data, status) {
                                    console.log('isISBN13', data, status);
                                });
                            })(isbn);
                        }
                    }
                });

            }
            else {

                for (var i = 0; i < elements.length; i++) {
                    element = elements[i];
                    isbns = $(element).find('span');

                    isbns.each(function (index, span) {

                        if (!$(span).hasClass('item-summary')) {
                            /**
                             * Get the isbn number by data-isbn attribute
                             * @type number isbn
                             */
                            isbn = $(span).attr('data-isbn');
                            /**
                            searchByISBN(isbn, options, function (data, status) {
                                //console.log('isISBN', data, status);
                            });
                            */

                            /**
                            if (isISBN10(isbn) || isISBN13(isbn)) {

                                searchByISBN(isbn, options, function (data, status) {
                                    console.log('isISBN', data, status);
                                });
                            }
                            */
                            if (isbn == "") {

                            }
                            console.log("number : %O, isbn10 : %O, isbn13 : %O", isbn, isISBN10(isbn), isISBN13(isbn));
                            /**
                            if(isISBN10(isbn)) {

                                (function (isbn) {
                                    console.log(isbn);
                                    searchByISBN(isbn, options, function (data, status) {
                                        console.log('isISBN10', data, status);
                                    });
                                })(isbn);

                            }
                            else {

                                if(isISBN13(isbns)) {
                                    console.log("Isbn13 : ", isbn);
                                    (function (isbn) {
                                        searchByISBN(isbn, options, function (data, status) {
                                            console.log('isISBN13', data, status);
                                        });
                                    })(isbn);
                                }
                            }
                            */

                        }
                    });
                }
            }
        }
    };

    /**
     * Search Google Books
     *
     * @param {String} queryISBN
     * @param {object}  options
     * @param {Function} callback
     */
    function searchByISBN(queryISBN, options, callback) {

        if(!$.isFunction(callback)) {
            callback = options;
            options = {};
        }

         options = $.extend({}, defaultOptions, options);

        /**
         * Google Base url
         * @type {string}
         */
        API_BASE_URL = options.rootUrl + '/' + options.apiName + '/' + options.apiVersion + '/' + options.resourcePath;

        /** Validate options **/
        if(!queryISBN) { return callback(new Error('Query is required')); }

        if(options.offset < 0) { return callback(new Error('Offset cannot be below 0')); }

        if (options.limit < 1 || options.limit > 1) { return callback(new Error('Limit must be 1')); }

        if(options.fields) { queryISBN = fields[options.field] + queryISBN; }
        else { queryISBN = fields.isbn + queryISBN }

        var query = {
            q: queryISBN,
            startIndex: options.offset,
            maxResults: options.limit,
            printType: options.type,
            orderBy: options.order,
            jscmd: 'viewapi'
        };

        $.getJSON(API_BASE_URL, query, function (json, status) {
            var results;
            if (status === 'success' && json.totalItems !== 0) { results = parseBook(json); }
            else {
                results = { error : new Error('No Books found with isbn : ' + queryISBN) };
            }
            return callback(results, status);
        });
    }

    /**
     * Check if is valid isbn 10
     * @param isbn
     * @returns {boolean}
     */
    function isISBN10(isbn) {

        if(typeof isbn == 'string' || typeof isbn == 'number' ) {

            if(!regex.test(isbn)) { return false; }

            isbn = isbn.toString().replace(/[- ]|^ISBN(?:-1[03])?:?/g, "").split("");
            var last = isbn.pop();

            /** Compute the ISBN-10 check digit **/
            if(isbn.length < 9 || isbn.length > 10) { return false; }

            isbn.reverse();

            for (var i = 0; i < isbn.length; i++) {

                /**
                 * digit = parseInt(isbn[i], 10);
                 * sum += weight * digit;
                 * weight--;
                 */
                sum += (i + 2) * parseInt(isbn[i], weight);
            }

            check = 11 - (sum % 11);
            if (check == 10) { check = "X"; }
            else if (check == 11) { check = "0"; }

            return (check == last);
            /** return (check == isbn[isbn.length - 1].toUpperCase()); **/

        }

        else { return false; }
    }

    /**
     * Check if is valid isbn 13
     * @param isbn
     * @returns {boolean}
     */
    function isISBN13(isbn) {

        if(typeof isbn == 'string' || typeof isbn == 'number' ) {

            if(!regex.test(isbn)) { return false; }

            isbn = isbn.toString().replace(/[- ]|^ISBN(?:-1[03])?:?/g, "").split("");

            var last = isbn.pop();

            if(isbn.length < 12 || isbn.length > 13) { return false; }

            for (var i = 0; i < isbn.length; i++) {

                sum += (i % 2 * 2 + 1) * parseInt(isbn[i], weight);

                /**
                 * digit = parseInt(isbn[i]);
                 * if (i % 2 == 1) { sum += 3 * digit; }
                 * else { sum += digit; }
                 **/
            }

            /**
             * check = 10 - (sum % 10);
             * if (check == 10) {
             *  check = "0";
             * }
             */

            check = (10 - (sum % 10)) % 10;

            return (check == last);

        }
        else { return false; }
    }

    /**
     * Convert Isbn 13  to 10
     * @param isbn
     * @returns {*}
     */
    function toISBN10(isbn) {

        if(typeof isbn == 'string' || typeof isbn == 'number' ) {

            isbn = isbn.toString().replace(/[- ]|^ISBN(?:-1[03])?:?/g, "").split("");

            if (isbn.length > 13) { isbn = isbn.toString().substring(4, -1); }
            else { isbn = isbn.toString().substring(3, -1); }

            return isbn;
        }
        else { return isbn; }
    }

    /**
     * Convert Isbn 10 to 13
     *
     * @param isbn
     * @returns {*}
     */
    function toISBN13(isbn) {
        if(typeof isbn !== 'string' || typeof isbn !== 'number' ) {

            isbn = isbn.toString().replace(/[- ]|^ISBN(?:-1[03])?:?/g, "").split("");
        } else { return isbn; }
    }

    /**
     * Parse a single book result
     *
     * @param {Object} json
     * @param {Object} status
     * @return {Object}
     */
    function parseBook(json) {

        var book = json.items.map(function (data) {

            var item = _.pick(data.volumeInfo, [
                'title', 'subtitle', 'authors', 'publisher', 'publishedDate', 'description',
                'industryIdentifiers', 'pageCount', 'printType', 'categories', 'averageRating',
                'ratingsCount', 'maturityRating', 'language'
            ]);

            _.extend(item, {
                id: data.id,
                link: data.volumeInfo.canonicalVolumeLink,
                thumbnail: _.get(data, 'volumeInfo.imageLinks.thumbnail'),
                images: _.pick(data.volumeInfo.imageLinks, ['small', 'medium', 'large', 'extraLarge']),
                accessInfo : _.pick(data.accessInfo, ['epub', 'pdf', 'country', 'viewability', 'embeddable', 'publicDomain']),
                saleInfo: _.pick(data.saleInfo, ['country','saleability', 'isEbook', 'buyLink'])
            });

            return item;
        });

        return book;
    }
})(jQuery, undefined);