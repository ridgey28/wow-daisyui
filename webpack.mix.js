import path from "node:path";
let mix = require("laravel-mix");
require("mix-tailwindcss");

mix
  .js("/dev/js/dev-app.js", "assets/js/app.js")
  .css("/dev/css/dev-index.css", "assets/css/styles.css")
  .tailwind()
  //   .options({
  //     purge: {
  //       options: {
  //         safelist: [/data-theme$/],
  //       },
  //     },
  //   })

  .setPublicPath(path.resolve("./"))
  .version();
