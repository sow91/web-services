<?php

function taille(&$responseDef){


	$i = 0;

	foreach ($responseDef as $key => $value) {
		
		foreach ($value as $key1 => $value1) {
			
			if ($value1['VALEUR'] != 0) {

				$i++;
			}
			
		}
	}

	return $i;

}