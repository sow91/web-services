<?php

 # JSON array
$responseDef = array();
$responsePers = array();
$response = array();
$plageBloque = array();

$creanuxLibre = array();

# check fields
if (isset($_GET['praticienId']) && isset($_GET['day']) && isset($_GET['fautId']) ) {

	# get fields
	$praticienId = $_GET['praticienId'];
  $day = $_GET['day'];
	$fautId = $_GET['fautId']; 
	 
	    # include de connexion file 
	    require "db_connect.php";
      // include getHoraireDisponible
      include 'getHoraireDisponible.php';
      include 'getPlageBloque.php';
      include 'getPlageDisponible.php';
      include 'getCrenauxLibres.php';
	# new connexion
	$conn = new DB_CONNECT();
	
	#sql query

	$sql = "select a.ID_UTILISAT, a.NAME, a.PROPRIETE, a.HORAIRENOM, a.VALEUR, a.DATE_DEB, a.DATE_FIN, a.ID_FAUT_CHP
      FROM CONFIGHOURPLAN a where a.ID_UTILISAT=$praticienId and a.ID_FAUT_CHP=$fautId and a.NAME like '$day%'";
	$nombreLigne = 0;
  $nombreLignePerso = 0;
	# execute the query
	 $result = ibase_query($sql) or die(ibase_errmsg());
	
	     #array of hours
          $responseDef['hoursDef'] = array();
          $responsePers['hoursPerso'] = array();
          $response['hours'] = array();
          $plageBloque['plages'] = array();
          $creanuxLibre['hours'] = array();

	      while (($row = ibase_fetch_row($result))) {
	      //nombre of line
            $nombreLigne++;
            $horaireNom = utf8_encode(trim($row[3]));

           

            
            if ($horaireNom == "Horaires par défaut") {
            
            // default hour      
            $hourDef = array();
            // get the fields
            $hourDef['ID_UTILISAT'] = utf8_encode(trim($row[0]));
            $hourDef['NAME']=utf8_encode(trim($row[1]));
            $hourDef['PROPRIETE']=utf8_encode(trim($row[2]));
            $hourDef['HORAIRENOM'] = utf8_encode(trim($row[3]));

            $hourDef['VALEUR'] = utf8_encode(trim($row[4]));
            $hourDef['ID_FAUT_CHP']=utf8_encode(trim($row[7]));

            array_push($responseDef["hoursDef"], $hourDef);
            }
            else{
              //nombre of custum line
              $nombreLignePerso++;
              
              $hourPerso = array();
            // get the fields
            $hourPerso['ID_UTILISAT'] = utf8_encode(trim($row[0]));
            $hourPerso['NAME']=utf8_encode(trim($row[1]));
            $hourPerso['PROPRIETE']=utf8_encode(trim($row[2]));
            $hourPerso['HORAIRENOM'] = utf8_encode(trim($row[3]));

            $hourPerso['VALEUR'] = utf8_encode(trim($row[4]));
            $hourPerso['ID_FAUT_CHP']=utf8_encode(trim($row[7]));

            array_push($responsePers["hoursPerso"], $hourPerso);
            }

           
            /*$valeur = utf8_encode(trim($row[4]));
            $heure= (int)($valeur/60); 
			$min = $valeur%60; 

			#$hour['VALEUR1']=utf8_encode(trim($row[4]));	
			if ($valeur != 0) {
				$hour['VALEUR']=$heure."h".":".$min;
			}
			else {
				$hour['VALEUR']=0;
			}
*/            
            #$hour['DATE_DEB']=utf8_encode(trim($row[5]));
            #$hour['DATE_FIN']=utf8_encode(trim($row[6]));
            

            
            	
            
	       
	      }
          if ($nombreLigne != 0) {

            $indicateur = "vide";
            $fautBloque = -$_GET['fautId'];

            echo('horaire par defaut : '.json_encode($responseDef));
            echo('<br/>');
            echo('horaire personnalisé : '.json_encode($responsePers));




             // horaire personnalisé
             if ($nombreLignePerso != 0) 
             {

              $indicateur = "perso";

              $response['success'] = 1;

              // horaire default - horaire personnalisé
              getHoraireDisponible($responseDef,$responsePers,$response);


              echo('<br/>');
              echo('horaire def-pers : '.json_encode($response));


             }
             else{

              $indicateur = "default";
              $responseDef['success'] = 1;



             }



             if (getPlageBloque($plageBloque,$praticienId,$fautBloque,$day) == 1) {
               # code...

                if ($indicateur == "perso") {

                  echo('test : '.json_encode($response));
                  # code...
                 getCrenauxLibre($plageBloque, $response, $creanuxLibre);

                }
                else if($indicateur == "default"){

                  echo(json_encode($responseDef));
                  getCrenauxLibre($plageBloque, $responseDef, $creanuxLibre);
                }

                $creanuxLibre['success'] = 1;
                echo('horaire filtré : '.json_encode($creanuxLibre));
             }

             else{

                if ($indicateur == "perso") {
                  # code...

                  echo(json_encode($response));
                }
                else if ($indicateur == "default") {
                  # code...
                  echo(json_encode($responseDef));
                }
             }





            


	       }
	       else{
	       	$response['success'] = 0;
             echo (json_encode($response));
	       }

	 
	}





           
           
	
?>