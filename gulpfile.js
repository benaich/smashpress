const { src, dest, series } = require("gulp");
const uglify = require("gulp-uglify");
const rename = require("gulp-rename");
const concat = require("gulp-concat");
const minifyCSS = require("gulp-minify-css");
const replace = require("gulp-replace");
const order = require("gulp-order");

const themeFolder = "./smashpress-theme";
const distFolder = `${themeFolder}/dist`;
const assetsFolder = `${themeFolder}/src/assets`;
const generatedAssetsFolder = "tmp";

const jsTask = () => {
  return src([`${assetsFolder}/js/*.js`, `${generatedAssetsFolder}/js/*.js`])
    .pipe(order(["libs*.js", "themes*.js", "plugins*.js", "main.js"]))
    .pipe(concat("bundle.js"))
    .pipe(uglify())
    .pipe(dest(distFolder));
};

const cssTask = () => {
  return (
    src([`${assetsFolder}/css/*.css`, `${generatedAssetsFolder}/css/*.css`])
      .pipe(order(["plugins_*.css", "themes_*.css", "main.css"]))
      .pipe(concat("bundle.css"))

      // clean up
      .pipe(replace('@charset "UTF-8";', ""))

      // assets path resolution might be needed
      .pipe(
        replace(
          "../images/logo-1234.jpg",
          "/wp-content/themes/smashpress/images/logo-1234.png"
        )
      )
      .pipe(minifyCSS())
      .pipe(dest(distFolder))
  );
};

exports.default = series(jsTask, cssTask);
