<?php
require_once "db.php";


/**
 * Funció que retorna el codi HTML del player de YouInPaint
 * @param string $paintingImg URL de la imatge del quadre superior
 */
function youinpaint_player($paintingImg)
{
    return "
   <div class='youinpaint-container'>
       <video id='video' class='youinpaint-video'></video>
       <img id='overimage' alt='overimage' src='$paintingImg' class='youinpaint-over'>
       <div class='button-container'>
   
           <div class='vertical-direction-buttons'>
               <button id='moveLeft' class='btn btn-default btn-sm'><span class='glyphicon glyphicon-arrow-left'></span></button>
               <div class='horizontal-direction-buttons'>
                   <button id='moveUp' class='btn btn-default btn-sm'><span class='glyphicon glyphicon-arrow-up'></span></button>
                   <button id='moveDown' class='btn btn-default btn-sm'><span class='glyphicon glyphicon-arrow-down'></span></button>
               </div>
               <button id='moveRight' class='btn btn-default btn-sm'><span class='glyphicon glyphicon-arrow-right'></span></button>
           </div>
   
           <div class='zoom-buttons'>
               <button id='zoomIn' class='btn btn-default btn-sm'><span class='glyphicon glyphicon-plus'></span></button>
               <button id='zoomOut' class='btn btn-default btn-sm'><span class='glyphicon glyphicon-minus'></span></button>
           </div>
       </div>
   </div>
   
   <canvas id='canvas' style='display: none;'></canvas>
   <script src='" . plugin_dir_url(__FILE__) . "../assets/js/youinpaint.js'></script>
   ";
}

/**
 * Funció que retorna el codi HTML del formulari de YouInPaint
 */
function youinpaint_input()
{
   $llista = "";
   $llista_bd = youinpaint_history();
   foreach ($llista_bd as $key => $value) {
       $img_url = plugin_dir_url(__FILE__) . "../uploads/orig/" . $value->name . ".jpg";
       $llista .= "<div class='youinpaint-preview'><a href='?success=$value->name'><img src='$img_url'></a></div>";
   }

    $form = plugin_dir_url(__FILE__) . "../upload.php";
    $data  = "<form action='$form' method='post' enctype='multipart/form-data'>
               <label for='fileUpload'>Selecciona una imatge per pujar:</label>
               <input type='file' name='fileUpload' id='fileUpload'>
               <input type='submit' value='Pujar'>
            </form>";
    
    if($llista){
        $data .= "<p>O bé, escull una imatge de la llista:</p>
                    <div class='youinpaint-llista'>
                    $llista
                </div>";
    }

    return $data;
            
}
