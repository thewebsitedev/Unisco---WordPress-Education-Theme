/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function ($) {
    // Site title
    wp.customize('blogname', function (value) {
        value.bind(function (to) {
            $('.site-title a').text(to);
            console.log(to);
        });
    });
    // Site tagline
    wp.customize('blogdescription', function (value) {
        value.bind(function (to) {
            $('.site-description').text(to);
        });
    });
})(jQuery);
