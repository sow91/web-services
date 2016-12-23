<?php
	
	function remplirLePlaning(&$tabPlaning,&$horaireTravail){

		$i = 0;
		// 9h:00-20h:00
		$compteur = $heureDeb = 540;
		$heureFin = 1200;

		while ($compteur <= $heureFin) {
			
			$tabPlaning[$i] = $compteur;
			$horaireTravail[$i] = $compteur;
			$i++;
			$compteur++;

		}

	}

?>