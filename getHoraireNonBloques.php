<?php
	

	
	 function getHoraireNonBloques(&$horairesBloques,&$horaireNormal,&$plagesHorairesNonBloques){

	 	$horairesParDefaut = array();
	 	$horairesBloq = array();
	 	$tab1 = array();
	 	$tab2 = array();
	 	$i=0;
	 	$j=0;
	 	$k=0;
	 	foreach ($horaireNormal as $key => $value) {
	 		
	 		foreach ($value as $key1 => $value1) {
	 			
	 				$horairesParDefaut[$i++] = $value1['VALEUR'];
	 			}
	 			

	 		}



	 		// trier the table
	 		trierParOrdreCroissant($horairesParDefaut);

	 		$horaireDebutMat = $horairesParDefaut[0];
	 		$horaireFinMat = $horairesParDefaut[1];
	 		$horaireDebutSoir = $horairesParDefaut[2];
	 		$horaireFinSoir = $horairesParDefaut[3];

	 		


	 		for ($j=0; $j < $i ; $j++) { 
	 			
	 			echo(convertirMinuteEnHeure($horairesParDefaut[$j])." ");
	 		}

	 		$i = 0;
	 		$j = 0;
	 		$code = 0;
	 		foreach ($horairesBloques as $key => $value) {
	 		
	 		foreach ($value as $key1 => $value1) {
	 			
	 				if(($value1['VALEUR'] > $horaireDebutMat) && ($value1['VALEUR'] < $horaireFinMat) &&

	 				($value1['VALEUR']+$value1['RDV_DUREE'] < $horaireFinMat) ||

	 				($value1['VALEUR'] > $horaireDebutSoir) && ($value1['VALEUR'] < $horaireFinSoir) &&

	 				 ($value1['VALEUR']+$value1['RDV_DUREE'] < $horaireFinSoir)) {

	 					$test = 1;

	 				$tab1[$i++] = $value1['VALEUR'];
	 				$tab1[$i++] = $value1['VALEUR']+$value1['RDV_DUREE'];
	 				
	 				}
	 				else if (($value1['VALEUR'] > $horaireDebutMat) && ($value1['VALEUR'] < $horaireFinMat) &&
	 				 ($value1['VALEUR']+$value1['RDV_DUREE'] > $horaireFinMat)) {

	 				 	if (($value1['VALEUR']+$value1['RDV_DUREE'] > $horaireDebutSoir) &&
	 				 		($value1['VALEUR']+$value1['RDV_DUREE'] < $horaireFinSoir)) {
	 				 		

	 				 		$cas++;
	 				 		$tab2[$j++] = $value1['VALEUR'];
	 						$tab2[$j++] = $value1['VALEUR']+$value1['RDV_DUREE'];
	 				 	}
	 				}

	 				else if (($value1['VALEUR'] >= $horaireFinMat) && ($value1['VALEUR'] < $horaireDebutSoir) &&
	 				 ($value1['VALEUR']+$value1['RDV_DUREE'] > $horaireDebutSoir) &&
	 				 ($value1['VALEUR']+$value1['RDV_DUREE'] < $horaireFinSoir)) {
	 					

	 					$code = 1;
	 					# code...
	 					$tab1[$i++] = $value1['VALEUR']+$value1['RDV_DUREE'];
	 				}

	 				else if (($value1['VALEUR'] > $horaireDebutMat) && ($value1['VALEUR'] < $horaireFinMat) &&
	 				 ($value1['VALEUR']+$value1['RDV_DUREE'] > $horaireFinMat) &&
	 				 ($value1['VALEUR']+$value1['RDV_DUREE'] < $horaireDebutSoir)) {
	 					# code...


	 					$case = 2;
	 					$tab1[$i++] = $value1['VALEUR'];
	 				}

	 				
	 				
	 				
	 			}
	 			
	 		}


	 		


	 		if ($cas != 0) {
	 		
	 		$tab2[$j++] = $horaireDebutMat;
	 		$tab2[$j++] = $horaireFinSoir;
	 		trierParOrdreCroissant($tab2);
	 		echo('<br/>');

	 		for ($k=0; $k < $j ; $k+=2) { 
	 			
	 			echo(convertirMinuteEnHeure($tab2[$k])."-".convertirMinuteEnHeure($tab2[$k+1])."<br/>");
	 		}

	 		}

	 		else {

	 			if ($code == 1) {
	 				# code...

	 				$tab1[$i++] = $horaireDebutMat;
	 				$tab1[$i++] = $horaireFinMat;
	 				$tab1[$i++] = $horaireFinSoir;
	 				trierParOrdreCroissant($tab1);
	 			}
	 			else if ($case == 2) {
	 				# code...

	 				
	 				$tab1[$i++] = $horaireDebutMat;
	 				$tab1[$i++] = $horaireDebutSoir;
	 				$tab1[$i++] = $horaireFinSoir;
	 				trierParOrdreCroissant($tab1);
	 			}
	 			else if($test == 1){
	 				
	 				$tab1[$i++] = $horaireDebutMat;
	 				$tab1[$i++] = $horaireFinMat;
	 				$tab1[$i++] = $horaireDebutSoir;
	 				$tab1[$i++] = $horaireFinSoir;
	 				trierParOrdreCroissant($tab1);
	 			}
	 		
	 		
	 		echo('<br/>');

	 		for ($k=0; $k < $i ; $k+=2) { 
	 			
	 			echo(convertirMinuteEnHeure($tab1[$k])."-".convertirMinuteEnHeure($tab1[$k+1])."<br/>");
	 		}
	 		}

	 		
	 		

	 		

	 		


	 		}



	 	
?>