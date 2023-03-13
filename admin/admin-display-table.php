<?php
// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}
$msg = '';
display_all_posts($msg);

//action and id passed in the url
$action = isset($_GET['action']) ? trim($_GET['action']) : "";
$id = isset($_GET['id']) ? intval($_GET['id']) : "";

//check for the action and delete the post
if (!empty($action) && $action === 'delete') {

    $serialized_occations = get_option('edcal_occation_content', array());

    $unserialized_occations = unserialize($serialized_occations);
    unset($unserialized_occations[$id]);
    $serialized_occations = serialize($unserialized_occations);
    // Store the serialized object in the WordPress database
    update_option('edcal_occation_content', $serialized_occations);
?>
    <script>
        location.href = "<?php echo site_url() ?>/wp-admin/admin.php?page=editorialCalendar";
    </script>
<?php
    $msg = 'Occation Deleted';
}


function display_all_posts($msg)
{
    $serialized_occations = get_option('edcal_occation_content');
    $unserialized_occations = unserialize($serialized_occations);

?>
    <p><?php echo $msg; ?></p>
    <table cellpadding="10">
        <thead>
            <th>Sr No</th>
            <th>Occation</th>
            <th>Date</th>
            <th>Post Title</th>
            <th>Author</th>
            <th>Reviewer</th>
        </thead>
        <?php
        $count = 1;
        foreach ($unserialized_occations as $index => $post) {
        ?>
            <tr>
                <td><?php echo $count++; ?></td>
                <td><?php echo $post['occation'] ?></td>
                <td><?php echo $post['date'] ?></td>
                <td><?php echo $post['post-title'] ?></td>
                <td><?php echo $post['writer'] ?></td>
                <td><?php echo $post['reviewer'] ?></td>
                <td><a href="admin.php?page=editorialCalendar&action=edit&id=<?php echo $index; ?>"><span class="dashicons dashicons-edit"></span></a></td>
                <td><a href="admin.php?page=editorialCalendar&action=delete&id=<?php echo $index ?>"><span class="dashicons dashicons-trash"></span></a></td>
            </tr>
        <?php
        }
        ?>
    </table>
<?php

}

?>