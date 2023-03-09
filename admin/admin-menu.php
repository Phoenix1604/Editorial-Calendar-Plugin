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
        'Content Calendar',
        'Editorial Calendar',
        'manage_options',
        'editorialCalendar',
        'editorialCalendar_display_settings_page',
        'dashicons-media-code',
        100
    );
}
add_action('admin_menu', 'editorialCalendar_add_toplevel_menu');


function editorialCalendar_display_settings_page()
{
    echo '<div class="wrap">';
    echo '<h1 class="page-header" >Editorial Calendar</h1>';

    //output the form 
    echo '<h2>Add New Occation</h2>';
    echo '<form method="post">';

    echo '<label for="occation">Occation:</label>';
    echo '<input type="text" id="occation" name="occation">';

    echo '<label for="date">Date:</label>';
    echo '<input type="date" id="date" name="date">';
}
