//window.GOOGLE_AUTOCOMPLETE_KEY = 'AIzaSyASWIWXTQSF8spzI3X3Esk4pnoq-gPoLHQ'

window.GOOGLE_AUTOCOMPLETE = {
    'domain': 'https://maps.googleapis.com/maps/api/js',
    'key': 'AIzaSyASWIWXTQSF8spzI3X3Esk4pnoq-gPoLHQ',
    'library' : 'places',

    // google inputs retrieved.
    'inputs': {
        administrative_area_level_1: 'long_name',
        street_number: 'short_name',
        postal_code: 'short_name',
        locality: 'long_name',
        country: 'long_name',
        route: 'long_name'
    }
}

/**
import SocketIO from './socket.io/SocketIO'
window.socket = new SocketIO(window.location.hostname + ':6001', { query: ''})
**/