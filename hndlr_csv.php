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
						"characters",
						"settings", 
						"plots", 
						"endings",
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
	
	$pdo->beginTransaction();
	
	$insert_fields_str = join(', ', $fields);
	$insert_values_str = join(', ', array_fill(0, count($fields),  '?'));
	$insert_sql = "INSERT INTO $table ($insert_fields_str) VALUES ($insert_values_str)";
	$insert_sth = $pdo->prepare($insert_sql);
	
	$inserted_rows = 0;
	while (($data = fgetcsv($csv_handle, 0, $delimiter)) !== FALSE) {
		// remove first row
		$data[ 1 ] = w1250_to_utf8($data[ 1 ]); //convert to UTF-8
		$data[ 2 ] = w1250_to_utf8($data[ 2 ]); //convert to UTF-8
		$data[ 3 ] = w1250_to_utf8($data[ 3 ]); //convert to UTF-8
		$data[ 0 ] = w1250_to_utf8($data[ 0 ]); //convert to UTF-8

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

function w1250_to_utf8($text) {
    // map based on:
    // http://konfiguracja.c0.pl/iso02vscp1250en.html
    // http://konfiguracja.c0.pl/webpl/index_en.html#examp
    // http://www.htmlentities.com/html/entities/
    $map = array(
        chr(0x8A) => chr(0xA9),
        chr(0x8C) => chr(0xA6),
        chr(0x8D) => chr(0xAB),
        chr(0x8E) => chr(0xAE),
        chr(0x8F) => chr(0xAC),
        chr(0x9C) => chr(0xB6),
        chr(0x9D) => chr(0xBB),
        chr(0xA1) => chr(0xB7),
        chr(0xA5) => chr(0xA1),
        chr(0xBC) => chr(0xA5),
        chr(0x9F) => chr(0xBC),
        chr(0xB9) => chr(0xB1),
        chr(0x9A) => chr(0xB9),
        chr(0xBE) => chr(0xB5),
        chr(0x9E) => chr(0xBE),
        chr(0x80) => '&euro;',
        chr(0x82) => '&sbquo;',
        chr(0x84) => '&bdquo;',
        chr(0x85) => '&hellip;',
        chr(0x86) => '&dagger;',
        chr(0x87) => '&Dagger;',
        chr(0x89) => '&permil;',
        chr(0x8B) => '&lsaquo;',
        chr(0x91) => '&lsquo;',
        chr(0x92) => '&rsquo;',
        chr(0x93) => '&ldquo;',
        chr(0x94) => '&rdquo;',
        chr(0x95) => '&bull;',
        chr(0x96) => '&ndash;',
        chr(0x97) => '&mdash;',
        chr(0x99) => '&trade;',
        chr(0x9B) => '&rsquo;',
        chr(0xA6) => '&brvbar;',
        chr(0xA9) => '&copy;',
        chr(0xAB) => '&laquo;',
        chr(0xAE) => '&reg;',
        chr(0xB1) => '&plusmn;',
        chr(0xB5) => '&micro;',
        chr(0xB6) => '&para;',
        chr(0xB7) => '&middot;',
        chr(0xBB) => '&raquo;',
    );
    return html_entity_decode(mb_convert_encoding(strtr($text, $map), 'UTF-8', 'ISO-8859-2'), ENT_QUOTES, 'UTF-8');
}

