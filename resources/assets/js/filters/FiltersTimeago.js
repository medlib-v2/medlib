import Vue from 'vue'
import Moment from 'moment'

Vue.filter('timeago', (value, input) => {
  let timeago = new Date(value)
  timeago = Moment(timeago).fromNow()
  return timeago
})
