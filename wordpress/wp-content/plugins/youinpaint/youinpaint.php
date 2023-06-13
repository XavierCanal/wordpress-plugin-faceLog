<?php
/**
 * Plugin Name: YouInPaint Plugin
 * Plugin URI: http://boscdelacoma.cat
 * Description: Recuperació MP07.
 * Version: 0.1
 * Author: XAVIER
 * Author URI:  http://boscdelacoma.cat
 **/

require_once("includes/custom-pages.php");

const YOUINPAINT_DB_VERSION = '1.0';
const YOUINPAINT_VERSION = '1.0';
const uploaddir = __DIR__.'/uploads/orig';

function youinpaint_shortcode()
{
    $dataoutput = "";

    if (isset($_GET['yerror'])) {
        $dataoutput.= "<div class='youinpaint-error'>" . $_GET['yerror'] . "</div>";
    }

    if (isset($_GET['success'])) {
        $url = plugin_dir_url(__FILE__) . "/uploads/" . $_GET['success'] . ".png";
        $dataoutput.= youinpaint_player($url);
    } else {
        $dataoutput.= youinpaint_input();
    }

    return $dataoutput;
}

function deactivate_plugin(): void
{
    $page_id = get_option('fl_youinpaint_option');
    wp_delete_post($page_id);

    global $wpdb;

    // Define the table name
    $table_name = $wpdb->prefix . 'youinpaint';

    // Define the SQL query
    $sql = "DROP TABLE $table_name;";

    // Execute the query
    $wpdb->query($sql);

    // Get all files in the folder
    $files = glob(uploaddir . '*');

    // Iterate over each file and delete it
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file); // Delete the file
        }
    }

}

register_activation_hook( __FILE__, 'generate_posts_on_activation' );
register_deactivation_hook( __FILE__, 'deactivate_plugin' );

// Allow subscribers to see Private posts and pages
$subRole = get_role( 'subscriber' );
$subRole->add_cap( 'read_private_posts' );
$subRole->add_cap( 'read_private_pages' );


function generate_posts_on_activation(): void
{
    createPictureTable();

    require_once(ABSPATH . 'wp-content/plugins/youinpaint/includes/custom-pages.php');

    // Create an array of post data for the feed of pictures
    $youinpaint_post = array(
        'post_title' => 'YOU IN PAINT? YES YOU CAN!',
        'post_content' => "[youinpaint]",
        'post_status' => 'publish',
        'post_type' => 'page'
    );

    // Insert the post into the database
    $picture_feed_id = wp_insert_post($youinpaint_post);
    update_option('fl_youinpaint_option',$picture_feed_id);

}

function createPictureTable()
{
    global $wpdb;

    // Define the table name
    $table_name = $wpdb->prefix . 'youinpaint';

    // Define the SQL query
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    username text NOT NULL,
    name text NOT NULL UNIQUE,
    post_date datetime NOT NULL,
    UNIQUE KEY id (id)
  );";

    // Include the WordPress upgrade functions
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    // Create the table
    dbDelta($sql) or die ("databse no created");
}
require_once(ABSPATH . 'wp-content/plugins/facelog/includes/custom-pages.php');
add_shortcode('youinpaint', 'youinpaint_shortcode');
