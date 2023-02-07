<?php
require_once "db.php";

/**
 * Crea la galeria dels registres de cares per cada usuari
 * @return string
 */

if (isset($_POST['reloadFaceLog'])) {
    facelog_gallery();
}
function facelog_gallery() : string
{
    require_once "db.php";
    $plugin_js = plugins_url( 'facelog/assets/js/render.js');

    $output = "<div class='facelog_gallery'>";

    $users = get_users(); // Array d'objectes WP_User
    $jsdata = [];

    //$rutaImatges = "../uploads/images/";
    foreach ( $users as $user ) {
        global $wpdb;
        $tablename = $wpdb->prefix . 'faceLog';
        $output .= 'prefix db: '.$wpdb->prefix . 'faceLog';
        $output .= 'login: '.$user->user_login;

        $data = facelog_dbget($user->user_login); // Funció que em retorna les dades donat un usuari
        if($data != null) {
            $jsdata[$user->user_login]=[];
            foreach($data as $row) {
                $output .= "inside if";

                $output .= "<div class='facelog_box' id='facelog_user_$user->user_login'>";
                $output .= "<h2> $user->user_login </h2>";
                $output .= "<canvas id='facelog_canvas_$user->user_login' width='300' height='500'> </canvas>";
                $output .= "<div class='info' id='facelog_info_$user->user_login'></div>";
                $output .= "</div>";
                $imatge = $row->imatge.".jpg";
                error_log('imatge: '.var_dump($imatge));


                $jsdata[$user->user_login][]= ["img" => $imatge, "date" => $row->post_date];
            }
        } else {
            $output = "DATA NULL";
        }

    }

    $output .= "</div>";
    $output .= "<script> let facelog_data = " . json_encode($jsdata) ."</script>";
    $rand = rand();
    $output .= "<script src='$plugin_js' type='text/javascript' />";
    require_once(ABSPATH . 'wp-content/plugins/facelog/includes/custom-pages.php');

    return '
    
    <form action="" method="post" enctype="multipart/form-data">
        <div class="facelog_upload">
            <input class="hidden" type="hidden" name="reloadFaceLog">
            <input type="submit" value="Reload" name="submit">
        </div>
    </form>

    '.$output;
}



/**
 * Crea el formulàri per afegir el log diàri
 * @return string
 */
function facelog_addlog() : string
{
    $process = plugin_dir_url( __DIR__. ".." ) . "/upload.php";
    $msg = $_GET["err"] ?? "";
    $msg .= isset($_GET["ok"]) ? "Ok!" : "";
    $msg_class =  isset($_GET["ok"]) ? "ok" : "error";

    return '
    
    <form class="facelog_form" action="'.$process.'" method="post" enctype="multipart/form-data">
        Hola '.wp_get_current_user()->user_login.', puja el teu log
        <select class="inline-input" name="today" id="date-today" onchange="changeDateSelect()" required>
            <option value="1">d\'avui</option>
            <option value="0">d\'un altre dia</option>
        </select>:
        <div class="facelog_date" id="facelog_setdate" style="display: none">
            <label> Data: </label><input name="date" class="inline-input" type="date">
        </div>

        <div class="facelog_upload">
            <input class="clear-input" type="file" name="imageupload" id="imatgeupload" required>
            <input type="submit" value="Puja" name="submit">
        </div>
    </form>
     <div class="facelog_message"><span class="'.$msg_class.'">'. $msg .'</span></div>

    <script>
    window.history.replaceState(null, null, window.location.pathname)
    function changeDateSelect(){
        let sel = document.getElementById("date-today")
        document.getElementById("facelog_setdate").style.display = sel.selectedIndex === 0 ? "none" : ""
    }
    </script>
    ';
}