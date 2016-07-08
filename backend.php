<?php

/* $target_dir = "files/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "csv") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
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
} */

$db = new PDO('sqlite:cred_info.sqlite3'); //new SQLite3('cred_info.sqlite3');
$db->setAttribute(PDO::ATTR_ERRMODE, 
					PDO::ERRMODE_EXCEPTION);
					


if (isset($_GET["submit"]) )
{	
	$submit=$_GET["submit"];

	if ( $submit == "getUserData" )
	{
		$query = 'SELECT * FROM users';
		$stmt = $db->prepare($query);
		$stmt->execute();
		
		$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$i = 0;
		foreach( $users as $row ) 
		{
			$user_name[ $i ] =  $row['user_name'];
			$user_email[ $i ] =  $row['user_email'];
			$user_country[ $i ] =  $row['user_country'];
			$user_school[ $i ] =  $row['user_school'];
		}
		
		
		$i=0;
		
		/* while ($row = $users->fetchArray()) 
		{ 
			$user_name[ $i ] =  $row['user_name'];
			$user_email[ $i ] =  $row['user_email'];
			$user_country[ $i ] =  $row['user_country'];
			$user_school[ $i ] =  $row['user_school'];
			$i += 1; 
		} */
		echo json_encode( $users, JSON_NUMERIC_CHECK );

		//echo json_encode( array("user_id" => $user_id, "user_name" => $user_name, "user_email" => $user_email, "user_country" => $user_country, "user_school" => $user_school ));
	}
	if ( $submit == "getStudData" )
	{
		session_start(); 

		$query = 'SELECT * FROM students WHERE "secret" = :secret';
		$stmt = $db->prepare($query);

		$secret = $_SESSION['secret'];

		$stmt->bindParam(':secret', $secret);
		
		$stmt->execute();
		
		$student_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$i = 0;

		foreach( $student_data as $row ) 
		{
			$stud_name[ $i ] =  $row['name'];
			$stud_country[ $i ] =  $row['country'];
			$stud_school[ $i ] =  $row['school'];
			$stud_class[ $i ] =  $row['class'];
			$stud_story[ $i ] =  $row['story'];
		}
				
		echo json_encode( $student_data, JSON_NUMERIC_CHECK );
	}
}
else
{
	//echo 'Sub: '. $submit;
}
if (isset($_GET["action"]) && $_GET["action"] == "submit_story")  
{
	$name = htmlentities($_POST['stud_name'], ENT_QUOTES);
	$class = htmlentities($_POST['stud_class'], ENT_QUOTES);
	$story = htmlentities($_POST['stud_story'], ENT_QUOTES);
	$secret = htmlentities($_POST['stud_secret'], ENT_QUOTES);
	
	
	$query = 'INSERT INTO "students" ("name","class","story","secret")  VALUES ( ?, ?, ?, ? )';
	$data = array( $name, $class,$story ,$secret);
	try
	{
		$stmt = $db->prepare($query);
	/* 	$stmt->bindParam(':name', $name);
		$stmt->bindParam(':school', $school);
		$stmt->bindParam(':class', $class);
		$stmt->bindParam(':country', $country);
		$stmt->bindParam(':story', $story); */

		$stmt->execute( $data );
	}
	catch(PDOException $e) 
	{
		// Print PDOException message
		$exc = $e->getMessage();
	}
}



?>
