  <?php

   # JSON array
  $response = array();
  # check id patient
  if (isset($_GET['patientId'])) {
  	# get id patient
  	$patientId = $_GET['patientId'];
  	
  	
  	# include de connexion file 
  	require "db_connect.php";

  	# include the rtf file
    	include('Rtf2HTML.php');
  	# new connexion
  	$conn = new DB_CONNECT();

     # new Rtf Reader    
     $reader = new RtfReader();
      
  	
  	#sql query
  	$sql = "select date_comm, nom_doc, fait, afaire from zone_comm where id_pat='$patientId' order by date_comm desc";
  				
  	# execute the query
  	 $result = ibase_query($sql) or die(ibase_errmsg());
  	 $nombreLigne = 0;
  	     #array of commentaire clinique
            $response['commentaireClinique'] = array();

  	      while($row = ibase_fetch_row($result, IBASE_TEXT)) {
  	      	#print_r($row);
             // compter le nombre de ligne
              $nombreLigne++;
            	$commentaireClinique = array();
             	// get the fields
             	

                $dateComm = utf8_encode(trim($row[0]));
                $jour = substr($dateComm, "8", "2");
                $mois = substr($dateComm, "5", "2");
                $annee = substr($dateComm, "0", "4");
                $heure = substr($dateComm, "11", "5");
                $commentaireClinique['jour'] = $jour;
                $commentaireClinique['mois'] = $mois;
                $commentaireClinique['annee'] = $annee;
                $commentaireClinique['heure'] = $heure;

              $commentaireClinique['date_comm'] ="$jour/$mois/$annee";
             	
             	# parse the rtf string
              $reader->Parse(trim($row[2]));
              #$reader->root->dump(); // to see what the reader read
              $formatter = new RtfHtml();
              $fait = $formatter->Format($reader->root);


             	$commentaireClinique['fait']      ="Fait : ".utf8_encode(trim($fait));
             	# parse the rtf string
              $reader->Parse(trim($row[3]));
              # $reader->root->dump(); // to see what the reader read
              $formatter = new RtfHtml();
              $afaire = $formatter->Format($reader->root);


             	$commentaireClinique['afaire']    = "A Faire : ".utf8_encode(trim($afaire));

            
             
             array_push($response["commentaireClinique"], $commentaireClinique);
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