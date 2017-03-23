let utils = require('./utils');
let merge = require('webpack-merge');
let baseConfig = require('./base.conf');

module.exports = merge(baseConfig, {
    module: {
        rules: utils.styleLoaders()
    }
});