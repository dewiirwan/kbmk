<?php	
function GetShortDateWithDay($tgl){
	$str_date = GetShortDate($tgl);
	$str_day = GetDayDate($tgl);
	
	$str_full = $str_day.", ".$str_date;
	return $str_full;
}

function GetShortDateTimeWithDayEN($tgl){
	$str_date = GetFullDateFull($tgl, "ens");
	$str_day = GetDayDateEn($tgl);
	$str_full = $str_day.", ".$str_date;
	return $str_full;
}

function GetShortDateTimeWithDay($tgl){
	$str_date = GetFullDateFull($tgl, "ins");
	$str_day = GetDayDate($tgl);
	$str_full = $str_day.", ".$str_date;
	return $str_full;
}

function GetFullDateWithDay($tgl){
	$str_date = GetFullDate($tgl,"in");
	$str_day = GetDayDate($tgl);
	
	$str_full = $str_day.", ".$str_date;
	return $str_full;
}

function GetDayDate($tgl){
	$date[0] = "";
	$date[1] = "";
	$date[2] = "";
	$split_date = explode(" ", $tgl);
	$date = explode("-", $split_date[0]);
	$theday = date('w', mktime(0, 0, 0, intval($date[1]), intval($date[2]), intval($date[0])));
	$arr_day = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
	$str_day = $arr_day[$theday];
	return $str_day;
}

function GetDayDateEn($tgl){
	$date[0] = "";
	$date[1] = "";
	$date[2] = "";
	$split_date = explode(" ", $tgl);
	$date = explode("-", $split_date[0]);
	$theday = date('w', mktime(0, 0, 0, intval($date[1]), intval($date[2]), intval($date[0])));
	$arr_day = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");
	$str_day = $arr_day[$theday];
	return $str_day;
}

function GetFullDateFull($tgl, $lang = "in"){
	if(isset($tgl)){
		$date[0] = "";
		$date[1] = "";
		$date[2] = "";
		$split_date = explode(" ", $tgl);
		$date = explode("-", $split_date[0]);
		if(isset($split_date[1])){
			$jam = explode(":", $split_date[1]);
		}
		// language type
		switch($lang){
			case "en":	
				$arr_lang = array('00' => '-', '01' => 'January', '02' => 'February', '03' => 'Maret', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'Jule', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
				break;
			case "ens":	
				$arr_lang = array('00' => '-', '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec');
				break;
			case "ins":	
				$arr_lang = array('00' => '-', '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Ags', '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des');
				break;
			default:					
				$arr_lang = array('00' => '-', '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember');
				break;
		}
		// parse date
		if(!isset($jam[0]) OR !isset($jam[1]) OR !isset($jam[2])){
			$tgl = $date[2] . " " . $arr_lang[$date[1]] . " " . $date[0];
		}else{
			$tgl = $date[2] . " " . $arr_lang[$date[1]] . " " . $date[0] . "  " . $jam[0] . ":" . $jam[1] . ":" . $jam[2];
		}
	}
	// return
	return $tgl;	
}
function GetFullDate($tgl, $lang = "in"){
	if(isset($tgl)){
		$date[0] = "";
		$date[1] = "";
		$date[2] = "";
		$split_date = explode(" ", $tgl);
		$date = explode("-", $split_date[0]);
		if(isset($split_date[1])){
			$jam = explode(":", $split_date[1]);
		}
		// language type
		switch($lang){
			case "en":	
				$arr_lang = array('00' => '-', '01' => 'January', '02' => 'February', '03' => 'Maret', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'Jule', '08' => 'Agustus', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
				break;
			case "ens":	
				$arr_lang = array('00' => '-', '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec');
				break;
			case "ins":	
				$arr_lang = array('00' => '-', '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Ags', '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des');
				break;
			default:					
				$arr_lang = array('00' => '-', '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember');
				break;
		}
		// parse date
		if(!isset($jam[0]) OR !isset($jam[1]) OR !isset($jam[2])){
			$tgl = $date[2] . " " . $arr_lang[$date[1]] . " " . $date[0];
		}else{
			$tgl = $date[2] . " " . $arr_lang[$date[1]] . " " . $date[0] . " | " . $jam[0] . ":" . $jam[1] ; // . ":" . $jam[2];
		}
	}
	// return
	return $tgl;	
}

function GetOnlyDate($tgl, $lang = "in"){
	if(isset($tgl)){
		$date[0] = "";
		$date[1] = "";
		$date[2] = "";
		$split_date = explode(" ", $tgl);
		$date = explode("-", $split_date[0]);
		// language type
		switch($lang){
			case "en":	
				$arr_lang = array('00' => '-', '01' => 'January', '02' => 'February', '03' => 'Maret', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'Jule', '08' => 'Agustus', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
				break;
			case "ens":	
				$arr_lang = array('00' => '-', '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Ags', '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec');
				break;
			case "ins":	
				$arr_lang = array('00' => '-', '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Ags', '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des');
				break;
			default:					
				$arr_lang = array('00' => '-', '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember');
				break;
		}
		// parse date
		$tgl = $date[2] . " " . $arr_lang[$date[1]] . " " . $date[0];
	}
	// return
	return $tgl;	
}

function GetShortDate($tgl){
	if(isset($tgl) AND !empty($tgl)){
		$date[0] = "";
		$date[1] = "";
		$date[2] = "";
		$jam = '';
		$split_date = explode(" ", $tgl);
		$date = explode("-", $split_date[0]);
		if(isset($split_date[1])){
			$jam = explode(":", $split_date[1]);
		}
		// parse date
		if(!isset($jam[0]) OR !isset($jam[1]) OR !isset($jam[2])){
			$tgl = $date[2] . "/" . $date[1] . "/" . $date[0];
		}else{
			$tgl = $date[2] . "/" . $date[1] . "/" . $date[0] . " " . $jam[0] . ":" . $jam[1] ; //. ":" . $jam[2];
		}
	}
	// return
	return $tgl;	
}


function GetMonth($m='', $lang=''){

		$m = (strlen($m) < 2) ? '0'.$m : $m ;

		switch($lang){
			case "en":	
				$arr_lang = array('00' => '-', '01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
				break;
			case "ens":	
				$arr_lang = array('00' => '-', '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Ags', '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec');
				break;
			case "ins":	
				$arr_lang = array('00' => '-', '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Ags', '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des');
				break;
			default:					
				$arr_lang = array('00' => '-', '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember');			
			
		}
		
		return 	$arr_lang[$m];


}


function dateRev($date){
	$date = explode("-",$date);
	return $date[2].'-'.$date[1].'-'.$date[0];
}

?>