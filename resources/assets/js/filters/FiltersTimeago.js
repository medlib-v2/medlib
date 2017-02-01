import Vue from 'vue';
import Moment from 'moment';

// vue filters
Vue.filter('timeago', function(value, input) {
    let timeago = new Date(value);
    timeago = Moment(timeago).fromNow();
    return timeago;
});