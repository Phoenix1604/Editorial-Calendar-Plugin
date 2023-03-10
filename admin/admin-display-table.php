<?php
// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}

global $wpdb;

$all_posts = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT * from wp_editorial_calendar",
        ""
    ),
    ARRAY_A
);

if (count($all_posts) > 0) {
?>
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
            </tr>
        <?php
        }
        ?>
    </table>

<?php
}
?>