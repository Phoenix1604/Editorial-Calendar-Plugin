<?php
/* 
Plugin Name: Editorial Calendar Plugin
Plugin URI: https://www.wisdmlabs.com/
Description: This is content-calender Plugin
Author: Subhajit Bera
Author URI: https://www.wisdmlabs.com
Text Domain:  editorialCalendar
Version: 1.0 
*/

if (is_admin()) {
    require_once plugin_dir_path(__FILE__) . 'admin/admin-menu.php';
    require_once plugin_dir_path(__FILE__) . 'admin/admin-settings-page.php';
    require_once plugin_dir_path(__FILE__) . 'admin/admin-register-settings.php';
}


function editorialCalendar_adminpage_style()
{
    wp_enqueue_style('editorialCalendar', plugin_dir_url(__FILE__) . 'admin/css/admin-style.css', array(), null, 'screen');
}
add_action('admin_enqueue_scripts', 'editorialCalendar_adminpage_style', 20);

// Register activation hook
register_activation_hook(__FILE__, 'my_plugin_activate');

// Activation function
function my_plugin_activate()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'editorial_calendar';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id INT(11) NOT NULL AUTO_INCREMENT,
        occation VARCHAR(255) NOT NULL,
        date DATE NOT NULL,
        post-title VARCHAR(255) NOT NULL,
        writer VARCHAR(255) NOT NULL,
        reviewer VARCHAR(255) NOT NULL
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Register uninstall hook
//register_uninstall_hook(__FILE__, 'my_plugin_uninstall');
register_deactivation_hook(__FILE__, 'my_plugin_uninstall');

// Uninstall function
function my_plugin_uninstall()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'editorial_calendar';

    $wpdb->query("DROP TABLE IF EXISTS $table_name");
}
