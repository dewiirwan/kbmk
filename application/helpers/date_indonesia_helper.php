<?php // test_helper.php
if(!defined('BASEPATH')) exit('No direct script access allowed');

function date_indonesia($format = 'd F, Y',$timestamp = NULL)
{
    $l = array('', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu', 'Minggu');
    $F = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

    $return = '';
    if(is_null($timestamp)) { $timestamp = mktime(); }
    for($i = 0, $len = strlen($format); $i < $len; $i++) {
        switch($format[$i]) {
            case '\\' :
                $i++;
                $return .= isset($format[$i]) ? $format[$i] : '';
                break;
            case 'l' :
                $return .= $l[date('N', $timestamp)];
                break;
            case 'F' :
                $return .= $F[date('n', $timestamp)];
                break;
            default :
                $return .= date($format[$i], $timestamp);
                break;
        }
    }
    return $return;
}

function tanggal_indo($tanggal, $cetak_hari = false)
{
    $hari = array ( 1 =>    'Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                'Jumat',
                'Sabtu',
                'Minggu'
            );
            
    $bulan = array (1 =>   'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            );
    $split    = explode('-', $tanggal);
    $tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
    
    if ($cetak_hari) {
        $num = date('N', strtotime($tanggal));
        return $hari[$num] . ', ' . $tgl_indo;
    }
    return $tgl_indo;
}

function get_nama_bulan($month)
{
    $bulan = array('01' =>'Januari', '02' =>'Februari', '03' =>'Maret', '04' =>'April', '05' =>'Mei', '06' =>'Juni', '07' =>'Juli', '08' =>'Agustus', '09' =>'September', '10' =>'Oktober', '11' =>'November', '12' =>'Desember');

    return $bulan[''.$month.''];
}

function get_nama_hari($tanggal){

    $hari = date('D', strtotime($tanggal));
 
    switch($hari){
        case 'Sun':
            $nama_hari = "Minggu";
        break;
 
        case 'Mon':         
            $nama_hari = "Senin";
        break;
 
        case 'Tue':
            $nama_hari = "Selasa";
        break;
 
        case 'Wed':
            $nama_hari = "Rabu";
        break;
 
        case 'Thu':
            $nama_hari = "Kamis";
        break;
 
        case 'Fri':
            $nama_hari = "Jumat";
        break;
 
        case 'Sat':
            $nama_hari = "Sabtu";
        break;
        
        default:
            $nama_hari = "Tidak di ketahui";     
        break;
    }

    return $nama_hari;
}

function indonesian_date($timestamp = '', $date_format = 'l, j F Y | H:i', $suffix = 'WIB') {
	if($timestamp)
	{
		if (trim ($timestamp) == '')
		    {
			  $timestamp = time ();
		  }
		  elseif (!ctype_digit ($timestamp))
		  {
		   $timestamp = strtotime ($timestamp);
		}
		# remove S (st,nd,rd,th) there are no such things in indonesia :p
		$date_format = preg_replace ("/S/", "", $date_format);
		$pattern = array (
		   '/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
		   '/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
		   '/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
		   '/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
		   '/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
		   '/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
		   '/April/','/June/','/July/','/August/','/September/','/October/',
		   '/November/','/December/',
		);
		$replace = array ( 'Sen','Sel','Rab','Kam','Jum','Sab','Min',
		   'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu',
		   'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des',
		   'Januari','Februari','Maret','April','Juni','Juli','Agustus','Sepember',
		   'Oktober','November','Desember',
		);
		$date = date ($date_format, $timestamp);
		$date = preg_replace ($pattern, $replace, $date);
		$date = "{$date} {$suffix}";
		return $date;
	}else{
		return null;
	}
}

?>