/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */
window.$ = require('jquery')
window.jQuery = window.$
global.jQuery = window.$
require('bootstrap-sass')
require('select2')
require('perfect-scrollbar/jquery')(window.$)