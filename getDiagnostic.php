<?php

 # JSON array
$response = array();
# check id patient
if (isset($_GET['patientId'])) {
	# get id patient
	$patientId = $_GET['patientId'];
	
	
	# include de connexion file 
	require "db_connect.php";
    # include the rtf2HTML file
    include('Rtf2HTML.php');
	# new connexion
	$conn = new DB_CONNECT();
	# new Rtf Reader    
    $reader = new RtfReader();
	
	#sql query
	$sql = "select pat_diag from patient where id_personne='$patientId'";
	# execute the query
	 $result = ibase_query($sql) or die(ibase_errmsg());
	
	     #array of diagnostic
          $response['diagnostic'] = array();
	      if ($row = ibase_fetch_row($result,IBASE_TEXT)) {
	      	#print_r($row);
	 		# parse the rtf string
              $reader->Parse(trim($row[0]));
              #$reader->root->dump(); // to see what the reader read
              $formatter = new RtfHtml();
              $diag = $formatter->Format($reader->root);

           
           	$diagnostic = array();
           	// get the fields
           	$diagnostic['pat_diag'] = utf8_encode($diag);          
            array_push($response["diagnostic"], $diagnostic);
            $response['success'] = 1;
	       //converting a array to JSON
             echo (json_encode($response));
	      } else{
	       	$response['success'] = 0;
             echo (json_encode($response));
	       }

	       

	 
	}





           
           
	
?>