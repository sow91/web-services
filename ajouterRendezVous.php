<?php

 # JSON response
$response = array();
# check fields
if (isset($_POST['praticienId']) && isset($_POST['patientId']) && isset($_POST['acteId'])
	&& isset($_POST['fautId']) && isset($_POST['date']) && isset($_POST['dureeActe'])) {

	// get fields
	$praticienId = utf8_encode(trim($_POST['praticienId']));
	$patientId = utf8_encode(trim($_POST['patientId']));
	$acteId = utf8_encode(trim($_POST['acteId']));
	$fautId = utf8_encode(trim($_POST['fautId']));
	$date = utf8_encode(trim($_POST['date']));
	$dureeActe = utf8_encode(trim($_POST['dureeActe']));
	$idRdv = 0;
	
	# include connexion file 
	require "db_connect.php";
  
	# connection
	$conn = new DB_CONNECT();
	
	$sql = "select ID_RDV from RENDEZ_VOUS order by ID_RDV desc";
	
	# execute the query
	 $result = ibase_query($sql) or die(ibase_errmsg());
	     #get response
           while (($row = ibase_fetch_row($result))) {

            	$idRdv = $row[0];
            	$idRdv++;
            	break;
           }


     if ($idRdv != 0) {
          	
	#sql query

	$sql = "insert into rendez_vous (ID_RDV,ID_PERSONNE,PER_ID_PERSONNE,ID_ACTE,ID_FAUTEUIL,RDV_DATE,RDV_DUREE)
	values($idRdv,'$patientId','$praticienId','$acteId','$fautId','$date','$dureeActe')";
	
	# execute the query
	 $result = ibase_query($sql) or die(ibase_errmsg());
	 
	 if ($result) {
	 	
	 	$response['success'] = 1;
	 	$response['message'] = "rendez vous reservé";

	 }
	 else{
	 	$response['success'] = 0;
	 	$response['message'] = "error reservation.";
	 }

	 echo(json_encode($response));
	}

}
	
?>