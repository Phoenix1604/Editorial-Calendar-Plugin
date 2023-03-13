<?php
// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}

global $wpdb;
$msg = '';
display_all_posts($wpdb, $msg);

//action and id passed in the url
$action = isset($_GET['action']) ? trim($_GET['action']) : "";
$id = isset($_GET['id']) ? intval($_GET['id']) : "";

//check for the action and delete the post
if (!empty($action) && $action === 'delete') {
    $row_exists = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT * from wp_editorial_calendar WHERE id = %d",
            $id
        )
    );
    if (!empty($row_exists)) {
        $wpdb->delete("wp_editorial_calendar", array(
            "id" => $id
        ));
?>
        <script>
            location.href = "<?php echo site_url() ?>/wp-admin/admin.php?page=editorialCalendar";
        </script>
    <?php
        $msg = 'Occation Deleted';
    }
}

function display_all_posts($wpdb, $msg)
{
    $all_posts = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * from wp_editorial_calendar",
            ""
        ),
        ARRAY_A
    );

    if (count($all_posts) > 0) {
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
            foreach ($all_posts as $index => $post) {
            ?>
                <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $post['occation'] ?></td>
                    <td><?php echo $post['date'] ?></td>
                    <td><?php echo $post['post-title'] ?></td>
                    <td><?php echo $post['writer'] ?></td>
                    <td><?php echo $post['reviewer'] ?></td>
                    <td><a href="admin.php?page=editorialCalendar&action=edit&id=<?php echo $post['id']; ?>"><span class="dashicons dashicons-edit"></span></a></td>
                    <td><a href="admin.php?page=editorialCalendar&action=delete&id=<?php echo $post['id']; ?>"><span class="dashicons dashicons-trash"></span></a></td>
                </tr>
            <?php
            }
            ?>
        </table>

<?php
    }
}

?>