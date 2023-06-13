<?php
// TODO: Cal implementar tota la funcionalitat

function facelog_dbget($username) {
    global $wpdb;
    $tablename = $wpdb->prefix . 'faceLog';
    //$secure_username = $wpdb->_real_escape( $username );

    $total = $wpdb->get_results("SELECT COUNT(*) as total FROM wp_faceLog") or die ("error COUNT");
    if($total[0]->total > 0) {
        $sql = "SELECT * FROM $tablename";
        $result = $wpdb->get_results($sql) or die ($sql);
        # log the result in the console
        # error_log('result: '.var_dump($result));
        return $result;
    }
    return null;
    
}