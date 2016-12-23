<?php


	function  bloquerLesRendezVous(&$tabPlaning,&$horaireParJour,&$horairesRendezVous){
		
	
	foreach ($horairesRendezVous  as $key => $value) {
	 		
	 		foreach ($value as $key1 => $value1) {
	 			
	 			$valeurInitiale = $value1['RDV_HEURE_DEB'];
	 			$valeurFinale = $value1['RDV_HEURE_FIN'];

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