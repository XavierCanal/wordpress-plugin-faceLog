<?php

require_once __DIR__ . '/../../../wp-load.php';

/** Sets up the WordPress Environment. */
define('WP_USE_THEMES', false); /* Disable WP theme for this file (optional) */
$uploaddir = __DIR__.'/uploads/images';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $check = getimagesize($_FILES["imageupload"]["tmp_name"]);
    if($check !== false) {
        print_r($_POST);
        
        if($_POST['date'] != null) {
            $date = $_POST['date'];
        } else {
            $date = date('d-m-y h:i:s');
        }

        $uploadfile = $uploaddir ."/". date('Y-m-d'). "-" . wp_get_current_user()->user_login.".jpg";

        if(move_uploaded_file($_FILES['imageupload']['tmp_name'], $uploadfile)) {
            echo "File valid and uploaded";
        } else {
            echo "Upload failed";
        }

        global $wpdb;
        $tablename = $wpdb->prefix . 'faceLog';


        $wpdb->insert($tablename, array('username' => wp_get_current_user()->user_login, 'imatge' => "..\\wp-content\\plugins\\facelog\\uploads\\images\\".date('Y-m-d'). "-" . wp_get_current_user()->user_login, 'post_date' => $date));
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }
    

} else {
    echo "ERROR";
}