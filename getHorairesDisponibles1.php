<?php

 # JSON array
$responseDef = array();
$responsePers = array();
$response = array();
$horairesDispo = array();
$horairesBloques = array();
$horairesDebloques = array();
$horairesRendezVous = array();
# check fields
if (isset($_GET['praticienId']) && isset($_GET['day']) && isset($_GET['fautId']) && isset($_GET['date'])) {

	# get fields
	$praticienId = $_GET['praticienId'];
  $day = $_GET['day'];
	$fautId =$_GET['fautId']; 
  
  // date format ex : 2016-03-07
  $date =  trim($_GET['date']);
  
	 
	    # include de connexion file 
	    require "db_connect.php";
      // include getHoraireDisponible
      include 'getHoraireDisponible.php';
      include 'convertValeurToHour.php';
      include 'getHoraireBloque.php';
      include 'getHoraireDebloque.php';
      include 'getHoraireRendezVous.php';
      include 'convertirMinuteEnHeure.php';

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
          $responseDef['hourDef'] = array();
          $responsePers['hoursPerso'] = array();
          $response['hours'] = array();
          $horairesDispo['hours'] = array();
          $horairesBloques['plagesBloques'] = array();
          $horairesDebloques['plagesDebloques'] = array();
          $horairesRendezVous['horaireRdv'] = array();
	      while (($row = ibase_fetch_row($result))) {
	      //numbre of line
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

            if ($hourDef['VALEUR'] != 0) {
              $hourDef['heure'] = convertirMinuteEnHeure(utf8_encode(trim($row[4])));
            }
            
            $hourDef['ID_FAUT_CHP']=utf8_encode(trim($row[7]));
            

            array_push($responseDef["hourDef"], $hourDef);
            }
            else{
              //numbre of custum line
              $nombreLignePerso++;
              
              $hourPerso = array();
            // get the fields
            $hourPerso['ID_UTILISAT'] = utf8_encode(trim($row[0]));
            $hourPerso['NAME']=utf8_encode(trim($row[1]));
            $hourPerso['PROPRIETE']=utf8_encode(trim($row[2]));
            $hourPerso['HORAIRENOM'] = utf8_encode(trim($row[3]));

            $hourPerso['VALEUR'] = utf8_encode(trim($row[4]));

            if ($hourPerso['VALEUR'] != 0) {
             $hourPerso['heure'] = convertirMinuteEnHeure(utf8_encode(trim($row[4])));
            }
            
            $hourPerso['ID_FAUT_CHP']=utf8_encode(trim($row[7]));


            array_push($responsePers["hoursPerso"], $hourPerso);
            }

           
           
            
            	
            
	       
	      }
          if ($nombreLigne != 0) {

            echo('horairePers'.json_encode($responsePers));
            echo('<br/>');
            echo('<br/>');
            echo('horaireDef'.json_encode($responseDef));
            echo('<br/>');
            echo('<br/>');

             // horaire personnalisé
             if ($nombreLignePerso != 0) 
             {
            
              // horaire default - horaire personnalisé
              getHoraireDisponible($responseDef,$responsePers,$response);

              
              convertValeurToHour($response,$horairesDispo);
              $horairesDispo['success'] = 1;
              echo('horaire def-pers : '.json_encode($horairesDispo));
              echo('<br/>');
              echo('<br/>');
              echo('<br/>');

             }
             else{

              
              convertValeurToHour($responseDef,$horairesDispo);
              $horairesDispo['success'] = 1;
              echo(json_encode($horairesDispo));


             }

             $acteIdB = -1;
             $patientIdB = -2;


             if (getHoraireBloque($horairesBloques,$praticienId,$patientIdB,$fautId,$acteIdB,$date) == 1) {
               # code...
            
             echo(json_encode($horairesBloques));
             echo('<br/>');
             echo('<br/>');
             }
             else{
              echo "pas de blocage";
             }

             $acteIdDeb=0;
             $patientIdDeb=-2;

              if (getHoraireDebloque($horairesDebloques,$praticienId,$patientIdDeb,$fautId,$acteIdDeb,$date) == 1) {
               # code...
            
             echo(json_encode($horairesDebloques));
             echo('<br/>');
             echo('<br/>');
             }
             else{
              echo "pas de deblocage";
             }

             $acteIdRdv=-1;
             $patientIdRdv=-2;


              if (getHoraireRendezVous($horairesRendezVous,$praticienId,$patientIdRdv,$fautId,$acteIdRdv,$date) == 1) {
               # code...
            
             echo(json_encode($horairesRendezVous));

             }
             else{
              echo "pas de rendez vous";
             }




             


	       }
	       else{
	       	   
             $horairesDispo['success'] = 0;
             echo (json_encode($horairesDispo));
	       }

	 
	}





           
           
	
?>