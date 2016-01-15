var elixir = require('laravel-elixir');


/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
	var bootstrapPath = 'node_modules/bootstrap-sass/assets';
	mix.sass('app.scss')
		.copy(bootstrapPath + '/fonts', 'public/fonts')
		.copy(
			[
				'node_modules/select2/dist/css/select2.css',
				'node_modules/select2-bootstrap-css/select2-bootstrap.min.css'
			],
			'public/css'
		)
		.stylesIn('public/css')
		.browserify('app.js');
});