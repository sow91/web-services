<?php
	
	function rechercherUnElement(&$tabHoraireParDef,$valeur){

		$i=0;
	 	while (($i < sizeof($tabHoraireParDef)) &&
	 		($tabHoraireParDef[$i] != $valeur)) {
	 				
	 				$i++;
	 			}

	 			if ($i < sizeof($tabHoraireParDef)) {
	 				
	 				return 1;
	 			}

	 			else{
	 				return 0;
	 			}
	}

?>