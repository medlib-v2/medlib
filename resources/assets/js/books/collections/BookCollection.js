import Backbone from 'backbone';
import BookModel from '../models/BookModel';

const BookCollection = Backbone.Collection.extend({
    model: BookModel,
    parse(response) {
        return response.items;
    }
});

export default BookCollection;