<?php
/**
 * Plugin Name: FaceLog Plugin
 * Plugin URI: http://boscdelacoma.cat
 * Description: Pràctica MP07.
 * Version: 0.1
 * Author: ELTEUNOM
 * Author URI:  http://boscdelacoma.cat
 **/

 const FACELOG_DB_VERSION = '1.0';
 const FACELOG_VERSION= '1.0';

 function deactivate_plugin() {
   $page_id = get_option('fl_picture_feed_option');
   wp_delete_post($page_id);
   $page_id = get_option('fl_form_post');
   wp_delete_post($page_id);
   
   global $wpdb;

   // Define the table name
   $table_name = $wpdb->prefix . 'faceLog';
 
   // Define the SQL query
   $sql = "DROP TABLE $table_name;";
 
   // Execute the query
   $wpdb->query($sql);

}
register_activation_hook( __FILE__, 'generate_posts_on_activation' );
register_deactivation_hook( __FILE__, 'deactivate_plugin' );
 
 // Allow subscribers to see Private posts and pages
 $subRole = get_role( 'subscriber' );
 $subRole->add_cap( 'read_private_posts' );
 $subRole->add_cap( 'read_private_pages' );
 

 function facelog_example(){
    return "Hola a tothom!";
 }

 add_shortcode('facelog', 'facelog_example');

 function generate_posts_on_activation() {
  createPostsTable();

  require_once(ABSPATH . 'wp-content/plugins/facelog/includes/custom-pages.php');

   // Create an array of post data for the feed of pictures
   $picture_feed_post = array(
     'post_title' => 'Picture Feed',
     'post_content' => "[facelog_gallery]",
     'post_status' => 'publish',
     'post_type' => 'page'
   );
 
   // Insert the post into the database
   $picture_feed_id = wp_insert_post($picture_feed_post);
   update_option('fl_picture_feed_option',$picture_feed_id);
 
   require_once(ABSPATH . 'wp-content/plugins/facelog/includes/custom-pages.php');
   $content = facelog_addlog();

   // Create an array of post data for the form
   $form_post = array(
     'post_title' => 'Form_addLog',
     'post_content' => $content,
     'post_status' => 'publish',
     'post_type' => 'page'
   );   
   $form_id = wp_insert_post($form_post);
   update_option('fl_form_post',$form_id);


 }

 function createPostsTable() {
  global $wpdb;

  // Define the table name
  $table_name = $wpdb->prefix . 'faceLog';

  // Define the SQL query
  $sql = "CREATE TABLE IF NOT EXISTS $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    username text NOT NULL,
    imatge text NOT NULL UNIQUE,
    post_date datetime NOT NULL,
    UNIQUE KEY id (id)
  );";

  // Include the WordPress upgrade functions
  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

  // Create the table
  dbDelta($sql) or die ("databse no created");
 }

require_once(ABSPATH . 'wp-content/plugins/facelog/includes/custom-pages.php');
add_shortcode("facelog_gallery", "facelog_gallery");