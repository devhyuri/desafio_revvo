const { src, dest, series, parallel, watch } = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const cleanCSS = require('gulp-clean-css');
const uglify = require('gulp-uglify');
const sourcemaps = require('gulp-sourcemaps');
const concat = require('gulp-concat');

const paths = {
  stylesEntry: 'resources/sass/app.scss',
  stylesWatch: 'resources/sass/**/*.scss',
  scripts: ['resources/js/app.js'],
};

async function css() {
  // ESM-only plugin carregado via dynamic import
  const autoprefixer = (await import('gulp-autoprefixer')).default;

  return src(paths.stylesEntry)
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer({ cascade: false }))
    .pipe(cleanCSS())
    .pipe(sourcemaps.write('.'))
    .pipe(dest('public/assets/css'));
}

function js() {
  return src(paths.scripts, { allowEmpty: true })
    .pipe(sourcemaps.init())
    .pipe(concat('app.js'))
    .pipe(uglify())
    .pipe(sourcemaps.write('.'))
    .pipe(dest('public/assets/js'));
}

function watcher() {
  watch(paths.stylesWatch, css);
  watch('resources/js/**/*.js', js);
}

exports.css = css;
exports.js = js;
exports.build = parallel(css, js);
exports.watch = series(exports.build, watcher);
