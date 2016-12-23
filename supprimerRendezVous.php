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

	$sql = "delete from rendez_vous where ID_RDV ='$rdvId'";
	
	# execute the query
	 $result = ibase_query($sql) or die(ibase_errmsg());
	 
	 if ($result) {
	 	
	 	$response['success'] = 1;
	 	$response['message'] = "rendez vous supprimé";

	 }
	 else{
	 	$response['success'] = 0;
	 	$response['message'] = "error suppression.";
	 }

	 echo(json_encode($response));
	}


	
?>