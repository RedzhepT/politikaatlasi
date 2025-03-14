const mix = require("laravel-mix");

mix.js("resources/js/app.js", "public/js")
    .sass("resources/sass/app.scss", "public/css")
    .version()
    .options({
        terser: {
            extractComments: false,
            terserOptions: {
                compress: {
                    drop_console: true,
                },
            },
        },
        cssNano: {
            discardComments: {
                removeAll: true,
            },
        },
        postCss: [require("autoprefixer")],
    });
