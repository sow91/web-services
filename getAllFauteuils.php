<?php

 # json array
$response = array();

	
	# include connexion file
	require "db_connect.php";
  
	# DB connexion
	$conn = new DB_CONNECT();
	
	#query sql

	$sql = "select id_fauteuil, faut_libelle from fauteuil";
	# execute query
	 $result = ibase_query($sql) or die(ibase_errmsg());
	 $nombreLigne = 0;
	     
          $response['fauteuils'] = array();
	 	while ($row = ibase_fetch_row($result)) {
	 		// count the number of line
	 		$nombreLigne++;
	 		

           	// table of fauteuil
           	$fauteuil = array();
           	$fauteuil['id_fauteuil'] = utf8_encode(trim($row[0]));
          	$fauteuil['faut_libelle']= utf8_encode(trim($row[1]));
           
            
                   
           
            array_push($response["fauteuils"], $fauteuil);
                 
	       }
	       if ($nombreLigne != 0) {
	       $response['success'] = 1;
	       
             echo (json_encode($response));
	       }
	       else{
	       	$response['success'] = 0;
	      
             echo (json_encode($response));
	       }

	       

	 
	





           
           
	
?>