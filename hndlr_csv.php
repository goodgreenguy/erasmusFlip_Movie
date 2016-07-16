<?php
/*
 * jQuery File Upload Plugin PHP Example
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

error_reporting(E_ALL | E_STRICT);
require('UploadHandler.php');

session_start();

class CustomUploadHandler1 extends UploadHandler {
    protected function get_user_id() {
        @session_start();
        return 'csv/' . $_SESSION['secret']; //session_id();
    }
}

$upload_handler1 = new CustomUploadHandler1(array(
    'user_dirs' => true,
'accept_file_types' => '/\.(csv)$/i'//'/.+$/i', 
));

// if($_POST) {
	// session_start();
    // $allowed = array('csv' );

    // if(isset($_FILES['uploadctl']) && $_FILES['uploadctl']['error'] == 0){

        // $extension = pathinfo($_FILES['uploadctl']['name'], PATHINFO_EXTENSION);

        // if(!in_array(strtolower($extension), $allowed)){
            // echo '{"status":"error"}';
            // exit;
        // }

        // if(move_uploaded_file($_FILES['uploadctl']['tmp_name'], "/csv/" . $_SESSION['secret'] . "/." . $extension)){
            // echo '{"status":"success"}';
            // exit;
        // }
        // echo '{"status":"error"}';
    // }
    // exit();
// }
//$upload_handler = new UploadHandler();
