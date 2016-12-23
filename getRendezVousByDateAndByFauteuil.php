	<?php

	 # JSON array
	$response = array();
	# check  
	if (isset($_GET['praticienId']) && isset($_GET['fautId']) && isset($_GET['dateRdv']))
		 {
		# get fields
		$praticienId = trim($_GET['praticienId']);
		$fautId = trim($_GET['fautId']);
		// date format ex : 2016-03-07
		$date =  trim($_GET['dateRdv']);
		// day 
		$day = substr($date, "8", "2");
		// month
		$month = substr($date, "5", "2");
		// year
		$year = substr($date, "0", "4");
	  





		$nombreLigne = 0;
		
		# include de connexion file 
		require "db_connect.php";
	  	include "conversionColorToHexadecimal.php";
		# new connexion
		$conn = new DB_CONNECT();
		
		
	    $sql = "select distinct rdv_date, per_nom, per_prenom, acte_libelle, rdv_duree, acte_couleur   
		  from personne p, rendez_vous rdv, actes a, fauteuil f where p.id_personne = rdv.id_personne and
		  rdv.id_acte = a.id_acte and rdv.id_fauteuil = '$fautId' and rdv.per_id_personne='$praticienId'";
		
		# execute the query
		 $result = ibase_query($sql) or die(ibase_errmsg());
		
		     #array of rendezVousByDate
	          $response['rendezVousByDate'] = array();
		      while ($row = ibase_fetch_row($result)) {
		      
		 		
	           
	           	$rendezVousByDate = array();
	           	// get the fields
	           	$dateRdv=trim($row[0]);
	           	$jour = substr($dateRdv, "8", "2");
				$mois = substr($dateRdv, "5", "2");
				$annee = substr($dateRdv, "0", "4");
				$heure = substr($dateRdv, "11", "5");
		



				$rendezVousByDate['rdv_date']=$dateRdv;
				
				
				if (($jour == $day) &&
					($mois == $month) &&
					($annee == $year)) {
					# code...
				$nombreLigne++;
			    $rendezVousByDate['per_nom']= utf8_encode(trim($row[1]));
			    $rendezVousByDate['per_prenom']= utf8_encode(trim($row[2]));

				$rendezVousByDate['acte_libelle']= utf8_encode(trim($row[3]));
	            $rendezVousByDate['rdv_duree']= utf8_encode(trim($row[4]));
	            $rendezVousByDate['acte_couleur']= getColorActe(utf8_encode($row[5]));
	            $rendezVousByDate['rdv_heureDeb']= utf8_encode($heure);
	            $duree = trim($row[4]);
	            // add duree to heureDeb for getting heureFin
	            $h = explode(":", $heure );
	            $h1 = ((($h[0]*60+$h[1])+$duree)*60);
	            
	            $rendezVousByDate['rdv_heureFin']= gmdate("H:i", $h1);

	           
	            array_push($response["rendezVousByDate"], $rendezVousByDate);
	           
				}

	     	
		      }
		      if ($nombreLigne != 0) {
		       $response['success'] = 1;
		       //on convertit le tableau en JSON
	             echo (json_encode($response));

	             echo $nombreLigne;
		       }
		       else{
		       	$response['success'] = 0;
		       //on convertit le tableau en JSON
		       	$response['message'] = "Pas de rendez vous pour cette date";
	             echo (json_encode($response));
		       }


   

		 
		}






	           
	           
		
	?>











