<?php

function segmenterEnMinute(&$tabHoraireParDef,&$responsePers){

	$temp = array();
	$i=0;

	foreach ($responsePers as $key => $value) {
		
		foreach ($value as $key1 => $value1) {
			
			if ($value1['VALEUR'] != 0) {
				# code...
				$temp[$i++] = $value1['VALEUR'];
			}
			
		}
	}

	trierParOrdreCroissant($temp);


	$compteur1 = $temp[0];
	$compteur2 = $temp[1];
	$tabHoraireParDef[0] = $compteur1;
	$i = 0;

	while ($compteur1 < $compteur2) {
		# code...
		$tabHoraireParDef[$i+1] = $tabHoraireParDef[$i]+1;
		$compteur1 = $tabHoraireParDef[$i+1]; 

		$i++;
	}

}
?>