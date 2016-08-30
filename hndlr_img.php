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

$db = new PDO('sqlite:cred_info.sqlite3'); 
$db->setAttribute(PDO::ATTR_ERRMODE, 
			  PDO::ERRMODE_EXCEPTION);

function import_img_to_sqlite(&$pdo, $img_path, $img_filename )
{
		global $secret;
		error_log($img_filename);
	//	$pdo->beginTransaction();
		$insert_sql = "INSERT INTO img ('Mystery') VALUES ('$img_filename')";
	try
	{
		$insert_sth = $pdo->prepare($insert_sql);
		$insert_sth->execute();
	}
	catch(PDOException $e) 
	{
		// Print PDOException message
		$exc = $e->getMessage();
		error_log($exc);
	}
}
				
				
				
class CustomUploadHandler2 extends UploadHandler {
    protected function get_user_id() {
        @session_start();
        return 'img/' . $_SESSION['secret'];
    }
		protected function handle_form_data($file, $index) {
		 @session_start();
		
		if(isset( $_POST['file_img']))
			$_SESSION['filename_img'] = $_POST['file_img'];
		if(isset($_POST['destroy']))
			$_SESSION['destroy_f'] = $_POST['destroy'];
		}
}

$upload_handler2 = new CustomUploadHandler2(array(
    'user_dirs' => true
));

function delete_img_from_db( &$pdo, $img_filename )
{
	$query = "DELETE FROM img WHERE Mystery = '$img_filename'";
  $delete_sth = $pdo->prepare($query);
	$delete_sth->execute();
}

$secret =  $_SESSION['secret'];

if( $_SERVER['REQUEST_METHOD'] === 'DELETE' )
{
	$img_filename =  $_SESSION['filename_img'];
	$img=  '/var/www/files/img/' . $_SESSION['secret'] . '/' . $img_filename;

	delete_img_from_db( $db, $img_filename );
}
else if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$img_filename =  $_SESSION['filename_img'];
	$img=  '/var/www/files/img/' . $_SESSION['secret'] . '/' . $img_filename;

	import_img_to_sqlite( $db, $img, $img_filename );
}