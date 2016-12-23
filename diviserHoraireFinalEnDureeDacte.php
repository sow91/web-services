<?php
	
	function diviserHoraireFinalEnDureeDacte(&$response,&$horaireFinal,$dureeActe){

		$j = 0;

		for ($i=0; $i < sizeof($horaireFinal) ; $i=$i+2) { 
			
			$valeurInitial = $horaireFinal[$i];
			$valeurFinal = $horaireFinal[$i+1];

			$response[$j++] = $valeurInitial;
			

			while (($valeurInitial+$dureeActe) <= $valeurFinal) {
				
				$response[$j] = $response[$j-1]+$dureeActe;
				$valeurInitial = $response[$j];
				$j++;
			}
			$response[$j++]=0;
		}

	}

?>