<?php
	
	function construireTableauRetour(&$response,&$horaireDisponible){

		for ($i=0; $i < sizeof($response) ; $i++) { 
                 
             if ($response[$i+1]!="0:00") {
             	# code...
            $heure = array();
        	$heure["heure_Debut_rdv"] = $response[$i];
        	$heure["heure_Fin_rdv"] = $response[$i+1];

        	array_push($horaireDisponible["horaireDisponible"], $heure);
             }
             else{

             	$i++;
             }
        	
                  
        }
	}

?>