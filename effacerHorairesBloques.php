<?php


	function  effacerHoraireBloque(&$horairesBloques,&$responsePers,&$day){
		
	
	foreach ($horairesBloques as $key => $value) {
	 		
	 		foreach ($value as $key1 => $value1) {
	 			
	 			// get name and hour
	 			$valeur = $value1['VALEUR'];

	 			
	 			foreach ($responsePers as $keyp => $valuep) {
	 				
	 				foreach ($valuep as $keyp1 => $valuep1) {
	 					
	 					$namep = $valuep1['NAME'];
	 					$valeurp = $valuep1['VALEUR'];

	 					if ($name == $namep) {
	 						
	 						$hour['NAME'] = null;
	 						$hour['VALEUR'] = null;
	 					}
	 				}
	 			}

	 			array_push($response["hours"], $hour);

	 		}
	 		

	 	}

            

	
	
	  }


?>
