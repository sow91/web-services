<?php

 # tableau de reponse JSON 
$response = array();
# verifier les données envoyées par la method POST
if (isset($_POST['email'])) {
	# recuperer l'email
	$email = $_POST['email'];
	
	
	# inclure le fichier de connexion 
	require "db_connect.php";
  
	# connexion à la BD
	$conn = new DB_CONNECT();
	
	#requête sql

	$sql = "select id_personne, per_nom, per_type, pers_titre, per_prenom, per_genre,oi_profil,oi_mdp from personne where PER_EMAIL='".str_replace("'","''",$email)."' and OI_AUTORISATION=1";
	# execution de la requête
	 $result = ibase_query($sql) or die(ibase_errmsg());
	     #recuperer la reponse
           $row = ibase_fetch_row($result);
           if ($row) {
           	//recuperer le password
           	 $password = $row['oi_mdp'];
           	 $subject = 'Your Recovery password';
           	 $message = 'this is Your password'.$password;
           	 $cus_mail = 'support@xyz.in';

           	 $to = 'soabdoulaye91@gmail.com';
           	
           	 $headers = 'MIME-Version : 1.0'. "\r\n";
           	 $headers .= 'Content-type : text/html; charset = iso-8859-1' .	"\r\n";
           	 $headers .= "From: ".$cus_mail."\r\n";
           	 if(mail($to, $subject, $message, $headers))
           	 {           	
           	 	$response['success'] = 1;
           	 	$response['message'] = "un email a été envoyé dans votre boite veuillez verifier SVP";
           	 }
           	 else{
           	 	$response['success'] = 0;
           	 	$response['message'] = "veuillez verifier votre connexion internet";
           	 }
           	 
           	//on convertit le tableau en JSON
             echo (json_encode($response));
	 	      
	       }
	 else {
	 	$response['success'] = 0;
	 	$response['message'] = "Veuillez entrer un email correct SVP";
 	    //on convertit le tableau en JSON
	 	echo (json_encode($response));
	  }
	}
	
?>
