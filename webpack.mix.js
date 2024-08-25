const mix = require('laravel-mix');
const { VueLoaderPlugin } = require('vue-loader');

mix.js('resources/js/app.js', 'public/js')
    // .postCss('resources/css/app.css', 'public/css', [
    //     // Add any PostCSS plugins here
    // ])
    .webpackConfig({
        module: {
            rules: [
                {
                    test: /\.vue$/,
                    loader: 'vue-loader',
                },
                {
                    test: /\.js$/,
                    loader: 'babel-loader',
                    exclude: /node_modules/,
                },
            ],
        },
        plugins: [
            new VueLoaderPlugin(),
        ],
    });

mix.vue()
    .sass('resources/sass/app.scss', 'public/css').options({
        processCssUrls: false
    });