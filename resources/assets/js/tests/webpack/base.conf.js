let path = require('path');
let webpack = require('webpack');

/**
 *
 * @param dirname
 * @returns {*}
 */
function resolve (dirname) {
    return path.join(__dirname, '..', dirname)
}

module.exports = {
    output: {
        path: resolve('../../'),
        publicPath: '/',
        filename: '[name].js'
    },
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader',
                options: {
                    // vue-loader options go here
                }
            },
            {
                test: /\.js$/,
                loader: 'babel-loader',
                exclude: /node_modules/,
                options: {
                    presets: [
                        ["es2015", { "modules": false }],
                        "stage-2"
                    ],
                    plugins: [
                        'transform-runtime',
                        ["istanbul", {
                            "exclude": [
                                "**/*.spec.js",
                                "resources/assets/js/*.js",
                                "resources/assets/js/components/**/*.(js|vue)",
                                "resources/assets/js/views/**/*.(js|vue)",
                                "resources/assets/tests/unit/*.js"
                            ]
                        }]
                    ],
                }
            },
            {
                test: /\.(png|jpg|gif|svg)$/,
                loader: 'file-loader',
                options: {
                    name: '[name].[ext]?[hash]'
                }
            },
        ]
    },
    resolve: {
        extensions: ['.js', '.vue', '.json'],
        modules: [
            './resources/assets/js',
            'node_modules',
        ],
        alias: {
            'vue$': 'vue/dist/vue.common.js',
            '@': resolve('resources/assets/js')
        }
    },
    devServer: {
        historyApiFallback: true,
        noInfo: true
    },
    node: {
        net: 'empty',
        tls: 'empty',
        dns: 'empty',
        fs: "empty",
        child_process: 'empty'
    },
    // use inline sourcemap for karma-sourcemap-loader
    devtool: '#inline-source-map',
    plugins: [
        new webpack.EnvironmentPlugin({ NODE_ENV: '"testing"' }),
        new webpack.DefinePlugin({
            'process.env': { NODE_ENV: '"testing"' }
        }),
    ]
};