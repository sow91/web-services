<?php

// json array
$response = array();
$responseDef = array();
$responsePers = array();
$horairesBloques = array();
$horairesDebloques = array();
$horairesRendezVous = array();
$heures = array();

 if(isset($_GET['praticienId']) && isset($_GET['day']) && isset($_GET['fautId']) && isset($_GET['date'])) {

	# get fields
	$praticienId = trim($_GET['praticienId']);
  	
  	$day = trim($_GET['day']);
	
	$fautId = trim($_GET['fautId']); 
  
   	// date format ex : 2016-03-07
  	$date =  trim($_GET['date']);

  	 # include de connexion file 
	    require "db_connect.php";
	    include 'convertirMinuteEnHeure.php';
	    include 'getHoraireBloque.php';
	    include 'getHoraireDebloque.php';
	    include 'getHoraireNonBloques.php';
	    include 'getHoraireRendezVous.php';
      include 'trierParOrdreCroissant.php';

	 # new connexion
		$conn = new DB_CONNECT();

	 #sql query

	 $sql = "select a.ID_UTILISAT, a.NAME, a.PROPRIETE, a.HORAIRENOM, a.VALEUR, a.DATE_DEB, a.DATE_FIN, a.ID_FAUT_CHP FROM CONFIGHOURPLAN a where a.ID_UTILISAT=$praticienId and a.ID_FAUT_CHP=$fautId and a.NAME like '$day%'";
	
	   $nombreLigne = 0;
     $nombreLignePerso = 0;
     $valNonNul = 0;
     $acteIdB = -1;
  	 $patientIdB = -2;
     $acteIdDeb=0;
     $plagesHorairesNonBloques = array();
     # execute the query
	 $result = ibase_query($sql) or die(ibase_errmsg());


	 $responseDef['hourDef'] = array();
     $responsePers['hoursPerso'] = array();
     $horairesBloques['plagesBloques'] = array();
     $horairesDebloques['plagesDebloques'] = array();
     $horairesRendezVous['horaireRdv'] = array();
	 while (($row = ibase_fetch_row($result))) {
	      
            $nombreLigne++;
            $horaireNom = utf8_encode(trim($row[3]));

            if ($horaireNom == "Horaires par défaut") {


            $hourDef = array();
            
            #$hourDef['ID_UTILISAT'] = utf8_encode(trim($row[0]));

            $hourDef['NAME']=utf8_encode(trim($row[1]));

            #$hourDef['PROPRIETE']=utf8_encode(trim($row[2]));

            #$hourDef['HORAIRENOM'] = utf8_encode(trim($row[3]));

            $hourDef['VALEUR'] = utf8_encode(trim($row[4]));

            if ($hourDef['VALEUR'] != 0) {
              $hourDef['heure'] = convertirMinuteEnHeure(utf8_encode(trim($row[4])));
            }
            
            #$hourDef['ID_FAUT_CHP']=utf8_encode(trim($row[7]));
            

            array_push($responseDef["hourDef"], $hourDef);
 		
 		}
           else {

              $nombreLignePerso++;
              
              $hourPerso = array();

            #$hourPerso['ID_UTILISAT'] = utf8_encode(trim($row[0]));

            #$hourPerso['NAME']=utf8_encode(trim($row[1]));

            #$hourPerso['PROPRIETE']=utf8_encode(trim($row[2]));

            #$hourPerso['HORAIRENOM'] = utf8_encode(trim($row[3]));

            $hourPerso['VALEUR'] = utf8_encode(trim($row[4]));

            if ($hourPerso['VALEUR'] != 0) {
            	$valNonNul++;
             $hourPerso['heure'] = convertirMinuteEnHeure(utf8_encode(trim($row[4])));
            }
            
            #$hourPerso['ID_FAUT_CHP']=utf8_encode(trim($row[7]));


            array_push($responsePers["hoursPerso"], $hourPerso);
            }

        }

        if ($nombreLigne != 0) {

        	 if (($nombreLignePerso != 0) && ($valNonNul !=0 )) 
             {

              $responsePers['success'] = 1;
              echo('horairePersonnalise applique'.json_encode($responsePers));
             }
             else{

               echo('horaire defaut Applique'.json_encode($responseDef));
               echo('<br/>');
              if (getHoraireBloque($horairesBloques,$praticienId,$patientIdB,$fautId,$acteIdB,$date) == 1) {

              getHoraireNonBloques($horairesBloques,$responseDef, $plagesHorairesNonBloques);


             echo('<br/>');
              echo('<br/>');
             echo(json_encode($horairesBloques));
             echo('<br/>');
             }


              if (getHoraireDebloque($horairesDebloques,$praticienId,$patientIdB,$fautId,$acteIdDeb,$date) == 1) {
               # code...
            echo('<br/>');
             echo(json_encode($horairesDebloques));
             echo('<br/>');
             }


             if (getHoraireRendezVous($horairesRendezVous,$praticienId,$patientIdB,$fautId,$acteIdB,$date) == 1) {
               # code...
            echo('<br/>');
             echo(json_encode($horairesRendezVous));

             }

             }
        	

        }
         else{
	       	   
             $response['success'] = 0;
             echo (json_encode($response));
	       }
  
  }
?>