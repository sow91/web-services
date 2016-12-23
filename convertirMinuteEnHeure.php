<?php 

	function convertirMinuteEnHeure($minute){

	 	$heure= (int)($minute/60); 
		$min = $minute%60;

		if (($heure > 0 ) && ($heure < 10)) {
			# code...
			$heure = "0".$heure;
		}

		if (($min >=0) && ($min < 10)) {
			
			$min = "0".$min;
		}
		

		return $heure.":".$min;
	}
?>