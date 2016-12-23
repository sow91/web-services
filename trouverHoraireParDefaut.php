<?php
	
	function trouverHoraireParDefaut(&$responseDef,&$tabPlaning,&$cptDef){

		// Lundi11,Lundi12,Lundi21,Lundi22
		 if ($cptDef == 4) {

		 			// 09h-12h30 13h30-19h30/ 
                  if (($responseDef[0]==540) && ($responseDef[1] == 750) &&
                      ($responseDef[2] == 810) && ($responseDef[3] == 1170)) {
                    
                    //on bloque entre 12h30-13h30
                    for ($i=211; $i <270 ; $i++) { 
                      # code...
                      $tabPlaning[$i]="B";
                    }
                    //on bloque entre 19h30-20h
                    for ($i=631; $i <=660 ; $i++) { 
                      # code...
                      $tabPlaning[$i]="B";
                    }

                  }
                  
                  else{
                  	// 09h-20h
                    for ($i=0; $i <= 660; $i++) { 
                      
                      if (($responseDef[0] > $tabPlaning[$i])|| 
                      	  ($responseDef[3] < $tabPlaning[$i]) ||
						  (($responseDef[1] < $tabPlaning[$i]) &&
                           ($responseDef[2] > $tabPlaning[$i])))
						{
                        # code...
                        $tabPlaning[$i]="B";
                      }

                    }
                  }

                }
                // ex : 10h-15h
                else if ($cptDef == 2) {
                  # code...
                  for ($i=0; $i <= 660; $i++) { 
                      
                      if (($responseDef[0] > $tabPlaning[$i])||
                      	($responseDef[1] < $tabPlaning[$i])) {
                        # code...
                        $tabPlaning[$i]="B";
                      }

                    }
                }
	}

?>