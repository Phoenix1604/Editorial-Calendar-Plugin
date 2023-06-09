<?php
$msg = '';


//check if action and id is present in the url
$action = isset($_GET['action']) ? trim($_GET['action']) : "";
$id = isset($_GET['id']) ? intval($_GET['id']) : "";

//Retreving the data from options table and unserialize
$occations = get_option('edcal_occation_content', array());
if (!empty($occations)) {
    $occations = unserialize($occations);
}

if ($id !== "" && $action === 'edit') {
    $row_details = $occations[$id]; //particular row inside the row
    if ($row_details === null) { // if the id doesn't exist then redirect to the admin main page
?>
        <script>
            location.href = "<?php echo site_url() ?>/wp-admin/admin.php?page=editorialCalendar";
        </script>
    <?php
    }
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
    if (!empty($occations)) {
        $occations = unserialize($occations);
    } //unserialize to get the array
    if (!empty($action)) {
        $occations[$id] = $postDetails;
        $msg = "Form data updated successfully";
    } else {
        $occations[] = $postDetails;
        $msg = "Form data added successfully";
    }

    $serialized_occations = serialize($occations);

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
    <div class="addnew">
        <h2>Add New Occation</h2>
        <span class="dashicons dashicons-plus" id="open-from"></span>
    </div>

    <p class="updated"><?php echo $msg; ?></p>
    <div id="popup">
        <div id="popup-content">
            <h3>Occation Details</h3>
            <form id="edcal-create-occation-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=editorialCalendar<?php if (!empty($action)) {
                                                                                                                                        echo '&action=edit&id=' . $id;
                                                                                                                                    } ?>">
                <div class="input-box">
                    <label>Occation</label>
                    <input type="text" name="occation" value="<?php echo isset($row_details['occation']) ? $row_details['occation'] : ""; ?>" placeholder="Occation Name" />
                </div>

                <div class="input-box">
                    <label>Date</label>
                    <input id="date" type="date" name="date" value="<?php echo isset($row_details['date']) ? $row_details['date'] : ""; ?>" />
                </div>

                <div class="input-box">
                    <label>Post Title</label>
                    <input type="text" name="post-title" value="<?php echo isset($row_details['post-title']) ? $row_details['post-title'] : ""; ?>" placeholder="Post Title" />
                </div>
                <div class="input-box">
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
                </div>
                <div class="input-box">
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
                </div>
                <button type="submit" name="btnsubmit" class="popup-button add-button">Submit</button>
            </form>
            <button id="close-popup" class="popup-button close-button">Close</button>
        </div>
    </div>

    <?php require_once plugin_dir_path(__FILE__) . 'admin-display-table.php'; ?>
</div>