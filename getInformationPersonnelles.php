<?php

 # tableau de reponse JSON 
 $response = array();
 # verifier les données envoyées par la method GET
if (isset($_GET['patientId'])) {
	# get patient id
	$patientId = $_GET['patientId'];
	
	
	# inclure le fichier de connexion 
	require "db_connect.php";
  
	# connexion à la BD
	$conn = new DB_CONNECT();
	
	#requête sql

	$sql = "select per_nom, per_prenom,per_genre,per_datnaiss,per_adr1,per_adr2,per_ville,per_cpostal,per_telprinc from personne 
							where id_personne = '$patientId'";
	# execution de la requête
	 $result = ibase_query($sql) or die(ibase_errmsg());
	
	     #recuperer la reponse
          $response['informationPersonnelle'] = array();
	 	if($row = ibase_fetch_row($result)) {
	 		#print_r($row);
	 		
           	// récuperer les champs

           	// tableau patients
           	$informationPersonnelle = array();
          
          	$informationPersonnelle['per_nom'] = utf8_encode(trim($row[0]));
          	$informationPersonnelle['per_prenom'] = utf8_encode(trim($row[1]));
          	$informationPersonnelle['per_genre'] = utf8_encode(trim($row[2]));
           	$informationPersonnelle['per_datnaiss'] = utf8_encode(trim($row[3]));
          	$dateNais = trim($row[3]);
           	$jour = substr($dateNais, "8", "2");
			$mois = substr($dateNais, "5", "2");
			$annee = substr($dateNais, "0", "4");
			
			$informationPersonnelle['jour'] = $jour;
			$informationPersonnelle['mois'] = $mois;
			$informationPersonnelle['annee'] = $annee;
			#Mr BOUDARS YOUNESS N le : 01/01/1989
			$genre = trim($row[2]);
			if ($genre == "M") {
				$genre = "Mr";
			}
			else{
				$genre = "Mlle";
			}
			$informationPersonnelle['extrait_naiss'] = $genre." ".trim($row[0])." ".trim($row[1])." "."Né(e) le : $jour/$mois/$annee";
            $informationPersonnelle['per_adr1']="Adresse1 : ".utf8_encode(trim($row[4]));
            $informationPersonnelle['per_adr2']="Adresse2 : ".utf8_encode(trim($row[5]));
           
           
            $informationPersonnelle['per_ville']="Ville : ".utf8_encode(trim($row[6]));
            $informationPersonnelle['per_cpostal']="Code postale : ".utf8_encode(trim($row[7]));
            $informationPersonnelle['per_telprinc']="Tél : ".utf8_encode(trim($row[8]));
            
           
			

           
            array_push($response["informationPersonnelle"], $informationPersonnelle);
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