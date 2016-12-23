<?php

 # tableau de reponse JSON 
$response = array();
# verifier les données envoyées par la method POST
if (isset($_POST['username']) && isset($_POST['pwd'])) {
	# recuperer le login et le password
	$login = utf8_encode(trim($_POST['username']));
	$pwd = utf8_encode(trim($_POST['pwd']));
	
	# inclure le fichier de connexion 
	require "db_connect.php";
  
	# connexion à la BD
	$conn = new DB_CONNECT();
	
	#requête sql

	$sql = "select id_personne, per_nom, per_type, pers_titre, per_prenom, per_genre,oi_profil from personne where OI_LOGIN='".str_replace("'","''",$login)."' and OI_MDP='$pwd' and OI_AUTORISATION=1";
	# execution de la requête
	 $result = ibase_query($sql) or die(ibase_errmsg());
	     #recuperer la reponse
           $row = ibase_fetch_row($result);
           if ($row) {
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
            // success
            $response['success'] = 1;
            $response['personne'] = array();
            array_push($response["personne"], $personne);
           
             
           	//on convertit le tableau en JSON
             echo (json_encode($response));
	 	      
	       }
	 else {
	 	$response['success'] = 0;
	 	$response['message'] = "login/pwd incorrect";
 	    //on convertit le tableau en JSON
	 	echo (json_encode($response));
	  }
	}
	
?>