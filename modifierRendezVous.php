<?php

 # JSON response
$response = array();
# check fields
if (isset($_POST['rdvId']) && isset($_POST['praticienId']) && isset($_POST['patientId']) && isset($_POST['acteId'])
	&& isset($_POST['fautId']) && isset($_POST['date']) && isset($_POST['dureeActe'])) {

	// get fields
	$rdvId = utf8_encode(trim($_POST['rdvId']));
	$praticienId = utf8_encode(trim($_POST['praticienId']));
	$patientId = utf8_encode(trim($_POST['patientId']));
	$acteId = utf8_encode(trim($_POST['acteId']));
	$fautId = utf8_encode(trim($_POST['fautId']));
	$date = utf8_encode(trim($_POST['date']));
	$dureeActe = utf8_encode(trim($_POST['dureeActe']));
	
	# include connexion file 
	require "db_connect.php";
  
	# connection
	$conn = new DB_CONNECT();
	
	$sql = "update RENDEZ_VOUS set ID_PERSONNE='$patientId',PER_ID_PERSONNE='$praticienId',
	ID_ACTE='$acteId',ID_FAUTEUIL='$fautId',RDV_DATE='$date',RDV_DUREE='$dureeActe'
	where ID_RDV='$rdvId'";
	
	# execute the query
	 $result = ibase_query($sql) or die(ibase_errmsg());
	 
	 if ($result) {
	 	
	 	$response['success'] = 1;
	 	$response['message'] = "rendez modifié";

	 }
	 else{
	 	$response['success'] = 0;
	 	$response['message'] = "error modification.";
	 }

	 echo(json_encode($response));
	}

	
?>