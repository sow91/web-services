<?php

	function trierParOrdreCroissant(&$plagesHoraires){

		for ($i=0; $i < sizeof($plagesHoraires) ; $i++) { 
			# code...
			for ($j=$i+1; $j < sizeof($plagesHoraires) ; $j++) { 
				# code...
				if ($plagesHoraires[$j] < $plagesHoraires[$i]) {
					# code...
					$temp = $plagesHoraires[$i];
					$plagesHoraires[$i] = $plagesHoraires[$j];
					 $plagesHoraires[$j] = $temp;

				}
			}
		}
	}
?>