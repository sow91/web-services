<?php

 # JSON array
$response = array();
# check 
if (isset($_GET['patientId']) && isset($_GET['praticienId'])) {
	
	$patientId = $_GET['patientId'];
	$praticienId = $_GET['praticienId'];
	
	
	# include de connexion file 
	require "db_connect.php";
	include 'convertirMinuteEnHeure.php';
	include "conversionColorToHexadecimal.php";
  	$nombreLigne = 0;
	# new connexion
	$conn = new DB_CONNECT();

	
	#sql query


	 $sql = "select id_rdv, rdv_date, per_nom, per_prenom, acte_libelle, rdv_duree, acte_couleur   
		  from personne p, rendez_vous rdv, actes a where p.id_personne = rdv.id_personne and
		  rdv.id_acte = a.id_acte and rdv.id_personne ='$patientId' and rdv.per_id_personne='$praticienId' order by rdv_date desc";



	# execute the query
	 $result = ibase_query($sql) or die(ibase_errmsg());
	
	    
          $response['rendezVous'] = array();

	      while ($row = ibase_fetch_row($result)) {
	      	
	 		$nombreLigne++;
           
           	$rendezVous = array();
           	
           	$idRdv = utf8_encode(trim($row[0]));
           	$dateRdv = utf8_encode(trim($row[1]));
           	
           	$jour = substr($dateRdv, "8", "2");
			$mois = substr($dateRdv, "5", "2");
			$annee = substr($dateRdv, "0", "4");
			$heure = substr($dateRdv, "11", "2");
           	$minute = substr($dateRdv, "14", "2");
           	$duree = trim($row[5]);

           	$heureDebut = convertirMinuteEnHeure($heure*60+$minute);
           	$heureFin = convertirMinuteEnHeure(($heure*60+$minute)+$duree);

           	$rendezVous['idRdv'] = $idRdv;
           	$rendezVous['per_nom']= utf8_encode(trim($row[2]));
           	$rendezVous['per_prenom']= utf8_encode(trim($row[3]));
           	$rendezVous['acte_libelle']= utf8_encode(trim($row[4]));
           	$rendezVous['acte_couleur']= getColorActe(utf8_encode($row[6]));
			$rendezVous['heureDebut'] = $heureDebut;
			$rendezVous['heureFin'] = $heureFin;






            array_push($response["rendezVous"], $rendezVous);
            
             
	      }

	      if ($nombreLigne!=0) {
	       
	       $response['success'] = 1;
	       echo (json_encode($response));
	       }

	      else{
	       	$response['success'] = 0;
            echo (json_encode($response));
	       }

	       

	 
	}





           
           
	
?>