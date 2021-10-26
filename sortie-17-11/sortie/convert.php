<?php
//require_once("../Base.php");
	
	class chiffreEnLettre {
	/**
011	* fonction permettant de transformer une valeur num�rique en valeur en lettre
012	* @param int $Nombre le nombre a convertir
013	* @param int $Devise (0 = aucune, 1 = Euro �, 2 = Dollar $)
	* @param int $Langue (0 = Fran�ais, 1 = Belgique, 2 = Suisse)
	* @return string la chaine
	*/
	public function ConvNumberLetter($Nombre, $Devise, $Langue) {
	$dblEnt=''; $byDec='';
	$bNegatif='';
	$strDev = '';
	$strCentimes = '';
	 
	if( $Nombre < 0 ) {
	$bNegatif = true;
	$Nombre = abs($Nombre);
	 
	}
	$dblEnt = intval($Nombre) ;
//	echo $Nombre ."   ".$dblEnt;
	//if($dblEnt<>intval($Nombre)) $dblEnt=$dblEnt+1; 
	//echo $Nombre ."   ".$dblEnt;
	$byDec = round(($Nombre - $dblEnt) * 100) ;
	
	if($byDec==100) $dblEnt=$dblEnt+1; 
	if( $byDec == 0 ) {
	if ($dblEnt > 999999999999999) {
	return "#TropGrand" ;
	}
	}
	else {
	if ($dblEnt > 9999999999999.99) {
	return "#TropGrand" ;
	}
	}
	switch($Devise) {
	case 0 :
	if ($byDec > 0) $strDev = " et " ;
	break;
	case 1 :
	$strDev = " Dinars" ;
	if ($byDec > 0){ $strCentimes = $strCentimes . " Centimes";$strDev = " Dinars et" ; }
	
	break;
	case 2 :
	$strDev = " Dollar" ;
	if ($byDec > 0) $strCentimes = $strCentimes . " Cent" ;
	
	break;
	}
	if (($dblEnt > 1) && ($Devise != 0)) $strDev = $strDev . "" ;

	$NumberLetter = $this->ConvNumEnt(floatval($dblEnt), $Langue) . $strDev . " " . $this->ConvNumDizaine($byDec, $Langue) . $strCentimes ;
	
	return $NumberLetter;
	}
	 
	private function ConvNumEnt($Nombre, $Langue) {
	$byNum=$iTmp=$dblReste='' ;
	$StrTmp = '';
	$NumEnt='' ;
	$iTmp = $Nombre - (intval($Nombre / 1000) * 1000) ;
	$NumEnt = $this->ConvNumCent(intval($iTmp), $Langue) ;
	$dblReste = intval($Nombre / 1000) ;
	$iTmp = $dblReste - (intval($dblReste / 1000) * 1000) ;
	$StrTmp = $this->ConvNumCent(intval($iTmp), $Langue) ;
	switch($iTmp) {
	case 0 :
	break;
	case 1 :
	$StrTmp = "mille " ;
	break;
	default :
	$StrTmp = $StrTmp . " mille " ;
	}
	$NumEnt = $StrTmp . $NumEnt ;
	$dblReste = intval($dblReste / 1000) ;
	$iTmp = $dblReste - (intval($dblReste / 1000) * 1000) ;
	$StrTmp = $this->ConvNumCent(intval($iTmp), $Langue) ;
	switch($iTmp) {
	case 0 :
	break;
	case 1 :
	$StrTmp = $StrTmp . " million " ;
	break;
	default :
	$StrTmp = $StrTmp . " millions " ;
	}
	$NumEnt = $StrTmp . $NumEnt ;
	$dblReste = intval($dblReste / 1000) ;
	$iTmp = $dblReste - (intval($dblReste / 1000) * 1000) ;
	$StrTmp = $this->ConvNumCent(intval($iTmp), $Langue) ;
	switch($iTmp) {
	case 0 :
	break;
	case 1 :
	$StrTmp = $StrTmp . " milliard " ;
	break;
	default :
	$StrTmp = $StrTmp . " milliards " ;
	}
	$NumEnt = $StrTmp . $NumEnt ;
	$dblReste = intval($dblReste / 1000) ;
	$iTmp = $dblReste - (intval($dblReste / 1000) * 1000) ;
	$StrTmp = $this->ConvNumCent(intval($iTmp), $Langue) ;
	switch($iTmp) {
	case 0 :
	break;
	case 1 :
	$StrTmp = $StrTmp . " billion " ;
	break;
	default :
	$StrTmp = $StrTmp . " billions " ;
	}
	$NumEnt = $StrTmp . $NumEnt ;
	return $NumEnt;
	}
	 
	private function ConvNumDizaine($Nombre, $Langue) {
	$TabUnit=$TabDiz='';
	$byUnit=$byDiz='' ;
	$strLiaison = '' ;
	 
	 
	$TabUnit = array("", "un", "deux", "trois", "quatre", "cinq", "six", "sept",
	"huit", "neuf", "dix", "onze", "douze", "treize", "quatorze", "quinze",
	"seize", "dix-sept", "dix-huit", "dix-neuf") ;
	$TabDiz = array("", "", "vingt", "trente", "quarante", "cinquante",
	"soixante", "soixante", "quatre-vingt", "quatre-vingt","zero") ;
	if ($Langue == 1) {
	$TabDiz[7] = "septante" ;
	$TabDiz[9] = "nonante" ;
	}
	else if ($Langue == 2) {
	$TabDiz[7] = "septante" ;
	$TabDiz[8] = "huitante" ;
	$TabDiz[9] = "nonante" ;
	}
	$byDiz = intval($Nombre / 10) ;
	$byUnit = $Nombre - ($byDiz * 10) ;
	$strLiaison = "-" ;
	if ($byUnit == 1) $strLiaison = " et " ;
	
	switch($byDiz) {
	case 0 :
	$strLiaison = "" ;
	break;
	case 1 :
	$byUnit = $byUnit + 10 ;
	$strLiaison = "" ;
	break;
	case 7 :
	if ($Langue == 0) $byUnit = $byUnit + 10 ;
	break;
	case 8 :
	if ($Langue != 2) $strLiaison = "-" ;
	break;
	case 9 :
	if ($Langue == 0) {
	$byUnit = $byUnit + 10 ;
	$strLiaison = "-" ;
	}
	break;
	}
	$NumDizaine = $TabDiz[$byDiz] ;
	if ($byDiz == 8 && $Langue != 2 && $byUnit == 0) $NumDizaine = $NumDizaine . "s" ;
	if ($TabUnit[$byUnit] != "") {
	$NumDizaine = $NumDizaine . $strLiaison . $TabUnit[$byUnit] ;
	}
	else {
	$NumDizaine = $NumDizaine ;
	}
	return $NumDizaine;
	}
	 
	private function ConvNumCent($Nombre, $Langue) {
	$TabUnit='' ;
	$byCent=$byReste='' ;
	$strReste = '' ;
	$NumCent='';
	$TabUnit = array("", "un", "deux", "trois", "quatre", "cinq", "six", "sept","huit", "neuf", "dix") ;
	 
	$byCent = intval($Nombre / 100) ;
	$byReste = $Nombre - ($byCent * 100) ;
	$strReste = $this->ConvNumDizaine($byReste, $Langue);
	switch($byCent) {
	case 0 :
	$NumCent = $strReste ;
	break;
	case 1 :
	if ($byReste == 0)
	$NumCent = "cent" ;
	else
	$NumCent = "cent " . $strReste ;
	break;
	default :
	if ($byReste == 0)
	$NumCent = $TabUnit[$byCent] . " cents" ;
	else
	$NumCent = $TabUnit[$byCent] . " cent " . $strReste ;
	}
	return $NumCent;
	}
	}
	?>
