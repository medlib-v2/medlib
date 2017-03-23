const fs = require('fs');
const path = require('path');
const mix = require('laravel-mix');
//const DotenvPlugin = require('webpack-dotenv-plugin');

const cookiesBar = require('./resources/assets/js/config.json'),
    booksApp = require('./resources/assets/js/books/config.json');

mix.webpackConfig({
    node: {
        dns: 'mock',
        net: 'mock'
    },
    resolve: { alias: { '@': path.resolve(__dirname, 'resources/assets/js') } },

    //plugins: [
    //    new DotenvPlugin({
    //        path: './.env'
    //    })
    //]
});
mix.config.detectHotReloading();

if (mix.config.hmr) {
    /**
     * There's a bug with Mix/copy plugin which prevents HMR from working:
     * https://github.com/JeffreyWay/laravel-mix/issues/150
     */
    console.log('In HMR mode. If assets are missing, Ctr+C and run `yarn dev` first.');

    /**
     * Somehow public/hot isn't being removed by Mix. We'll handle it ourselves.
     */
    process.on('SIGINT', () => {
        try {
            fs.unlinkSync(mix.config.publicPath + '/hot');
        } catch (e) {}
        process.exit();
    });
} else {
    mix.copy('resources/assets/images', 'public/images', false)
        //.copy('resources/assets/fonts', 'public/fonts', false)
}

mix.js('resources/assets/js/app.js', 'public/js')
    .js(cookiesBar.src, cookiesBar.dist)
    .js(booksApp.src, booksApp.dist)
    .sass('resources/assets/sass/application.scss', 'public/css');

if (mix.config.inProduction) mix.version().disableNotifications();

if (!mix.config.inProduction) {
    mix.browserSync({
        proxy: 'http://medlib.app',
        browser: ['yandex']
    })
}