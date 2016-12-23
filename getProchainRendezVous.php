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
	
	// current date
	$format_date = 'd.m.y H:i:s';
	$today = date($format_date, time());

	$day = substr($today, "0", "2");
	$month = substr($today, "3", "2");
	$year = (substr($today, "6", "2")+2000);
	$hour = substr($today, "9", "2");
	$min = substr($today, "12", "2");

	
	
	$result = 0;
	$variableTest = 0;
	

	$sql = "select rdv_date from rendez_vous where id_personne='$patientId' order by rdv_date desc";
	# execute the query
	 $result = ibase_query($sql) or die(ibase_errmsg());
	
	     #array of rendezVous
          $response['prochainRdv'] = array();
	      if ($row = ibase_fetch_row($result)) {
	      	 		
           // get the fields
           	$dateRdv = trim($row[0]);
           	$jour = substr($dateRdv, "8", "2");
			$mois = substr($dateRdv, "5", "2");
			$annee = substr($dateRdv, "0", "4");
			$heure = substr($dateRdv, "11", "2");
			$minute = substr($dateRdv, "14", "2");

			//
			if (($jour >= $day) && ($mois >= $month) && ($annee >= $year)) {
				

				if (($jour == $day) && ($mois == $month) && ($annee == $year)) {

				if (($heure > $hour)||(($heure == $hour) && ($minute >= $min))) {
					
					$variableTest = 1;
				}				

			}
			else{

				$variableTest = 1;
			}


			}
			else if ((($mois > $month) && ($annee >= $year)) || ($annee > $year)){

				$variableTest = 1;

			}



			if ($variableTest == 1){
				
			$variableTest = 0;
				# code...
			$prochainRendezVous = array();
			$prochainRendezVous['jour'] = $jour;
			$prochainRendezVous['mois'] = $mois;
			$prochainRendezVous['annee'] = $annee;
			$prochainRendezVous['heure'] = $heure;
			
           	
			$prochainRendezVous['rendezVousProchain'] = "Vous avez un rendez-vous le : $jour/$mois/$annee à $heure:$minute";

          	
            array_push($response["prochainRdv"], $prochainRendezVous);
            $response['success'] = 1;
	       //converting a array to JSON
             echo (json_encode($response));
             $result++;



			}

			else{

				$result = 0;
			}
           	
	      }

	       if ($result == 0) {
	       	# code...
	       
	       	$response['success'] = 0;
	       	$response['message'] = "Pas de rendez-vous pour vous";

             echo (json_encode($response));
	       }

	       

	 
	}





           
           
	
?>