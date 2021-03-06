/*jslint node: true */

/**
 * Dependencies
 */

// Gulp Dependencies
var gulp        = require('gulp');
var cleanCSS    = require('gulp-clean-css');
var notify      = require("gulp-notify");
var sourcemaps  = require('gulp-sourcemaps');

// Other Dependencies
var colors      = require('colors');
var sequence    = require('run-sequence');

/**
 * Config
 */

// Check for --production flag
var argv = require('yargs').argv;
var isProduction = !!(argv.production);

// Browsers to target when prefixing CSS.
var COMPATIBILITY = [
  'last 2 versions',
  'ie >= 6',
  'Android >= 2.3'
];

// File paths to various assets are defined here.
var PATHS = {
  javascript: [],
  phpcs: [
    '**/*.php',
    '!wpcs',
    '!wpcs/**',
  ]
};

/**
 * Compile Sass into CSS
 */
var autoprefixer  = require('gulp-autoprefixer');
var sass          = require('gulp-sass');
var rename        = require('gulp-rename');
gulp.task('sass', function() {

  return gulp.src('scss/*.scss')
    .pipe( sourcemaps.init() )
    .pipe(sass())
    .on('error', notify.onError({
        message: "<%= error.message %>",
        title: "Sass Error"
    }))
    .pipe(autoprefixer({
      browsers: COMPATIBILITY
    }))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('css'))
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(cleanCSS())
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('css'));
});

/**
 * Linting & Code Sniffing
 */

// JavaScript linting
var jshint = require('gulp-jshint');
gulp.task('lint', function() {
  return gulp.src('js/custom/*.js')
    .pipe(jshint())
    .pipe(notify(function (file) {
      if (file.jshint.success) {
        return false;
      }

      var errors = file.jshint.results.map(function (data) {
        if (data.error) {
          return "(" + data.error.line + ':' + data.error.character + ') ' + data.error.reason;
        }
      }).join("\n");
      return file.relative + " (" + file.jshint.results.length + " errors)\n" + errors;
    }));
});

// PHP Code Sniffer task
var phpcs = require('gulp-phpcs');
gulp.task('phpcs', function() {
  return gulp.src(PATHS.phpcs)
    .pipe(phpcs({
      bin: 'wpcs/vendor/bin/phpcs',
      standard: './phpcs.ruleset.xml',
      showSniffCode: true,
    }))
    .pipe(phpcs.reporter('log'));
});

// PHP Code Beautifier task
var phpcbf  = require('gulp-phpcbf');
var gutil   = require('gulp-util');

gulp.task('phpcbf', function () {
  return gulp.src(PATHS.phpcs)
  .pipe(phpcbf({
    bin: 'wpcs/vendor/bin/phpcbf',
    standard: './phpcs.ruleset.xml',
    warningSeverity: 0
  }))
  .on('error', gutil.log)
  .pipe(gulp.dest('.'));
});

/**
 * JavaScript Concatenation
 */
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
gulp.task('javascript', function() {
  var ugly = uglify()
    .on('error', notify.onError({
      message: "<%= error.message %>",
      title: "Uglify JS Error"
    }));

  return gulp.src(PATHS.javascript)
    .pipe(sourcemaps.init())
    .pipe(concat('foundation.js', {
      newLine:'\n;'
    }))
    .pipe(ugly)
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('js'));
});

/**
 * Build Task
 */
// Build task
// Runs sass & javascript in parallel
gulp.task('build', ['clean'], function(done) {
  sequence( ['sass', 'javascript', 'lint'], done);
});


/**
 * Cleaning taks (deleting old version)
 */
var del = require('del');
gulp.task('clean', function(done) {
  sequence(['clean:javascript', 'clean:css'], done);
});

gulp.task('clean:javascript', function() {
  return del([
      'js/*.min.js'
    ]);
});

gulp.task('clean:css', function() {
  return del([
      'css/*'
    ]);
});

/**
 * Default Task
 */
// Run build task and watch for file changes
gulp.task('default', ['build'], function() {
  // Log file changes to console
  function logFileChange(event) {
    var fileName = require('path').relative(__dirname, event.path);
    console.log('[' + 'WATCH'.green + '] ' + fileName.magenta + ' was ' + event.type + ', running tasks...');
  }

  // Sass Watch
  gulp.watch(['scss/**/*.scss'], ['clean:css', 'sass'])
    .on('change', function(event) {
      logFileChange(event);
    });

  // JS Watch
  gulp.watch(['javascript/custom/**/*.js'], ['clean:javascript', 'javascript', 'lint'])
    .on('change', function(event) {
      logFileChange(event);
    });
});
