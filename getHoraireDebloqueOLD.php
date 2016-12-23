<?php

  function getHoraireDebloque(&$horairesDebloques,&$praticienId,&$patientId,&$fautId,&$acteId,&$date){

    // jour
    $jour = substr($date, "8", "2");
    // month
    $month = substr($date, "5", "2");
    // year
    $year = substr($date, "0", "4");


      $sql = "select a.ID_RDV, a.ID_PERSONNE, a.PER_ID_PERSONNE, a.ID_ACTE, a.ID_FAUTEUIL, a.RDV_DATE, a.RDV_DUREE, a.RDV_STATUT, a.RDV_ARRIVEE, a.RDV_COMM, a.RDV_QUAND, a.LASTMODIF, a.HEURE_FAUTEUIL, a.HEURE_SALLEATTENTE, a.HEURE_SECRETARIAT, a.HEURE_SORTI, a.ISEXPORTED, a.FAUT_UTILISE, a.LOCALISATION, a.RDV_COMM_INTERNET, a.RDV_FAMILLE, a.RDV_REPERCUTION
      FROM RENDEZ_VOUS a where a.ID_PERSONNE=$patientId and a.PER_ID_PERSONNE=$praticienId and a.ID_FAUTEUIL=$fautId and a.ID_ACTE=$acteId";
      $nombreLigne = 0;

      # execute the query
      
      $result = ibase_query($sql) or die(ibase_errmsg());
      
      while (($row = ibase_fetch_row($result))) {
           
           
           // get date
           $dateRdv = utf8_encode(trim($row[5]));

           // heure
           $heure = substr($dateRdv, "11", "2");
           // minute
           $minute = substr($dateRdv, "14", "2");
           // seconde
           $seconde = substr($dateRdv, "17", "2");

           // jour
           $jourRdv = substr($dateRdv, "8", "2");
           // month
           $monthRdv = substr($dateRdv, "5", "2");
           // year
          $yearRdv = substr($dateRdv, "0", "4");

          if (($jour == $jourRdv) && ($month == $monthRdv) && ($year == $yearRdv)) {
            # code...

           $nombreLigne++;
           $plageDebloque = array();
           $plageDebloque['ID_RDV'] = utf8_encode(trim($row[0]));
           $plageDebloque['ID_PERSONNE'] = utf8_encode(trim($row[1]));
           $plageDebloque['PER_ID_PERSONNE'] = utf8_encode(trim($row[2]));
           $plageDebloque['ID_ACTE'] = utf8_encode(trim($row[3]));
           $plageDebloque['ID_FAUTEUIL'] = utf8_encode(trim($row[4]));
           $plageDebloque['RDV_DATE'] = utf8_encode(trim($row[5]));
           $plageDebloque['RDV_DUREE'] = utf8_encode(trim($row[6]));
           $plageDebloque['RDV_HEURE_DEB'] = $heure*60+$minute;
           $plageDebloque['RDV_HEURE_FIN'] = $heure*60+$minute+$plageDebloque['RDV_DUREE'];

           $plageDebloque['heureDebDeblocage'] = $heure.":".$minute;
           $plageDebloque['heureFinDeblocage'] = convertirMinuteEnHeure(($heure*60+$minute+$plageDebloque['RDV_DUREE']));

           array_push($horairesDebloques["plagesDebloques"], $plageDebloque);
          }


           


      }
      if ($nombreLigne != 0) {
        return 1;
      }
      else
      {
        return 0;
      }
  }
	 





           
           
	
?>