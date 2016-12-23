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

	$sql = "select id_image, ima_libelle, ima_nom, ima_date from image im where im.id_personne = $id_patient ";
	# execute query
		$response['images'] = array();
	 $result = ibase_query($sql) or die(ibase_errmsg());
	
	// number of line
	 $nombreLigne = 0;
      
       
	 	while ($row = ibase_fetch_row($result)) {
	 		
	 		$nombreLigne++;
	 		$image = array();
	 		$image['id_image'] = utf8_encode(trim($row[0]));
	 		$image['ima_libelle'] = utf8_encode(trim($row[1]));

	 		$nomImg = utf8_encode(trim($row[2]));
	 		$cheminImage = explode("\\", $nomImg);
	 		$image['ima_nom'] = $cheminImage[3];



	 		$dateImg = utf8_encode(trim($row[3]));
           	$jour = substr($dateImg, "8", "2");
			$mois = substr($dateImg, "5", "2");
			$annee = substr($dateImg, "0", "4");
			$heure = substr($dateImg, "11", "5");
	 		$image['ima_date'] = $jour."/".$mois."/".$annee;
	 		
           	
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