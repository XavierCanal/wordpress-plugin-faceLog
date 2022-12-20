<?php
// TODO: Cal implementar tota la funcionalitat

function facelog_dbget($username) {
    global $wpdb;
    $tablename = "'".$wpdb->prefix . 'faceLog'."'";
    //$secure_username = $wpdb->_real_escape( $username );

    $result = $wpdb->get_results ( " SELECT * FROM $tablename WHERE username = $username " );
    return $result;
}