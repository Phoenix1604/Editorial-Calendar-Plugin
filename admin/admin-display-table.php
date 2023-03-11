<?php
// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}

global $wpdb;
$msg = '';
display_all_posts($wpdb, $msg);

if (isset($_POST['delete'])) {
    $id = $_POST['occationID'];
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
                    <td><a href="admin.php?page=editorialCalendar&action=edit&id=<?php echo $post['id']; ?>">Edit</a></td>

                    <td>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=editorialCalendar">
                            <input type="hidden" name="occationID" value="<?php echo $post['id'] ?>">
                            <button type="submit" name="delete">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>

<?php
    }
}

?>