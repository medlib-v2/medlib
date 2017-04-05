import Backbone from 'backbone';

const BookModel = Backbone.Model.extend({
    defaults: {
        volumeInfo: [{
            description: "",
            title: "",
            imageLinks: [{
                smallThumbnail: "https://placehold.it/128x195/ffffff/999999",
                thumbnail: "https://placehold.it/128x195/ffffff/999999"
            }]
        }]
    }
});

export default BookModel;