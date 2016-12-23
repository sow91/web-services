<?php

 # tableau de reponse JSON 
$response = array();

# verifier les données envoyées par la method POST
if (isset($_POST['email'])) {
	# recuperer l'email
	$email = utf8_encode(trim($_POST['email']));
	
	
	# inclure le fichier de connexion 
	require "db_connect.php";
  #inclure la bibliothèque de swiftmailer
  require_once "swiftmailer\lib\swift_required.php";
	# connexion à la BD
	$conn = new DB_CONNECT();
	
	#requête sql

	$sql = "select id_personne, per_nom, per_type, pers_titre, per_prenom, per_genre,oi_profil,oi_login,oi_mdp from personne where PER_EMAIL='".$email."' and OI_AUTORISATION=1";
	# execution de la requête
	 $result = ibase_query($sql) or die(ibase_errmsg());
	     #recuperer la reponse
           $row = ibase_fetch_row($result);
           #print_r($row);
           if ($row != null) {
           	//recuperer le password
            
           	 
             $per_nom = $row[1];
             $username = $row[7];
             $password = $row[8];
             $body = 'Bonjour Mr'." ".$per_nom.'votre username :'.$username." ".'password :'.$password;


      
           
             
           
             //creer le transport en indiquand le nom_serveur_smtp, numero de port
             //en indiquant le login_serveur_smtp et le password_serveur_smtp
             $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
             ->setUsername('orthalis2016@gmail.com')
             ->setPassword('Orthalis2017');

             //creer le mailer pour le transport du message
             $mailer = Swift_Mailer::newInstance($transport);
             //créer le message à envoyer en indiquant setFrom(email expediteur) et setTo(email dest) 
             $message = Swift_Message::newInstance('web leads')
             ->setFrom(array('orthalis2016@gmail.com'=>'Admin'))
             ->setTo(array($email=>$per_nom))
             ->setSubject('Recupération de mot de passe')
             ->setBody($body,'text/html');

             //l'envoie du message
             $result = $mailer->send($message);
             if ($result) {
             $response['success'] = 1;
             $response['message'] ="le mot de passe a été envoyé dans votre gmail"; 
               
             }
             else{
             $response['success'] = 1;
             $response['message'] =" problème de connexion au serveur de messagerie"; 
             }

             echo(json_encode($response));      

            }
            else{
              $response['success'] = 0;
              $response['message'] ="Email Invalid";
              echo(json_encode($response)); 
            }
    }

    





?>
