<?php
  
  function getHoraireFiltres(&$tabPlaning,&$horaireFiltres){

    $j=0;

    for ($i=0; $i < sizeof($tabPlaning) ; $i++) { 
      # code...
      if ($tabPlaning[$i] != "B") {
        # code...
        $horaireFiltres[$j++] = $tabPlaning[$i];
        #$horaireFiltres[$j++] = convertirMinuteEnHeure($tabPlaning[$i]);


      }
    }
  }

?>










                    
