<?php

$db = new PDO('sqlite:cred_info.sqlite3'); //new SQLite3('cred_info.sqlite3');
$db->setAttribute(PDO::ATTR_ERRMODE, 
					PDO::ERRMODE_EXCEPTION);
					


if (isset($_GET["submit"]) )
{	
	$submit=$_GET["submit"];

	if ( $submit == "getUserData" )
	{
		$query = 'SELECT user_name, user_country, secret, user_school, user_email, is_admin FROM users';
		$stmt = $db->prepare($query);
		$stmt->execute();
		
		$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$i = 0;
		foreach( $users as $row ) 
		{
			$user_name[ $i ] =  $row['user_name'];
			$user_email[ $i ] =  $row['user_email'];
			$user_country[ $i ] =  $row['user_country'];
			$user_school[ $i ] =  $row['secret'];
			$user_school[ $i ] =  $row['user_school'];
			$user_admin[ $i ] =  $row['is_admin'];
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
			$stud_grade[ $i ] =  $row['grade'];
			$stud_class[ $i ] =  $row['class'];
			$stud_story[ $i ] =  $row['story'];
			$guidelines[ $i ] =  $row['guidelines'];
		}
				
		echo json_encode( $student_data, JSON_NUMERIC_CHECK );
	}
	if ( $submit == "getStoryData" )
	{
			session_start(); 

			$query = 'SELECT plots FROM  story ORDER BY RANDOM() LIMIT 1'; //FROM plots, characters, settings, plots, endings 
			$stmt = $db->prepare($query);
			$categories = [ 'plots', 'characters', 'settings', 'endings' ];
			$stmt->execute();
			
			$data = []; $i = 0;
			foreach( $categories as $cat ) 
			{
				$query1 = 'SELECT ' . $cat .' FROM story ORDER BY RANDOM() LIMIT 1';
				$stmt = $db->prepare($query1);
				$stmt->execute();
				$temp = $stmt->fetch(PDO::FETCH_ASSOC);
				$data[ $i ] = $temp;
				$i += 1;	
			}
			
	
			$story_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
			$query2 = 'SELECT Mystery FROM img ORDER BY RANDOM() LIMIT 1';
			$stmt2 = $db->prepare($query2);
			$stmt2->execute();
			$img = $stmt2->fetch(PDO::FETCH_ASSOC);
	
			array_push($data, $img);
		
			$i = 0;

			foreach( $story_data as $row ) 
			{
				$stud_name[ $i ] =  $row['name'];
				$stud_grade[ $i ] =  $row['grade'];
				$stud_class[ $i ] =  $row['class'];
				$stud_story[ $i ] =  $row['story'];
			}
			
			echo json_encode( $data, JSON_NUMERIC_CHECK );
	}
}
else
{
	//echo 'Sub: '. $submit;
}
if (isset($_GET["action"]) && $_GET["action"] == "submit_story")  
{
	$q_sec =  'SELECT secret FROM users';
	$stmt = $db->prepare($q_sec);
	$stmt->execute();
	$secrets =  $stmt->fetchAll(PDO::FETCH_COLUMN);
	
	$name = htmlentities($_POST['stud_name'], ENT_QUOTES);
	$class = htmlentities($_POST['stud_class'], ENT_QUOTES);
	$story = htmlentities($_POST['stud_story'], ENT_QUOTES);
	$secret = htmlentities($_POST['stud_secret'], ENT_QUOTES);
	$guidelines = htmlentities($_POST['guidelines'], ENT_QUOTES);

	if( in_array($secret, $secrets) // don't allow random users to submit story into database
	  && $story != ''
		&& $class != '' )
	{
		$query = 'INSERT INTO "students" ("name","class","story","secret","guidelines")  VALUES ( ?, ?, ?, ?, ? )';
		$data = array( $name, $class,$story ,$secret, $guidelines);

 $data[ 0 ] = mb_convert_encoding( $data[ 0 ], 'UTF-8', 'HTML_ENTITIES');
 $data[ 1 ] = mb_convert_encoding( $data[ 1 ], 'UTF-8', 'HTML_ENTITIES');
 $data[ 2 ] = mb_convert_encoding( $data[ 2 ], 'UTF-8', 'HTML_ENTITIES');
 $data[ 3 ] = mb_convert_encoding( $data[ 3 ], 'UTF-8', 'HTML_ENTITIES');
 $data[ 4 ] = mb_convert_encoding( $data[ 4 ], 'UTF-8', 'HTML_ENTITIES');


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
}

if ( isset($_GET["action"]) && $_GET["action"] == "getStoryData" )
{
	session_start(); 

	$query = 'SELECT * FROM plots, characters, settings, plots, endings FROM story  ORDER BY RANDOM() LIMIT 1';
	$stmt = $db->prepare($query);
	$stmt->execute();
	$story_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	$query2 = 'SELECT * FROM filename FROM img ORDER BY RANDOM() LIMIT 1';
	$stmt2 = $db->prepare($query2);
	$stmt2->execute();
	$img = $stmt2->fetchAll(PDO::FETCH_ASSOC);
		
	array_push($story_data, $img);

	$i = 0;
	error_log($story_data, 0);
	foreach( $story_data as $row ) 
	{
		$stud_name[ $i ] =  $row['name'];
		$stud_grade[ $i ] =  $row['grade'];
		$stud_class[ $i ] =  $row['class'];
		$stud_story[ $i ] =  $row['story'];
	}
			
	echo json_encode( $story_data ); //, JSON_NUMERIC_CHECK );
}

?>
