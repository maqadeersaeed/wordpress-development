<?php

/**
 * Plugin Name: Salah Companion 
 * Description: This Plugin is to manage & display prayer times.
 * Version:     1.0.0
 * Plugin URI: https://maqadeersaeed.com/anywhere-prayer-time-plugin-wordpress/
 * Author:      M. Qadeer Saeed
 * Author URI:  https://maqadeersaeed.com/
 * License:     GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: sc
 * Domain Path: /languages
 */

defined('ABSPATH') or die('No Cheats Please!');

    global $wpdb;
    $table_name = $wpdb->prefix . "salah_companion";
    $charset_collate = $wpdb->get_charset_collate();


function sc_custom_admin_styles() {
    wp_enqueue_style('custom-styles', plugins_url('/css/styles.css', __FILE__ ));
	}
add_action('admin_enqueue_scripts', 'sc_custom_admin_styles');


// function to create the DB / Options / Defaults
function sc_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "salah_companion";
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `latitude` varchar(50) NOT NULL,
            `longitude` VARCHAR (50) NOT NULL,
            `time_zone` VARCHAR (100) NOT NULL,
            `country` VARCHAR (100) NOT NULL,
            `city` VARCHAR (100) NOT NULL,
            `calc_method` VARCHAR (100) NOT NULL,
            `salat_juristic` VARCHAR (100) NOT NULL,
            `salat_highlatsmethod` VARCHAR (100) NOT NULL,
            `time_format` VARCHAR (100) NOT NULL,
            `qibla_angle` VARCHAR (100) NOT NULL,
            `adjust_prayer_fajr` int(3) NOT NULL,
            `adjust_prayer_zohr` int(3) NOT NULL,
            `adjust_prayer_asr` int(3) NOT NULL,
            `adjust_prayer_maghrib` int(3) NOT NULL,
            `adjust_prayer_isha` int(3) NOT NULL,
            `blurb` VARCHAR (1000) NOT NULL,
            PRIMARY KEY (`id`)
        ) $charset_collate; ";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
// run the install scripts upon plugin activation
register_activation_hook(__FILE__, 'sc_install');


// function sc_load_plugin_textdomain()
// {
//     load_plugin_textdomain('sc', false, basename(dirname(__FILE__)) . '/languages');
// }
// add_action('plugins_loaded', 'sc_load_plugin_textdomain');



function sc_admin_menu()
{
    add_menu_page(
        'Prayer Times', //page title
        'Prayer Times', //menu title
        'manage_options', //capabilities
        'prayer-times-list', //menu slug
        'sc_prayer_times_list_handler' //function
    );

    add_submenu_page(
        'prayer-times-list', //parent slug
        'Prayer Time', //page title
        'Add Prayer Time', //menu title
        'manage_options', //capability
        'prayer-time-form', //menu slug
        'sc_prayer_times_create_handler' //function
    ); 

    // //this submenu is HIDDEN, however, we need to add it anyways
    // add_submenu_page(
    //     null, //parent slug
    //     'Prayer Time', //page title
    //     'Prayer Time', //menu title
    //     'manage_options', //capability
    //     'prayer-time-update', //menu slug
    //     'sc_prayer_times_update_handler' // function
    // );
}
add_action('admin_menu', 'sc_admin_menu');

// function sc_languages()
// {
//     load_plugin_textdomain('sc', false, dirname(plugin_basename(__FILE__)));
// }
// add_action('init', 'sc_languages');

// define('ROOTDIR', plugin_dir_path(__FILE__));
$ROOTDIR = plugin_dir_path(__FILE__);
require($ROOTDIR . 'includes/prayer-times-list.php');
require($ROOTDIR . 'includes/prayer-time-form.php');
