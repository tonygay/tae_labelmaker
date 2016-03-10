window.$ = window.jQuery = require('jquery')
require('bootstrap-sass');
require('select2')

$( document ).ready(function() {
    console.log($.fn.tooltip.Constructor.VERSION);
});

$('select.select2').select2({
	placeholder: 'Start typing to select an institution...',
	allowClear: true
});