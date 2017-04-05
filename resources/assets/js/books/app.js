import Backbone from 'backbone'
import Router from './routers/Routes'

/**
 * Instiantiate the router
 */
let router = new Router()

/**
 * Start Backbone history for bookmarkable URL's
 */
Backbone.history.start()