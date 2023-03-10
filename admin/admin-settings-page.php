<?php // MyPlugin - Settings Page



// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}



// display the plugin settings page
function editorialCalendar_display_settings_page()
{

    // check if user is allowed access
    if (!current_user_can('manage_options')) return;
    require_once plugin_dir_path(__FILE__) . 'admin-display-form.php';
}
