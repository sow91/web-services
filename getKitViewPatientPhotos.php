<?php

// json response
$response = array();

# check patient_id
if (isset($_GET['patientId'])){
	# get fields
	$id_patient = $_GET['patientId'];
	
	
	# include de connexion file
	require "db_connect.php";
  
	# connexion to DB
	$conn = new DB_CONNECT();
	
	# sql query

	$sql = "select id_image, ima_libelle, ima_nom from image im where im.id_personne = $id_patient ";
	# execute query
		$response['images'] = array();
	 $result = ibase_query($sql) or die(ibase_errmsg());
	
	// number of line
	 $nombreLigne = 0;
      
       
	 	while ($row = ibase_fetch_row($result)) {
	 		
	 		$nombreLigne++;
	 		$image = array();
	 		$image['id_image'] = utf8_encode($row[0]);
	 		$image['ima_libelle'] = utf8_encode($row[1]);
	 		$image['ima_nom'] = utf8_encode($row[2]);
	 		
           	
           	array_push($response['images'], $image);
           
	       

	}
	 if ($nombreLigne != 0) {
	       $response['success'] = 1;
	      
	       //convert array to json
	       echo (json_encode($response));
           
             
	       }
	       else{
	       	$response['success'] = 0;
	       //convert array to json
            echo (json_encode($response));
	       }



	}
	
?>