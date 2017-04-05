// Polyfill fn.bind() for PhantomJS
/* eslint-disable no-extend-native */
Function.prototype.bind = require('function-bind');

// require all test files (files that ends with .spec.js)
const testsContext = require.context('./specs', true, /\.spec$/);
testsContext.keys().forEach(testsContext);

import Vue from 'vue';
import VueResource from 'vue-resource';
import VueResourceMock from './Mock';
import MockData from './Mock/mock';

Vue.use(VueResource);
Vue.use(VueResourceMock, MockData);
