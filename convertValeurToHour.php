<?php
	
	 function convertValeurToHour(&$response,&$horairesDispo){

	 	foreach ($response as $key => $value) {
	 		
	 		foreach ($value as $key1 => $value1) {
	 			
	 			// new array
	 			$hour = array();
	 			$hour['NAME'] = $value1['NAME'];
	 			

	 			// get hour
	 			$valeur = $value1['VALEUR'];


	 			if ($valeur != 0) {
	 				# conversion...
	 				$heure= (int)($valeur/60); 
					$min = $valeur%60;
					
					if ($min == 0) {
						# code...
						$min ="00";
					}

					$hour['VALEUR'] = $heure."h".":".$min;
	 			}	 
	 			else {

					$hour['VALEUR'] = 0;
					}

					array_push($horairesDispo["hours"], $hour);


	 		}
	 		

	 	}


	 }	
?>