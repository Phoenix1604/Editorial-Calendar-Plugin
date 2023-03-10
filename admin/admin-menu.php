<?php   //Add Top Level Menu Page 

// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}

function editorialCalendar_add_toplevel_menu()
{
    /* 
	add_menu_page(
		string   $page_title, 
		string   $menu_title, 
		string   $capability, 
		string   $menu_slug, 
		callable $function = '', 
		string   $icon_url = '', 
		int      $position = null 
	)
	*/
    add_menu_page(
        'Editorial Calendar',
        'Editorial Calendar',
        'manage_options',
        'editorialCalendar',
        'editorialCalendar_display_settings_page',
        'dashicons-media-code',
        100
    );
}
add_action('admin_menu', 'editorialCalendar_add_toplevel_menu');
