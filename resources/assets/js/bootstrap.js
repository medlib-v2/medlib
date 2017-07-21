//window.GOOGLE_AUTOCOMPLETE_KEY = 'AIzaSyASWIWXTQSF8spzI3X3Esk4pnoq-gPoLHQ'
/**
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
**/

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */
import 'jquery';
import 'bootstrap-sass';
import 'select2';

/**
 *
 */
import './plugins/modernizr';
import './utils/Rem'
/**
 * import dotenv from 'dotenv';
 * dotenv.load();
 **/