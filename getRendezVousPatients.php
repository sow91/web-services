<?php

 # JSON array
$response = array();
# check id patient
if (isset($_GET['patientId'])) {
	# get id patient
	$patientId = $_GET['patientId'];
	
	
	# include de connexion file 
	require "db_connect.php";
  
	# new connexion
	$conn = new DB_CONNECT();
	
	#sql query

/*select rdv_date, acte_libelle, faut_libelle, rdv_duree  
	from rendez_vous rdv, actes a, fauteuil f, patient pat where rdv.id_personne=pat.id_personne
	 and rdv.id_acte = a.id_acte and rdv.id_fauteuil = f.id_fauteuil and pat.id_personne='$patientId'"*/

	$sql = "select rdv_date from rendez_vous where id_personne='$patientId' order by rdv_date desc";
	# execute the query
	 $result = ibase_query($sql) or die(ibase_errmsg());
	
	     #array of rendezVous
          $response['prochainRdv'] = array();
	      if ($row = ibase_fetch_row($result)) {
	      	#print_r($row);
	 		
           
           	$prochainRendezVous = array();
           	// get the fields
           	$dateRdv = trim($row[0]);
           	$jour = substr($dateRdv, "8", "2");
			$mois = substr($dateRdv, "5", "2");
			$annee = substr($dateRdv, "0", "4");
			$heure = substr($dateRdv, "11", "5");
			$prochainRendezVous['jour'] = $jour;
			$prochainRendezVous['mois'] = $mois;
			$prochainRendezVous['annee'] = $annee;
			$prochainRendezVous['heure'] = $heure;
			
          	#$rendezVous['acte_libelle']= trim($row[1]);
            #$rendezVous['faut_libelle']= trim($row[2]);
            #$rendezVous['rdv_duree']= trim($row[3]);
            array_push($response["prochainRdv"], $prochainRendezVous);
            $response['success'] = 1;
	       //converting a array to JSON
             echo (json_encode($response));
	      } else{
	       	$response['success'] = 0;
             echo (json_encode($response));
	       }

	       

	 
	}





           
           
	
?>