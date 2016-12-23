<?php

  function getPlageBloque(&$plageBloque,&$praticienId,&$fautBloque,&$day){

      $sql = "select a.ID_UTILISAT, a.NAME, a.PROPRIETE, a.HORAIRENOM, a.VALEUR, a.DATE_DEB, a.DATE_FIN, a.ID_FAUT_CHP
      FROM CONFIGHOURPLAN a where a.ID_UTILISAT=$praticienId and a.ID_FAUT_CHP=$fautBloque and a.NAME like '$day%'";
      
      $nombreLigne = 0;

      # execute the query
      
      $result = ibase_query($sql) or die(ibase_errmsg());
      
      while (($row = ibase_fetch_row($result))) {
           
           $nombreLigne++;

           $plage = array();
           $plage['NAME'] = utf8_encode(trim($row[1]));
           $plage['VALEUR'] = utf8_encode(trim($row[4]));

           array_push($plageBloque["plages"], $plage);


      }
      if ($nombreLigne != 0) {
        echo('plage bloqué : '.json_encode($plageBloque));
        return 1;
      }
      else
      {
        return 0;
      }
  }
	 





           
           
	
?>