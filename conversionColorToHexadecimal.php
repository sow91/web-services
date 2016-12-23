<?php
	
	function getColorActe($couleur){
	  
	  $red = $couleur % 256;
	  $RColor = $couleur / 256;
	  $green = $RColor % 256;
	  $GColor = $RColor / 256;
	  $blue = $GColor % 256;
	  
	  //return "#".$red." ".$green." ".$blue;
	  $codehexa = "#";
	  if($red < 16){ $codehexa .= "0".dechex($red); }else{ $codehexa .= dechex($red); };
	  if($green < 16){ $codehexa .= "0".dechex($green); }else{ $codehexa .= dechex($green); };
	  if($blue < 16){ $codehexa .= "0".dechex($blue); }else{ $codehexa .= dechex($blue); };
	  
	  return $codehexa;
		}
?>