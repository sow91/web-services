<?php
	

	
	 function getHoraireDisponible(&$horairesBloques,&$responseDef){

	 	foreach ($responseDef as $key => $value) {
	 		
	 		foreach ($value as $key1 => $value1) {
	 			
	 			// get name and hour
	 			$name = $value1['NAME'];
	 			$valeur = $value1['VALEUR'];

	 			// new array
	 			$hour = array();
	 			$hour['NAME'] = $name;
	 			$hour['VALEUR'] = $valeur;

	 			
	 			
	 			foreach ($responsePers as $keyp => $valuep) {
	 				
	 				foreach ($valuep as $keyp1 => $valuep1) {
	 					
	 					$namep = $valuep1['NAME'];
	 					$valeurp = $valuep1['VALEUR'];

	 					if ($name == $namep) {
	 						
	 						$hour['VALEUR'] = abs($hour['VALEUR']-$valeurp);

	 					}
	 				}
	 			}

	 			array_push($response["hours"], $hour);

	 		}
	 		

	 	}


	 }	
?>