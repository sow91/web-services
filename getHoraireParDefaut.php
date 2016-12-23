<?php

// json array
$response = array();
$responseDef = array();
$responsePers = array();
$tabPlaning = array();
$horaireTravail = array();
$horaireFiltres = array();
$horaireFinal = array();
$horaireDisponible["horaireDisponible"] = array();

 if(isset($_GET['praticienId']) && isset($_GET['day']) && isset($_GET['fautId']) && isset($_GET['date']) && isset($_GET['dureeActe']) ) {

	# get fields
	$praticienId = trim($_GET['praticienId']);
  	
  $day = trim($_GET['day']);
	
	$fautId = trim($_GET['fautId']); 

  $dureeActe = trim($_GET['dureeActe']);
  
   	// date format ex : 2016-03-07
  $date =  trim($_GET['date']);

  $patientId = -2;
  $acteId = -1;
  $acteIdDeb = 0;

  	 # include de connexion file 
	    require "db_connect.php";
      require "trierParOrdreCroissant.php";
      require "remplirLePlaning.php";
      require "trouverHoraireParDefaut.php";
      require "getHoraireBloque.php"; 
      require "getHoraireRendezVous.php";
      require "getHoraireDebloque.php"; 
      require "getHoraireFiltres.php";
      require "getHoraireFinal.php";
      require "diviserHoraireFinalEnDureeDacte.php";
      require "convertirTableauDeMinuteEnHeure.php";
      require "convertirMinuteEnHeure.php";
      require "construireTableauRetour.php";
	 # new connexion
		$conn = new DB_CONNECT();

	 #sql query

	 $sql = "select a.ID_UTILISAT, a.NAME, a.HORAIRENOM, a.VALEUR FROM CONFIGHOURPLAN a where a.ID_UTILISAT=$praticienId and a.ID_FAUT_CHP=$fautId and a.NAME like '$day%'";
	
	   $nombreLigne = 0;
     $nombreLignePerso = 0;
     $cptDef = 0;
     $cptPers = 0;
     $case = 0;
    
     # execute the query
	 $result = ibase_query($sql) or die(ibase_errmsg());

   
	 while (($row = ibase_fetch_row($result))) {
	      
            
            $horaireNom = utf8_encode(trim($row[2]));
            $valeur = utf8_encode(trim($row[3]));

            if (($horaireNom == "Horaires par défaut") &&
                ($valeur != 0)) {
              
              $nombreLigne++;

            $responseDef[$cptDef++] = utf8_encode(trim($row[3]));

 		
 		       }
           else if(($horaireNom != "Horaires par défaut") &&
                ($valeur != 0)) {
            $nombreLigne++;
            $nombreLignePerso++;
            $responsePers[$cptPers++] = utf8_encode(trim($row[3]));
              
            }

        }

        if ($nombreLigne != 0) {

          // 9h:00 à 20h:00
          remplirLePlaning($tabPlaning,$horaireTravail);

            //  horaire personnalisé
        	 if ($nombreLignePerso != 0) 
             {

              trierParOrdreCroissant($responsePers);

              #echo(json_encode($responsePers));

              trouverHoraireParDefaut($responsePers,$tabPlaning,$cptPers);

              if (getHoraireBloque($tabPlaning,$praticienId,$patientId,$fautId,$acteId,$date) == 1) {
                
                $case = 1;
              }

              if (getHoraireRendezVous($tabPlaning,$praticienId,$patientId,$fautId,$acteId,$date) == 1) {
                
                $case = 2;
              }

              if (getHoraireDebloque($tabPlaning,$horaireTravail,$praticienId,$patientId,$fautId,$acteIdDeb,$date) == 1) {
                
                $case = 3;
              }

              #echo(json_encode($tabPlaning));

              // soit blocage ou rendez vous ou deblocage
              if (($case == 1)||($case == 2)||($case == 3)) {

                // eliminer les plages bloquées 
                getHoraireFiltres($tabPlaning,$horaireFiltres);
                getHoraireFinal($horaireFiltres,$horaireFinal);

                //duree = 20; 9h:00,9h20,9h40....
                diviserHoraireFinalEnDureeDacte($response,$horaireFinal,$dureeActe);
                convertirTableauDeMinuteEnHeure($response);
                #convertirTableauDeMinuteEnHeure($horaireFinal);

                construireTableauRetour($response,$horaireDisponible);
                
                $horaireDisponible["success"] = 1;
                

                 #echo(json_encode($horaireFiltres));
                 #echo(json_encode($horaireFinal));
                 #echo(json_encode($response));
                 echo(json_encode($horaireDisponible));
              }

              else{

                    
                // eliminer les plages bloquées dans lhoraire par defaut
                getHoraireFiltres($tabPlaning,$horaireFiltres);

                getHoraireFinal($horaireFiltres,$horaireFinal);
                
                //duree = 20; 9h:00,9h20,9h40....
                diviserHoraireFinalEnDureeDacte($response,$horaireFinal,$dureeActe);


               
                convertirTableauDeMinuteEnHeure($response);
                #convertirTableauDeMinuteEnHeure($horaireFinal);
                
                construireTableauRetour($response,$horaireDisponible);
                
                $horaireDisponible["success"] = 1;
                echo(json_encode($horaireDisponible));
              
              }

              
              

              }

             else{
                trierParOrdreCroissant($responseDef);
                #echo(json_encode($responseDef));
                
                trouverHoraireParDefaut($responseDef,$tabPlaning,$cptDef);

               if (getHoraireBloque($tabPlaning,$praticienId,$patientId,$fautId,$acteId,$date) == 1) {
                
                $case = 1;
              }

              if (getHoraireRendezVous($tabPlaning,$praticienId,$patientId,$fautId,$acteId,$date) == 1) {
                
                $case = 2;
              }

              if (getHoraireDebloque($tabPlaning,$horaireTravail,$praticienId,$patientId,$fautId,$acteIdDeb,$date) == 1) {
                
                $case = 3;
              }


              #echo(json_encode($tabPlaning));

              // soit blocage ou rendez vous ou deblocage
              if (($case == 1)||($case == 2)||($case == 3)) {

                // eliminer les plages bloquées 
                getHoraireFiltres($tabPlaning,$horaireFiltres);
                getHoraireFinal($horaireFiltres,$horaireFinal);

                //duree = 20; 9h:00,9h20,9h40....
                diviserHoraireFinalEnDureeDacte($response,$horaireFinal,$dureeActe);
                convertirTableauDeMinuteEnHeure($response);
                
                construireTableauRetour($response,$horaireDisponible);
                
                $horaireDisponible["success"] = 1;

                 #echo(json_encode($horaireFiltres));
                 #echo(json_encode($horaireFinal));
                 #echo(json_encode($response));
                 echo(json_encode($horaireDisponible));
              }

              else{

                    
                // eliminer les plages bloquées dans lhoraire par defaut
                getHoraireFiltres($tabPlaning,$horaireFiltres);

                getHoraireFinal($horaireFiltres,$horaireFinal);
                
                //duree = 20; 9h:00,9h20,9h40....
                diviserHoraireFinalEnDureeDacte($response,$horaireFinal,$dureeActe);


               
                convertirTableauDeMinuteEnHeure($response);
                #convertirTableauDeMinuteEnHeure($horaireFinal);
                
                construireTableauRetour($response,$horaireDisponible);
                
                $horaireDisponible["success"] = 1;
                echo(json_encode($horaireDisponible));
              
              }





              }
              
            
              

          }
               
         else{
	       	   
             $response['success'] = 0;
             echo (json_encode($response));
	         }


          }
  

  ?>
