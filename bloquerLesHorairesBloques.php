<?php


	function  bloquerLesHorairesBloques(&$tabPlaning,&$horaireParJour,&$horairesBloques){
		
	
	foreach ($horairesBloques as $key => $value) {
	 		
	 		foreach ($value as $key1 => $value1) {
	 			
	 			$valeurInitiale = $value1['VALEUR'];
	 			$duree = $value1['RDV_DUREE'];
	 			$valeurFinale = $valeurInitiale+$duree;

	 			if ((rechercherUnElement($horaireParJour,$valeurInitiale) == 1)&& 
	 				(rechercherUnElement($horaireParJour,$valeurFinale) == 1)) {

	 					$pos1 = rechercherPosition($horaireParJour,$valeurInitiale);
	 					$pos2 = rechercherPosition($horaireParJour,$valeurFinale);

	 					for ($i=$pos1+1; $i < $pos2 ; $i++) { 
	 						
	 						$tabPlaning[$i]="B";
	 					}
	 				
	 			}


	 			}


	 		}
	 		

	 	}


?>