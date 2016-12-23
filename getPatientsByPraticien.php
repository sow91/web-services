<?php

 # tableau de reponse JSON 
$response = array();
# verifier les données envoyées par la method GET
if (isset($_GET['praticienId']) && isset($_GET['sText'])) {
	# recuperer le login et le password
	$praticienId = $_GET['praticienId'];
	$sText = $_GET['sText'];
	

	
	# inclure le fichier de connexion 
	require "db_connect.php";
  
	# connexion à la BD
	$conn = new DB_CONNECT();
      
      #requête sql
	// patient num dossier
	if (is_numeric($sText)) {
	// search by num dossier
	$sql = "select pat.id_personne, per_nom, per_type, pers_titre, per_prenom, per_genre,oi_profil, per_datnaiss, pat_numdossier from personne pers, patient pat where
	 pers.id_personne=pat.id_personne and pat.PER5_ID_PERSONNE='$praticienId' and pat.pat_numdossier=$sText";

	}
	else{

	// $Text to uppercase
	$sTextUperCase = strtoupper($sText);
	// $Text to lowerCase
	$sTextLowerCase = strtolower($sText);

	//search ny nom or by prenom
	$sql = "select pat.id_personne, per_nom, per_type, pers_titre, per_prenom, per_genre,oi_profil, per_datnaiss, pat_numdossier  from personne pers, patient pat where
	 pers.id_personne=pat.id_personne and pat.PER5_ID_PERSONNE='$praticienId' and ((per_nom LIKE '$sTextUperCase%' or per_prenom LIKE '$sTextUperCase%')
	 or (per_nom LIKE '$sTextLowerCase%' or per_prenom LIKE '$sTextLowerCase%'))";
	}	
	

	
	# execution de la requête
	 $result = ibase_query($sql) or die(ibase_errmsg());
	 $nombreLigne = 0;
	     #recuperer la reponse
          $response['personnes'] = array();
	 	while ($row = ibase_fetch_row($result)) {	
	 		// compter le nombre de ligne
	 		$nombreLigne++;
	 		//print_r($row);
	 		
           	// récuperer les champs

           	// tableau personne
           	$personne = array();
           	$personne['id_personne'] = utf8_encode(trim($row[0]));
          	$personne['per_nom']= utf8_encode(trim($row[1]));
            $personne['per_type']= utf8_encode(trim($row[2]));
            $personne['pers_titre']= utf8_encode(trim($row[3]));
            $personne['per_prenom']= utf8_encode(trim($row[4]));
            $personne['per_genre']= utf8_encode(trim($row[5]));
            $personne['oi_profil']= utf8_encode(trim($row[6]));

            $dateNais = trim($row[7]);
           	$jour = substr($dateNais, "8", "2");
			$mois = substr($dateNais, "5", "2");
			$annee = substr($dateNais, "0", "4");
			$heure = substr($dateNais, "11", "5");

			// current date
			$today = date("Y-m-d H:i:s"); 
			$currentYear = substr($today, "0", "4");  
	 		$personne['per_datnaiss'] = ($currentYear-$annee)." "."ans";
            $personne['pat_numdossier']= utf8_encode(trim($row[8]));


                   
           
            array_push($response["personnes"], $personne);
                 
	       }
	       if ($nombreLigne != 0) {
	       $response['success'] = 1;
	       //on convertit le tableau en JSON
             echo (json_encode($response));
	       }
	       else{
	       	$response['success'] = 0;
	       //on convertit le tableau en JSON
             echo (json_encode($response));
	       }

	       

	 
	}





           
           
	
?>