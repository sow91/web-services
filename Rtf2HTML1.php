<?php
	function replaceRTFFrenchChar($rtf_in) {
		$rtf_in = str_replace ( "\\'c9", "É", $rtf_in);
		$rtf_in = str_replace ( "\\'c9", "É", $rtf_in);
		$rtf_in = str_replace ( "\\'c8", "È", $rtf_in);
		$rtf_in = str_replace ( "\\'ca", "Ê", $rtf_in);
		$rtf_in = str_replace ( "\\'cb", "Ë", $rtf_in);
		$rtf_in = str_replace ( "\\'c0", "À", $rtf_in);
		$rtf_in = str_replace ( "\\'d4", "Ô", $rtf_in);
		$rtf_in = str_replace ( "\\'d9", "Ù", $rtf_in);
		$rtf_in = str_replace ( "\\'ce", "Î", $rtf_in);
		$rtf_in = str_replace ( "\\'cf", "Ï", $rtf_in);
		$rtf_in = str_replace ( "\\'e9", "é", $rtf_in);
		$rtf_in = str_replace ( "\\'e8", "è", $rtf_in);
		$rtf_in = str_replace ( "\\'ea", "ê", $rtf_in);
		$rtf_in = str_replace ( "\\'eb", "ë", $rtf_in);
		$rtf_in = str_replace ( "\\'e0", " à", $rtf_in);
		$rtf_in = str_replace ( "\\'e2", "â", $rtf_in);
		$rtf_in = str_replace ( "\\'f4", "ô", $rtf_in);
		$rtf_in = str_replace ( "\\'f9", "ù", $rtf_in);
		$rtf_in = str_replace ( "\\'fb", "û", $rtf_in);
		$rtf_in = str_replace ( "\\'ee", "î", $rtf_in);
		$rtf_in = str_replace ( "\\'ef", "ï", $rtf_in);
		$rtf_in = str_replace ( "\\'e7", "ç", $rtf_in);
		$rtf_in = str_replace ( "\\'80", "€", $rtf_in);
		$rtf_in = str_replace ( "\\'a3", "£", $rtf_in);
		$rtf_in = str_replace ( "\\'b5", "µ", $rtf_in);
		$rtf_in = str_replace ( "\\'a4", "¤", $rtf_in);
		$rtf_in = str_replace ( "\\'b2", "²", $rtf_in);
		$rtf_in = str_replace ( "\\rquote", "’", $rtf_in);
		$rtf_in = str_replace ( "\\'ab", "«", $rtf_in);
		$rtf_in = str_replace ( "\\'bb", "»", $rtf_in);
		$rtf_in = str_replace ( "\\}", "}", $rtf_in);
		$rtf_in = str_replace ( "\\{", "{", $rtf_in);
		return $rtf_in;
	}
	
	function SuppRTFBalises($rtf_in) {
		$rtf_in = ereg_replace("\\\\viewkind[0-9]", "", $rtf_in);
		$rtf_in = ereg_replace("\\\\uc[0-9]", "", $rtf_in);
		$rtf_in = ereg_replace("\\\\pard", "", $rtf_in);
		$rtf_in = ereg_replace("\\\\lang[0-9][0-9][0-9][0-9]", "", $rtf_in);
		$rtf_in = ereg_replace("\\\\cf[0-9]", "", $rtf_in);
		$rtf_in = ereg_replace("\\\\ulnone", "", $rtf_in);
		$rtf_in = ereg_replace("\\\\ul", "", $rtf_in);
		$rtf_in = ereg_replace("\\\\b0", "", $rtf_in);
		$rtf_in = ereg_replace("\\\\b", "", $rtf_in);
		$rtf_in = ereg_replace("\\\\ulnone", "", $rtf_in);
		$rtf_in = ereg_replace("\\\\i0", "", $rtf_in);
		$rtf_in = ereg_replace("\\\\i", "", $rtf_in);
		$rtf_in = ereg_replace("\\\\strike0", "", $rtf_in);
		$rtf_in = ereg_replace("\\\\strike", "", $rtf_in);
		$rtf_in = ereg_replace("\\\\f[0-9]", "", $rtf_in);
		$rtf_in = ereg_replace("\\\\fs[0-9][0-9]", "", $rtf_in);
		$rtf_in = ereg_replace("\\\\par ", "<br/>", $rtf_in);
		return $rtf_in;
	}
	
	function RTF2HTML($word) {		
		$rtfile = explode("\n", $word);
		$fileLength = count($rtfile);
		$result = "";
		$pos = strpos($rtfile[0], "{\\rtf1");
		if ($pos !== FALSE) {
			if(strpos($rtfile[1], "{\colortbl")!==FALSE){
				$index_deb = 2;
			} else {
				$index_deb = 1;
			}
			for($i=$index_deb;$i<$fileLength;$i++) {
				if($rtfile[$i] == "\\par }"){
					for($j=$index_deb;$j<$fileLength-1;$j++) {
						if($rtfile[$j]!==""){
							$result .= $rtfile[$j];
						}
					}
				} else {
					$rtfile[$i] = SuppRTFBalises($rtfile[$i]);
					$rtfile[$i] = replaceRTFFrenchChar($rtfile[$i]);
				}
			}
		} else {
			$result = "";
			for($i=0;$i<$fileLength;$i++) {
				$result .= $rtfile[$i]."<br/>";
			}
		}
		return $result;
	}
?>