var gulp           = require('gulp'),
		gutil          = require('gulp-util' ),
		sass           = require('gulp-sass'),
		browserSync    = require('browser-sync'),
		concat         = require('gulp-concat'),
		uglify         = require('gulp-uglify'),
		cleanCSS       = require('gulp-clean-css'),
		rename         = require('gulp-rename'),
		del            = require('del'),
		imagemin       = require('gulp-imagemin'),
		cache          = require('gulp-cache'),
		autoprefixer   = require('gulp-autoprefixer'),
		ftp            = require('vinyl-ftp'),
		notify         = require("gulp-notify"),
		rsync          = require('gulp-rsync'),
		connectPHP = require('gulp-connect-php'); 

	gulp.task('browser-sync', function() {
		browserSync({
       proxy:'http://fisher/app',
       notify: false
    });
	});

// Пользовательские скрипты проекта

gulp.task('php', function(){
  connectPHP.server({ 
  	base: './',
  	keepalive:true,
  	hostname: 'localhost',
  	open: false});
});

//----------------------------------------------------------------

// gulp.task('common-js', function() {
// 	return gulp.src([
// 		'app/js/common.js',
// 		])
// 	.pipe(concat('common.min.js'))
// 	.pipe(uglify())
// 	.pipe(gulp.dest('app/js'));
// });

// gulp.task('js', ['common-js'], function() {
// 	return gulp.src([
// 		'app/libs/jquery/dist/jquery.min.js',
// 		'app/js/setting.js',
// 		'app/libs/slick-carousel/slick/slick.min.js',
// 		'app/libs/ui-tabs/jquery-ui.min.js',
// 		'app/libs/jq-timeTo/jquery.time-to.js',
// 		'app/js/common.min.js' // Всегда в конце
// 		])
// 	.pipe(concat('scripts.min.js'))
// 	// .pipe(uglify()) // Минимизировать весь js (на выбор)
// 	.pipe(gulp.dest('app/js'))
// 	.pipe(browserSync.reload({ stream: true }));
// });

// gulp.task('common-js', function() {
// 	return gulp.src([
// 		'app/js/items.js',
// 		])
// 	.pipe(concat('items.min.js'))
// 	.pipe(uglify())
// 	.pipe(gulp.dest('app/js'));
// });

// gulp.task('js', ['common-js'], function() {
// 	return gulp.src([
// 		'app/libs/jquery/dist/jquery.min.js',
// 		'app/js/setting.js',
// 		'app/libs/ui-tabs/jquery-ui.min.js',
// 		'app/js/items.min.js' // Всегда в конце
// 		])
// 	.pipe(concat('scripts-items.min.js'))
// 	// .pipe(uglify()) // МинимизироватВсегоь весь js (на выбор)
// 	.pipe(gulp.dest('app/js'))
// 	.pipe(browserSync.reload({ stream: true }));
// });

// gulp.task('common-js', function() {
// 	return gulp.src([
// 		'app/js/cart.js',
// 		])
// 	.pipe(concat('cart.min.js'))
// 	.pipe(uglify())
// 	.pipe(gulp.dest('app/js'));
// });

// gulp.task('js', ['common-js'], function() {
// 	return gulp.src([
// 		'app/libs/jquery/dist/jquery.min.js',
// 		'app/js/setting.js',
// 		'app/libs/magnific-popup/dist/jquery.magnific-popup.min.js',
// 		'app/js/cart.min.js' // Всегда в конце
// 		])
// 	.pipe(concat('scripts-cart.min.js'))
// 	// .pipe(uglify()) // Минимизировать весь js (на выбор)
// 	.pipe(gulp.dest('app/js'))
// 	.pipe(browserSync.reload({ stream: true }));
// });

// gulp.task('common-js', function() {
// 	return gulp.src([
// 		'app/js/catalogue.js',
// 		])
// 	.pipe(concat('catalogue.min.js'))
// 	.pipe(uglify())
// 	.pipe(gulp.dest('app/js'));
// });

// gulp.task('js', ['common-js'], function() {
// 	return gulp.src([
// 		'app/libs/jquery/dist/jquery.min.js',
// 		'app/js/setting.js',
// 		'app/libs/ui-slider/jquery-ui.min.js',
// 		'app/libs/jqueryui-touch-punch/jquery.ui.touch-punch.min.js',
// 		'app/js/catalogue.min.js' // Всегда в конце
// 		])
// 	.pipe(concat('scripts-catalogue.min.js'))
// 	// .pipe(uglify()) // МинимизироватВсегоь весь js (на выбор)
// 	.pipe(gulp.dest('app/js'))
// 	.pipe(browserSync.reload({ stream: true }));
// });

// gulp.task('common-js', function() {
// 	return gulp.src([
// 		'app/js/contacts.js',
// 		])
// 	.pipe(concat('contacts.min.js'))
// 	.pipe(uglify())
// 	.pipe(gulp.dest('app/js'));
// });

// gulp.task('js', ['common-js'], function() {
// 	return gulp.src([
// 		'app/libs/jquery/dist/jquery.min.js',
// 		'app/js/setting.js',
// 		'app/js/contacts.min.js' // Всегда в конце
// 		])
// 	.pipe(concat('scripts-contacts.min.js'))
// 	// .pipe(uglify()) // МинимизироватВсегоь весь js (на выбор)
// 	.pipe(gulp.dest('app/js'))
// 	.pipe(browserSync.reload({ stream: true }));
// });

// gulp.task('common-js', function() {
// 	return gulp.src([
// 		'app/js/blog.js',
// 		])
// 	.pipe(concat('blog.min.js'))
// 	.pipe(uglify())
// 	.pipe(gulp.dest('app/js'));
// });

// gulp.task('js', ['common-js'], function() {
// 	return gulp.src([
// 		'app/libs/jquery/dist/jquery.min.js',
// 		'app/js/setting.js',
// 		'app/js/blog.min.js' // Всегда в конце
// 		])
// 	.pipe(concat('scripts-blog.min.js'))
// 	// .pipe(uglify()) // МинимизироватВсегоь весь js (на выбор)
// 	.pipe(gulp.dest('app/js'))
// 	.pipe(browserSync.reload({ stream: true }));
// });

// gulp.task('common-js', function() {
// 	return gulp.src([
// 		'app/js/post.js',
// 		])
// 	.pipe(concat('post.min.js'))
// 	.pipe(uglify())
// 	.pipe(gulp.dest('app/js'));
// });

// gulp.task('js', ['common-js'], function() {
// 	return gulp.src([
// 		'app/libs/jquery/dist/jquery.min.js',
// 		'app/js/setting.js',
// 		'app/js/post.min.js' // Всегда в конце
// 		])
// 	.pipe(concat('scripts-post.min.js'))
// 	// .pipe(uglify()) // МинимизироватВсегоь весь js (на выбор)
// 	.pipe(gulp.dest('app/js'))
// 	.pipe(browserSync.reload({ stream: true }));
// });

gulp.task('common-js', function() {
	return gulp.src([
		'app/js/search.js',
		])
	.pipe(concat('search.min.js'))
	.pipe(uglify())
	.pipe(gulp.dest('app/js'));
});

gulp.task('js', ['common-js'], function() {
	return gulp.src([
		'app/libs/jquery/dist/jquery.min.js',
		'app/js/setting.js',
		'app/js/search.min.js' // Всегда в конце
		])
	.pipe(concat('scripts-search.min.js'))
	// .pipe(uglify()) // МинимизироватВсегоь весь js (на выбор)
	.pipe(gulp.dest('app/js'))
	.pipe(browserSync.reload({ stream: true }));
});

//----------------------------------------------------------------

gulp.task('sass', function() {
	return gulp.src('app/sass/**/*.sass')
	.pipe(sass({outputStyle: 'expand'}).on("error", notify.onError()))
	.pipe(rename({suffix: '.min', prefix : ''}))
	.pipe(autoprefixer(['last 15 versions']))
	.pipe(cleanCSS()) // Опционально, закомментировать при отладке
	.pipe(gulp.dest('app/css'))
	.pipe(browserSync.stream())
});

gulp.task('watch', ['sass', 'js', 'browser-sync', 'php'], function() {
	gulp.watch('app/sass/**/*.sass', ['sass']);
	gulp.watch(['libs/**/*.js', 'app/js/**.js'], ['js']);
	gulp.watch('app/*.html', browserSync.reload);
	gulp.watch('app/*.php', browserSync.reload);
});

gulp.task('imagemin', function() {
	return gulp.src('app/img/**/*')
	.pipe(cache(imagemin())) // Cache Images
	.pipe(gulp.dest('dist/img')); 
});

gulp.task('build', ['removedist', 'imagemin', 'sass', 'js'], function() {

	var buildFiles = gulp.src([
		'app/*.html',
		'app/.htaccess',
		]).pipe(gulp.dest('dist'));

	var buildCss = gulp.src([
		'app/css/main.min.css',
		]).pipe(gulp.dest('dist/css'));

	var buildJs = gulp.src([
		'app/js/scripts.min.js',
		]).pipe(gulp.dest('dist/js'));

	var buildFonts = gulp.src([
		'app/fonts/**/*',
		]).pipe(gulp.dest('dist/fonts'));

});

gulp.task('deploy', function() {

	var conn = ftp.create({
		host:      'hostname.com',
		user:      'username',
		password:  'userpassword',
		parallel:  10,
		log: gutil.log
	});

	var globs = [
	'dist/**',
	'dist/.htaccess',
	];
	return gulp.src(globs, {buffer: false})
	.pipe(conn.dest('/path/to/folder/on/server'));

});

gulp.task('rsync', function() {
	return gulp.src('dist/**')
	.pipe(rsync({
		root: 'dist/',
		hostname: 'username@yousite.com',
		destination: 'yousite/public_html/',
		// include: ['*.htaccess'], // Скрытые файлы, которые необходимо включить в деплой
		recursive: true,
		archive: true,
		silent: false,
		compress: true
	}));
});


gulp.task('removedist', function() { return del.sync('dist'); });
gulp.task('clearcache', function () { return cache.clearAll(); });

gulp.task('default', ['watch']);
