<?php

 # json array
$response = array();

	
	# include connexion file
	require "db_connect.php";
  	include "conversionColorToHexadecimal.php";
	# DB connexion
	$conn = new DB_CONNECT();
	
	#query sql

	$sql = "select a.ID_ACTE, a.ACTE_LIBELLE, a.ACTE_DURESTD, a.ACTE_COULEUR from ACTES a";
	# execute query
	 $result = ibase_query($sql) or die(ibase_errmsg());
	 $nombreLigne = 0;
	     
          $response['actes'] = array();
	 	while ($row = ibase_fetch_row($result)) {
	 		// count the number of line
	 		$nombreLigne++;
	 		

           	// acte array
           	$acte = array();
           	$acte['id_acte'] = utf8_encode(trim($row[0]));
          	$acte['acte_libelle']= utf8_encode(trim($row[1]));
          	$acte['acte_duree']= utf8_encode(trim($row[2]));
           $acte['acte_couleur']= getColorActe(utf8_encode($row[3]));
            
                   
           
            array_push($response["actes"], $acte);
                 
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