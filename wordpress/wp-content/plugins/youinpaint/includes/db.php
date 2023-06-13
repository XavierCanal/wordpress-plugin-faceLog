<?php
/**
 * Retorna una llista de quades de la base de dades
 * @return array Llista de quadres
 */
function youinpaint_history(){
    $current_user = wp_get_current_user()->user_login;
    global $wpdb;
    $tablename = $wpdb->prefix . 'youinpaint';
    $total = $wpdb->get_results("SELECT COUNT(*) as total FROM wp_youinpaint WHERE username = '$current_user'") or die ("error COUNT");
    if($total[0]->total > 0) {
        $sql = "SELECT * FROM $tablename WHERE username = '$current_user'";
        $result = $wpdb->get_results($sql) or die ($sql);
        # log the result in the console
        # error_log('result: '.var_dump($result));
        return $result;
    }
    return [];
 }

