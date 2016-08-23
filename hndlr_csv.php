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

function import_csv_to_sqlite(&$pdo, $csv_path, $csv_filename,	$options = array(
					'table' => 'story',
					'fields' => array(
						"characters",// => $characters,
						"settings", //=> $settings,
						"plots", //=> $plots,
						"endings", //=> $endings,
						"secret", 
						"filename"
					)
))
{
	global $secret;
	extract($options);
	
	if (($csv_handle = fopen($csv_path, "r")) === FALSE)
		throw new Exception('Cannot open CSV file  ' . $csv_path[0] );
		
	if(!isset($delimiter))
		$delimiter = ';';
		
	if(!isset($table))
		$table = preg_replace("/[^A-Z0-9]/i", '', basename($csv_path));
	
	if(!isset($fields)){
		$fields = array_map(function ($field){
			return strtolower(preg_replace("/[^A-Z0-9]/i", '', $field));
		}, fgetcsv($csv_handle, 0, $delimiter));
	}
	
/* 	$create_fields_str = join(', ', array_map(function ($field){
		return "$field TEXT";
	}, $fields)); */
	
	$pdo->beginTransaction();
	
	// $create_table_sql = "CREATE TABLE IF NOT EXISTS $table ($create_fields_str)";
	// $pdo->exec($create_table_sql);

	$insert_fields_str = join(', ', $fields);
	$insert_values_str = join(', ', array_fill(0, count($fields),  '?'));
	$insert_sql = "INSERT INTO $table ($insert_fields_str) VALUES ($insert_values_str)";
	$insert_sth = $pdo->prepare($insert_sql);
	
	$inserted_rows = 0;
	while (($data = fgetcsv($csv_handle, 0, $delimiter)) !== FALSE) {
		// remove first row
		if( $inserted_rows != 0 || in_array('', $data) 	)
		{
			array_push($data, $secret);
			array_push($data, $csv_filename);
			$insert_sth->execute($data);
		}
		$inserted_rows++;
	}
	
	$pdo->commit();
	
	fclose($csv_handle);
	
	return array(
			'table' => $table,
			'fields' => $fields,
			'insert' => $insert_sth,
			'inserted_rows' => $inserted_rows
		);

}
function delete_csv_from_db( &$pdo, $csv_filename )
{
	$query = "DELETE FROM story WHERE filename = '$csv_filename' ";
  $delete_sth = $pdo->prepare($query);
	$delete_sth->execute();
}

class CustomUploadHandler1 extends UploadHandler {

	 
    protected function get_user_id() {
        @session_start();
        return 'csv/' . $_SESSION['secret']; // directory for storage
    }
	protected function handle_form_data($file, $index) {
		 @session_start();
		
		if(isset( $_POST['file']))
			$_SESSION['filename'] = $_POST['file'];//$_POST['name']; //$file;// Handle form data, e.g. $_POST['description'][$index]
		if(isset($_POST['destroy']))
			$_SESSION['destroy_f'] = $_POST['destroy'];
			//	import_csv_to_sqlite( $db, $csv );
	}
}

$upload_handler1 = new CustomUploadHandler1(array(
    'user_dirs' => true,
'accept_file_types' => '/\.(csv)$/i'
));

$secret =  $_SESSION['secret'];

if( $_SERVER['REQUEST_METHOD'] === 'DELETE' )
{
	$csv_filename =  $_SESSION['filename'];
	$csv=  '/var/www/files/csv/' . $_SESSION['secret'] . '/' . $csv_filename;

	delete_csv_from_db( $db, $csv_filename );
}
else if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$csv_filename =  $_SESSION['filename'];
	$csv=  '/var/www/files/csv/' . $_SESSION['secret'] . '/' . $csv_filename;

	import_csv_to_sqlite( $db, $csv, $csv_filename );
}