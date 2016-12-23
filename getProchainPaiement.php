<?php

 # JSON array
$response = array();
# check id patient
if (isset($_GET['patientId'])) {
	# get id patient
	$patientId = $_GET['patientId'];
	
	 $nombreLigne = 0;
	# include de connexion file 
	require "db_connect.php";
  
	# new connexion
	$conn = new DB_CONNECT();
	

	// current date
	$format_date = 'd.m.y H:i:s';
	$today = date($format_date, time());

	$day = substr($today, "0", "2");
	$month = substr($today, "3", "2");
	$year = (substr($today, "6", "2")+2000);
	

	
	
	
	$variableTest = 0;






	#sql query

	$sql = "select id_plan, date_rens, libelle, montant_euro, montant_encais_euro, (montant_euro-montant_encais_euro)
	from plan_applique pa where pa.id_patient='$patientId' order by date_rens desc";
	# execute the query
	 $result = ibase_query($sql) or die(ibase_errmsg());
	
	     #array of paiement
          $response['paiement'] = array();
	      while (($row = ibase_fetch_row($result))) {
	      	#print_r($row);
	 		
           
           	

          	$dateProchainPaiement = trim($row[1]);
           	$jour = substr($dateProchainPaiement, "8", "2");
			$mois = substr($dateProchainPaiement, "5", "2");
			$annee = substr($dateProchainPaiement, "0", "4");
			


			if (($jour > $day) && ($mois >= $month) && ($annee >= $year)) {
				
				$variableTest = 1;
			

			}
			else if ((($mois > $month) && ($annee >= $year)) || ($annee > $year)){

				$variableTest = 1;

			}




			if ($variableTest == 1) {

			$variableTest = 0;
			$prochainPaiement = array();
           	$prochainPaiement['id_plan'] = $row[0];
           	

			$prochainPaiement['date']= "$jour/$mois/$annee";
            $prochainPaiement['libelle']=utf8_encode(trim($row[2]));
            $prochainPaiement['montant']="Montant : ".utf8_encode(trim($row[3]))." €";
            $prochainPaiement['paye']="Payé : ".utf8_encode(trim($row[4]))." €";
            $prochainPaiement['reste_a_paye']="A Payé : ".utf8_encode(trim($row[5]))." €";
            array_push($response["paiement"], $prochainPaiement);	
            $nombreLigne++;
            }

	       
	      }
          if ($nombreLigne != 0) {
	       $response['success'] = 1;
	       //on convertit le tableau en JSON
             echo (json_encode($response));
	       }
	       else{
	       	$response['success'] = 0;
	       //on convertit le tableau en JSON
	       	$response['message'] = "Pas de paiement pour vous";
             echo (json_encode($response));
	       }






	       

	 
	}





           
           
	
?>