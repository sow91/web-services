<?php

 # JSON response
$response = array();
# check fields
if (isset($_POST['rdvId'])) {

	// get fields
	$rdvId = utf8_encode(trim($_POST['rdvId']));
	
	# include connexion file 
	require "db_connect.php";
  
	# connection
	$conn = new DB_CONNECT();
	
	#sql query

	$sql = "select a.ID_RDV, a.ID_PERSONNE, a.PER_ID_PERSONNE, a.ID_ACTE, a.ID_FAUTEUIL, a.RDV_DATE, a.RDV_DUREE, a.RDV_STATUT, a.RDV_ARRIVEE, a.RDV_COMM, a.RDV_QUAND, a.RDV_COMM_INTERNET FROM RENDEZ_VOUS a where ID_RDV ='$rdvId'";
	
	# execute the query
	 $result = ibase_query($sql) or die(ibase_errmsg());
	 
	 if ($row = ibase_fetch_row($result)) {
	 	
	 	$idRdv = $row[0];$idPatient = $row[1];$idPraticien = $row[2];
	 	$idActe = $row[3];$idFaut = $row[4];
	 	$dureeRdv = $row[6];$statutRdv = $row[7];$arriveeRdv = $row[8];
	 	$commRdv = $row[9];$quandRdv = $row[10];$comInternet = $row[11];
 
	 	$dateRdv = utf8_encode(trim($row[5]));
           	
        $jour = substr($dateRdv, "8", "2");
		$mois = substr($dateRdv, "5", "2");
		$annee = substr($dateRdv, "0", "4");
		$heure = substr($dateRdv, "11", "2");
        $minute = substr($dateRdv, "14", "2");
        $newDate = $jour.'.'.$mois.'.'.$annee.','.$heure.':'.$minute;

        $idRdv = 1;

        $sql = "select ID_RDV from RENDEZ_VOUS_ANU order by ID_RDV desc";
	
		# execute the query
	 	$result = ibase_query($sql) or die(ibase_errmsg());
	     #get response
           while (($row = ibase_fetch_row($result))) {

            	$idRdv = $row[0];
            	$idRdv++;
            	break;
           }



	 	$sqli = "insert into RENDEZ_VOUS_ANU(ID_RDV,ID_PERSONNE,PER_ID_PERSONNE,ID_ACTE, ID_FAUTEUIL, RDV_DATE, RDV_DUREE) values('$idRdv','$idPatient','$idPraticien','$idActe','$idFaut','$newDate','$dureeRdv')";


	 	# execute the query
	 	$resulti = ibase_query($sqli) or die(ibase_errmsg());
	 
	 	if ($resulti) {
	 	
	 	
	 	#sql query

		$sqld = "delete from rendez_vous where ID_RDV ='$rdvId'";
	
		# execute the query
		$resultd = ibase_query($sqld) or die(ibase_errmsg());
	 
	 	if ($resultd) {
	 	
	 	$response['success'] = 1;
	 	$response['message'] = "rendez vous annulé";

	 	}
	 	else{
	 	$response['success'] = 0;
	 	$response['message'] = "erreur d'annulation.";
	 	}

	 	echo(json_encode($response));
		}


	 	


	 }


}

	
?>