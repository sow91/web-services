<?php

 # JSON array
$response = array();
# check id patient
if (isset($_GET['patientId'])) {
	# get id patient
	$patientId = $_GET['patientId'];
	
	
	# include de connexion file 
	require "db_connect.php";
  
	# include the rtf file
  	include('Rtf2HTML.php');

	# new connexion
	$conn = new DB_CONNECT();

	 # new Rtf Reader    
   $reader = new RtfReader();
	
	#sql query
	$sql = "select pat_plan	 from patient where id_personne='$patientId'";

	# execute the query
	 $result = ibase_query($sql) or die(ibase_errmsg());
	
	     #array of plan traitement
          $response['planTraitement'] = array();

	      if ($row = ibase_fetch_row($result, IBASE_TEXT)) {
	      	#print_r($row);
	 		# parse the rtf string
            $reader->Parse(utf8_encode(trim($row[0])));
            #$reader->root->dump(); // to see what the reader read
            $formatter = new RtfHtml();
            $planTrait = $formatter->Format($reader->root);
           
          	$planTraitement = array();
           	// get the fields
           	$planTraitement['pat_plan'] = $planTrait;
          
           
           array_push($response["planTraitement"], $planTraitement);
            $response['success'] = 1;
	       //converting a array to JSON
             echo (json_encode($response));
	      } else{
	       	$response['success'] = 0;
             echo (json_encode($response));
	       }

	       

	 
	}





           
           
	
?>