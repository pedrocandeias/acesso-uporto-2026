/**
 * Theme Customizer Live Preview
 *
 * @package AcessoUPorto
 */

(function($) {
    'use strict';

    // Helper function to update CSS variable
    function updateCSSVar(varName, value) {
        document.documentElement.style.setProperty(varName, value);
    }

    // Primary Color
    wp.customize('acesso_color_primary', function(value) {
        value.bind(function(newval) {
            updateCSSVar('--color-primary', newval);
            updateCSSVar('--color-purple', newval);
        });
    });

    // Secondary Color
    wp.customize('acesso_color_secondary', function(value) {
        value.bind(function(newval) {
            updateCSSVar('--color-secondary', newval);
            updateCSSVar('--color-pink', newval);
        });
    });

    // Dark Color
    wp.customize('acesso_color_dark', function(value) {
        value.bind(function(newval) {
            updateCSSVar('--color-dark', newval);
        });
    });

    // Cyan Color
    wp.customize('acesso_color_cyan', function(value) {
        value.bind(function(newval) {
            updateCSSVar('--color-cyan', newval);
        });
    });

    // Lavender Color
    wp.customize('acesso_color_lavender', function(value) {
        value.bind(function(newval) {
            updateCSSVar('--color-lavender', newval);
        });
    });

    // Coral Color
    wp.customize('acesso_color_coral', function(value) {
        value.bind(function(newval) {
            updateCSSVar('--color-coral', newval);
        });
    });

    // Gradient Start
    wp.customize('acesso_gradient_start', function(value) {
        value.bind(function(newval) {
            var end = wp.customize('acesso_gradient_end').get();
            var dir = wp.customize('acesso_gradient_direction').get();
            updateCSSVar('--gradient-primary', 'linear-gradient(' + dir + ', ' + newval + ' 0%, ' + end + ' 100%)');
        });
    });

    // Gradient End
    wp.customize('acesso_gradient_end', function(value) {
        value.bind(function(newval) {
            var start = wp.customize('acesso_gradient_start').get();
            var dir = wp.customize('acesso_gradient_direction').get();
            updateCSSVar('--gradient-primary', 'linear-gradient(' + dir + ', ' + start + ' 0%, ' + newval + ' 100%)');
        });
    });

    // Gradient Direction
    wp.customize('acesso_gradient_direction', function(value) {
        value.bind(function(newval) {
            var start = wp.customize('acesso_gradient_start').get();
            var end = wp.customize('acesso_gradient_end').get();
            updateCSSVar('--gradient-primary', 'linear-gradient(' + newval + ', ' + start + ' 0%, ' + end + ' 100%)');
        });
    });

    // Font Body Weight
    wp.customize('acesso_font_body_weight', function(value) {
        value.bind(function(newval) {
            updateCSSVar('--font-body-weight', newval);
        });
    });

    // Font Heading Weight
    wp.customize('acesso_font_heading_weight', function(value) {
        value.bind(function(newval) {
            updateCSSVar('--font-heading-weight', newval);
        });
    });

    // Font Size Base
    wp.customize('acesso_font_size_base', function(value) {
        value.bind(function(newval) {
            updateCSSVar('--font-size-base', newval + 'px');
        });
    });

    // Logo Height
    wp.customize('acesso_logo_height', function(value) {
        value.bind(function(newval) {
            $('.site-logo img, .custom-logo').css('max-height', newval + 'px');
        });
    });

})(jQuery);
