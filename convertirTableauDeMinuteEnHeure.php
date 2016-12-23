<?php
	
	function convertirTableauDeMinuteEnHeure(&$response){

		for ($i=0; $i < sizeof($response) ; $i++) { 
                  
        $response[$i] = convertirMinuteEnHeure($response[$i]);
                  
        }
	}

?>