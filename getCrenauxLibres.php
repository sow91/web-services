<?php


	function  getCrenauxLibre(&$plageBloque,&$response,&$creanuxLibre){
		
		

	
	foreach ($response as $key => $value) {
	 		
	 		foreach ($value as $key1 => $value1) {
	 			
	 			$indicateur = "false";
	 			
	 			// get name and hour
	 			$name = $value1['NAME'];
	 			$valeur = $value1['VALEUR'];

	 			// new array
	 			$hour = array();
	 			$hour['NAME'] = $name;
	 			$hour['VALEUR'] = $valeur;

	 			
	 			
	 			foreach ($plageBloque as $keyp => $valuep) {
	 				
	 				foreach ($valuep as $keyp1 => $valuep1) {
	 					
	 					$namep = $valuep1['NAME'];
	 					$valeurp = $valuep1['VALEUR'];

	 					if ($name == $namep) {
	 						
	 						$indicateur = "true";
	 					}
	 				}
	 			}

	 			if ($indicateur == "false") {
	 				# code...
	 				array_push($creanuxLibre["hours"], $hour);
	 			}



	 			

	 		}
	 		

	 	}

            

	
	
	  }


?>