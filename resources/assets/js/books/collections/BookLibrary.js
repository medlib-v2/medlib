import Backbone from 'backbone';
import BookModel from '../models/BookModel';
import ls from 'backbone.localstorage';

const BookLibrary = Backbone.Collection.extend({
    model: BookModel,
    localStorage: new Backbone.LocalStorage("myBooks")
});

export default BookLibrary