<?php

function chargerActe(&$idActe){
	

	$sql = "select a.ID_ACTE, a.ACTE_LIBELLE, a.ACTE_DURESTD, a.ACTE_COULEUR, a.TYPE_ACTE, a.NB_FAUTBLOC, a.CODE_PLANING, a.TEMPS_CHRONO, a.ANTICIP_RDV, a.NO_PRINT, a.SMS,
	    a.COURRIER, a.ANTICIPATION_SMS, a.CATEG_STATS from ACTES a 
	     where a.ID_ACTE = '$idActe'";
	
	 $result = ibase_query($sql) or die(ibase_errmsg());
	
	     
	 	if($row = ibase_fetch_row($result)) {
	 		
	 		$dureeActe = utf8_encode(trim($row[2]));
	 	}

	 	return $dureeActe;

}
?>