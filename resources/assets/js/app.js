/**
 * Created by User on 5/24/2016.
 */
window.$ = window.jQuery = require('jquery')
require('bootstrap-sass');

$( document ).ready(function() {
    console.log($.fn.tooltip.Constructor.VERSION);
});