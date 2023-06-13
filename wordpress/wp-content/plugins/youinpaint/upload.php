<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../wp-load.php';
require_once "includes/db.php";

/** Sets up the WordPress Environment. */
define('WP_USE_THEMES', false); /* Disable WP theme for this file (optional) */

$uploaddir = __DIR__.'/uploads/orig';


function face_detection($file)
{
    $url = 'http://coma.boscdelacoma.cat:8000/';
    $api_key = '3605527e-480c-4e59-a469-c246210d4cd9';

    $headers = array(
        'Content-Type: application/json',
        'x-api-key: ' . $api_key
    );

    $data = array(
        'file' => $file
    );

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($httpCode === 200) {
        // Face detected
        return true;
    } else {
        // No face detected or error occurred
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    try {
        $check = getimagesize($_FILES["fileUpload"]["tmp_name"]);
        if($check !== false) {
            print_r($_POST);

            $date = date('Y-m-d H:i:s');

            $uploadfile = $uploaddir ."/". date('Y-m-d'). "-" . wp_get_current_user()->user_login.".jpg";

            if(move_uploaded_file($_FILES['fileUpload']['tmp_name'], $uploadfile)) {
                if (face_detection($uploadfile)) {
                } else {
                    return "This image does not contain a face";
                }
            } else {
                return "ERROR";
            }

            global $wpdb;
            $tablename = $wpdb->prefix . 'youinpaint';


            $wpdb->insert($tablename, array('username' => wp_get_current_user()->user_login, 'name' => date('Y-m-d'). "-" . wp_get_current_user()->user_login, 'post_date' => $date));
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
} else {
    echo "ERROR";
}

// return to the page
header("Location: " . $_SERVER['HTTP_REFERER']);