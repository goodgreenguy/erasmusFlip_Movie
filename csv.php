<?php
$target_dir = "files/csv/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
	
	$mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv', 'application/octet-stream');
		if(in_array($_FILES['fileToUpload']['type'],$mimes)){
			$uploadOk = 1;
		} else {
			$uploadOk = 0;
			//die("Sorry, file type not allowed");
		}
	
	
    // $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    // if($check !== false) {
        // echo "File is an image - " . $check["mime"] . ".";
        // $uploadOk = 1;
    // } else {
        // echo "File is not an image.";
        // $uploadOk = 0;
    // }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if( $fileType != "csv" ) {
    echo "Sorry, only CSV files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>