<?php
	
	function rechercherPosition(&$tabHoraireParDef,$valeur){

		$i=0;
	 	while ($tabHoraireParDef[$i] != $valeur) {
	 				
	 				$i++;
	 			}

	 			return $i;
	}

?>