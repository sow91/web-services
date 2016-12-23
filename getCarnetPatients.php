<?php

 # tableau de reponse JSON 
$response = array();
# verifier les données envoyées par la method GET
if (isset($_GET['praticienId'])) {
	# get praticien Id
	$praticienId = $_GET['praticienId'];
	
	
	# include connexion file
	require "db_connect.php";
  
	# DB connexion
	$conn = new DB_CONNECT();
	
	#query sql

	$sql = "select per_nom, per_prenom, per_telprinc, per_email, per_adr1 from personne pers, patient pat where pers.id_personne=pat.id_personne and pat.PER5_ID_PERSONNE='$praticienId'";
	# execute query
	 $result = ibase_query($sql) or die(ibase_errmsg());
	 $nombreLigne = 0;
	     
          $response['personnes'] = array();
	 	while ($row = ibase_fetch_row($result)) {
	 		// count the number of line
	 		$nombreLigne++;
	 		#print_r($row);
	 		
           	// get fields

           	// table of person
           	$personne = array();
           	$personne['per_nom'] = utf8_encode(trim($row[0]));
          	$personne['per_prenom']= utf8_encode(trim($row[1]));
            $personne['per_telprinc']= utf8_encode(trim($row[2]));
            $personne['per_email']= utf8_encode(trim($row[3]));
            $personne['per_adr1']= utf8_encode(trim($row[4]));
            
                   
           
            array_push($response["personnes"], $personne);
                 
	       }
	       if ($nombreLigne != 0) {
	       $response['success'] = 1;
	       //on convertit le tableau en JSON
             echo (json_encode($response));
	       }
	       else{
	       	$response['success'] = 0;
	       //on convertit le tableau en JSON
             echo (json_encode($response));
	       }

	       

	 
	}





           
           
	
?>