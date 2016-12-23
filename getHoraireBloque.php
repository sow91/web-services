<?php

  function getHoraireBloque(&$tabPlaning,&$praticienId,&$patientId,&$fautId,&$acteId,&$date){

    $jour = substr($date, "8", "2");
    $month = substr($date, "5", "2");
    $year = substr($date, "0", "4");


      $sql = "select a.ID_RDV, a.RDV_DATE, a.RDV_DUREE  FROM RENDEZ_VOUS a where a.ID_PERSONNE=$patientId and a.PER_ID_PERSONNE=$praticienId and a.ID_FAUTEUIL=$fautId and a.ID_ACTE=$acteId";
      $nombreLigne = 0;

      # execute the query
      
      $result = ibase_query($sql) or die(ibase_errmsg());
      
      while (($row = ibase_fetch_row($result))) {
           
           
           // get date
           $dateRdv = utf8_encode(trim($row[1]));

           $heure = substr($dateRdv, "11", "2");
           $minute = substr($dateRdv, "14", "2");

           $jourRdv = substr($dateRdv, "8", "2");
           $monthRdv = substr($dateRdv, "5", "2");
           $yearRdv = substr($dateRdv, "0", "4");

          if (($jour == $jourRdv) && ($month == $monthRdv) && ($year == $yearRdv)) {
            # code...
            $nombreLigne++;
           $duree = utf8_encode(trim($row[2]));
           
           $valeurDebutBlocage = $heure*60+$minute;
           $valeurFinBlocage = $valeurDebutBlocage+$duree;

           for ($i=0; $i < 660 ; $i++) { 
           
            if (($tabPlaning[$i] != "B") &&
  (($valeurDebutBlocage < $tabPlaning[$i]) && ($tabPlaning[$i] < $valeurFinBlocage))) {
              $tabPlaning[$i] = "B";

            }

            if (($tabPlaning[$i] != "B") && ($tabPlaning[$i] > $valeurFinBlocage )) {
              break;
            }


           }
        }

     }

     if ($nombreLigne != 0) {
       return 1;
     }
     else{
      return 0;
     }

  }
	 





           
           
	
?>