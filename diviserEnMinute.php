<?php

function diviserEnMinute(&$tabHoraireParDef,&$responseDef){

	$temp = array();
	$i=0;

	foreach ($responseDef as $key => $value) {
		
		foreach ($value as $key1 => $value1) {
			
			$temp[$i++] = $value1['VALEUR'];
		}
	}

	trierParOrdreCroissant($temp);

	$compteur1 = $temp[1];
	$compteur2 = $temp[3];

	$temp1 = array();
	$temp2 = array();

	$temp1[0] = $temp[0];
	$temp2[0] = $temp[2];
	$i = 0;

	while ($temp1[$i] < $compteur1) {
		# code...
		$temp1[$i+1] = $temp1[$i]+1;

		$i++;
	}

	$i = 0;

	while ($temp2[$i] < $compteur2) {
		# code...
		$temp2[$i+1] = $temp2[$i]+1;

		$i++;
	}

	for ($i=0; $i < sizeof($temp1) ; $i++) { 
		
		$tabHoraireParDef[$i] = $temp1[$i];
	}

	for ($j=0; $j < sizeof($temp2) ; $j++) { 
		
		$tabHoraireParDef[$i++] = $temp2[$j];
	}


}
?>