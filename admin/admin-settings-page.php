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

?>


    <?php
    global $wpdb;
    $msg = '';



    $action = isset($_GET['action']) ? trim($_GET['action']) : "";
    $id = isset($_GET['id']) ? intval($_GET['id']) : "";

    $row_details = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT * from wp_editorial_calendar WHERE id = %d",
            $id
        ),
        ARRAY_A
    );


    if (isset($_POST['btnsubmit'])) {

        $action = isset($_GET['action']) ? trim($_GET['action']) : "";
        $id = isset($_GET['id']) ? intval($_GET['id']) : "";

        if (!empty($action)) {

            $wpdb->update("wp_editorial_calendar", array(
                "occation" => $_POST['occation'],
                "date" => $_POST['date'],
                "post-title" => $_POST['post-title'],
                "writer" => $_POST['writer'],
                'reviewer' => $_POST['reviewer']
            ), array(
                "id" => $id
            ));

            $msg = "Form data updated successfully";
        } else {

            $wpdb->insert("wp_editorial_calendar", array(
                "occation" => $_POST['occation'],
                "date" => $_POST['date'],
                "post-title" => $_POST['post-title'],
                "writer" => $_POST['writer'],
                'reviewer' => $_POST['reviewer']
            ));

            if ($wpdb->insert_id > 0) {
                $msg = "Form data saved successfully";
            } else {
                $msg = "Failed to save data";
            }
        }
    }
    ?>

    <div class="wrap">
        <h1 class="page-header">Editorial Calendar</h1>
        <h2>Add New Occation</h2>

        <p><?php echo $msg; ?></p>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>?page=editorialCalendar" method="post">
            <label>Occation</label>
            <input type="text" name="occation" value="<?php echo isset($row_details['occation']) ? $row_details['occation'] : ""; ?>" placeholder="Enter Occation" />

            <label>Date</label>
            <input type="date" name="date" value="<?php echo isset($row_details['date']) ? $row_details['date'] : ""; ?>" />

            <label>Post Title</label>
            <input type="text" name="post-title" value="<?php echo isset($row_details['post-title']) ? $row_details['post-title'] : ""; ?>" />


            <label>Writer</label>
            <select id="writer" name="writer">;
                <?php
                $users = get_users();
                $userlist = '';

                foreach ($users as $user) {
                    $userlist .= '<option value="' . $user->display_name . '">' . $user->display_name . '</option>';
                }

                echo $userlist; ?>
            </select>

            <label>Reviewer</label>
            <select id="reviewer" name="reviewer">;
                <?php
                $users = get_users(array('role__not_in' => array('author')));
                $userlist = '';

                foreach ($users as $user) {
                    $userlist .= '<option value="' . $user->display_name . '">' . $user->display_name . '</option>';
                }

                echo $userlist; ?>
            </select>


            <button type="submit" name="btnsubmit">Submit</button>
        </form>
    </div>

<?php

}

?>