<?php

/*
 * Plugin Name: Central Color Palette
 * Plugin URI: https://wordpress.org/plugins/kt-tinymce-color-grid
 * Description: Take full control over color pickers of TinyMCE and the palette of the Theme Customizer. Create a central color palette for an uniform look'n'feel!
 * Version: 1.9.3
 * Author: Gáravo
 * Author URI: http://profiles.wordpress.org/kungtiger
 * License: GPL2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: kt-tinymce-color-grid
 */

if (defined('ABSPATH')) {
    if (!defined('KT_CENTRAL_PALETTE')) {
        define('KT_CENTRAL_PALETTE', 193);
        define('KT_CENTRAL_PALETTE_DIR', plugin_dir_path(__FILE__));
        define('KT_CENTRAL_PALETTE_URL', plugin_dir_url(__FILE__));
    }

    require_once KT_CENTRAL_PALETTE_DIR . 'include/color.php';
    require_once KT_CENTRAL_PALETTE_DIR . 'include/parser.php';
    require_once KT_CENTRAL_PALETTE_DIR . 'include/palette.php';

    kt_Central_Palette::instance();
}
