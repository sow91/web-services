<?php

	function getHoraireFinal(&$horaireFiltres, &$horaireFinal){

		$j=1;
		$horaireFinal[0] = $horaireFiltres[0];


		for ($i=1; $i < sizeof($horaireFiltres); $i++) { 
			
			if ($horaireFiltres[$i]!=$horaireFiltres[$i-1]+1) {
				
				$horaireFinal[$j++] = $horaireFiltres[$i-1];
				$horaireFinal[$j++] = $horaireFiltres[$i];
			}

		}

		if ($horaireFiltres[$i-1]==$horaireFiltres[$i-2]+1) {
			# code...
			$horaireFinal[$j] = $horaireFiltres[$i-1];
		}

		
	}
?>