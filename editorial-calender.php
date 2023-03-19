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
    //require_once plugin_dir_path(__FILE__) . 'admin/admin-register-settings.php';
}


function editorialCalendar_adminpage_style()
{
    wp_enqueue_style('Gfonts', "https://fonts.googleapis.com/css2?family=Poppins&display=swap", array(), null, 'screen');
    wp_enqueue_style('editorialCalendar', plugin_dir_url(__FILE__) . 'admin/css/admin-style.css', array(), null, 'screen');
}
add_action('admin_enqueue_scripts', 'editorialCalendar_adminpage_style');

function editorialCalendar_adminpage_scripts()
{
    wp_enqueue_script('editorialCalendar', plugin_dir_url(__FILE__) . 'admin/js/newoccationpopup.js', array(), null, true);
}
add_action('admin_enqueue_scripts', 'editorialCalendar_adminpage_scripts');
