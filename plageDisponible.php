<?php


	function  getPlageDisponible(&$response,&$plageBloque){
		
		#sql query
	$sql = "select a.ID_UTILISAT, a.NAME, a.PROPRIETE, a.HORAIRENOM, a.VALEUR, a.DATE_DEB, a.DATE_FIN, a.ID_FAUT_CHP
      FROM CONFIGHOURPLAN a where a.ID_UTILISAT=$idPraticien and a.ID_FAUT_CHP=$fautBloque and a.NAME like '$jour%'";
	
	// numbre of line
	$nbLigne = 0;

	# execute the query
	 $result = ibase_query($sql) or die(ibase_errmsg());
	 while (($row = ibase_fetch_row($result))) {

	 		$nbLigne++;

	 		$plage = array();
            

            $name = utf8_encode(trim($row[0]));
            $valeur = utf8_encode(trim($row[4]));
            $fautId = utf8_encode(trim($row[7]));

            $plage['NAME'] = $name;
            $plage['VALEUR'] = $valeur;
            $plage['ID_FAUT_CHP'] = $fautId;
            array_push($plageBloque["plages"], $plage);

        }

        if ($nbLigne != 0) {

        	return 1;
        }
        else{

        	return 0;
        }
        
            

	
	
	  }


?>