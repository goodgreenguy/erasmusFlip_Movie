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

class CustomUploadHandler2 extends UploadHandler {
    protected function get_user_id() {
        @session_start();
        return 'img/' . $_SESSION['secret']; //session_id();
    }
}

$upload_handler2 = new CustomUploadHandler2(array(
    'user_dirs' => true
));


//$upload_handler = new UploadHandler();
