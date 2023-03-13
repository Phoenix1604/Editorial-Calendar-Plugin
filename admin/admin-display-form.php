<?php
global $wpdb;
$msg = '';



$action = isset($_GET['action']) ? trim($_GET['action']) : "";
$id = isset($_GET['id']) ? intval($_GET['id']) : "";
$occations = get_option('edcal_occation_content', array());
$unserialized_occations = unserialize($occations);
if ($id !== "" && $action === 'edit') {
    $row_details = $unserialized_occations[$id];
}



if (isset($_POST['btnsubmit'])) {

    $action = isset($_GET['action']) ? trim($_GET['action']) : "";
    $id = isset($_GET['id']) ? intval($_GET['id']) : "";
    $postDetails = array(
        "occation" => $_POST['occation'],
        "date" => $_POST['date'],
        "post-title" => $_POST['post-title'],
        "writer" => $_POST['writer'],
        'reviewer' => $_POST['reviewer']
    );

    $occations = get_option('edcal_occation_content', array());
    $unserialized_occations = unserialize($occations); //unserialize to get the array
    if (!empty($action)) {
        $unserialized_occations[$id] = $postDetails;
        $msg = "Form data updated successfully";
    } else {
        $unserialized_occations[] = $postDetails;
        $msg = "Form data added successfully";
    }

    $serialized_occations = serialize($unserialized_occations);

    // Store the serialized object in the WordPress database
    update_option('edcal_occation_content', $serialized_occations); ?>
    <script>
        location.href = "<?php echo site_url() ?>/wp-admin/admin.php?page=editorialCalendar";
    </script>
<?php
}
?>

<div class="wrap edcal-wrap">
    <h1 class="page-header">Editorial Calendar</h1>
    <h2>Add New Occation</h2>
    <p class="updated"><?php echo $msg; ?></p>
    <form id="edcal-create-occation-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=editorialCalendar<?php if (!empty($action)) {
                                                                                                                                echo '&action=edit&id=' . $id;
                                                                                                                            } ?>">
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


        <button type="submit" name="btnsubmit" class="button">Submit</button>
    </form>
    <?php require_once plugin_dir_path(__FILE__) . 'admin-display-table.php'; ?>
</div>