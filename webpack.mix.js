let mix = require("laravel-mix");
let path = require("path");

mix.setPublicPath(path.resolve("./"));
mix.js("assets/dev/js/app.js", "assets/js/app.js");
mix.postCss("assets/dev/css/index.css", "assets/css/styles.css", [require("tailwindcss")]);
mix.options({
    purge: {
        options: {
            safelist: [/data-theme$/]
        },
    },
});

mix.version();