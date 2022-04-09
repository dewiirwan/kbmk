<?php  defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('url_params')) {
	/**
	* URL params
	*
	* Returns the full url params.
	*
	* @access	public
	* @return	string
	*/
	function url_params($params = array()) {
		$CI =& get_instance();
		
		$gets = $CI->input->get();
		if (!$gets) 
			$gets = array();
		if (count($params) > 0)
			//$gets = $params;
			$gets = array_merge($gets, $params);
		
		$params = array();
		foreach($gets as $key => $value) {
			if (is_array($value)) {
				foreach ($value as $item) {
					if ($value != null)
						$params[] = $key . urlencode ('[]') . '=' . $item;
				}
			} else {
				if ($value != null)
					$params[] = $key . '=' . $value;
			}
		}
		
		return implode('&', $params);
	}
}

if (!function_exists('current_url_params')) {
	/**
	* Current URL params
	*
	* Returns the full URL (including segments and gets parameters) of the page where this
	* function is placed
	*
	* @access	public
	* @return	string
	*/
	function current_url_params($params = array()) {
		$CI =& get_instance();
		$site_url = $CI->config->site_url($CI->uri->uri_string());
		
		$url_params = url_params($params);
		if (!empty($url_params)) $url_params = '?' . $url_params;
		
		return $site_url . $url_params;
	}
}

if (!function_exists('flash_message')) {
	/**
	* Flash Message
	*
	* Returns the message from session flashdata of the page where this
	* function is placed
	*
	* @access	public
	* @return	string
	*/
	function flash_message($type = 'alert-danger') {
		$CI =& get_instance();
		$message = '';
		if ($CI->session->flashdata('message-success')) {
			$msg = $CI->session->flashdata('message-success');
			$tag = 'alert-success';
		} else if ($CI->session->flashdata('message-error')) {
			$msg = $CI->session->flashdata('message-error');
			$tag = 'alert-danger';
		} else if ($CI->session->flashdata('message-warning')) {
			$msg = $CI->session->flashdata('message-warning');
			$tag = 'alert-warning';
		} else {
			$msg = $CI->session->flashdata('message');
			$tag = 'alert-info';
		}
		if ($msg) {
			$message .= '<div class="alert alert-dismissible '.$tag.' fade show" role="alert">';
			$message .= $msg;
			$message .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
			$message .= '</div>';
		}
		return $message;
	}
}

if (!function_exists('fu_time_ago')) {
	/**
	* FU Time Ago
	*
	* Returns the time in human readable format
	* function is placed
	*
	* @access	public
	* @return	string
	*/
	function fu_time_ago($timestamp = null) {
		$time_ago = $timestamp ? strtotime($timestamp) : time();
		$current_time = time();
		$time_difference = $current_time - $time_ago;
		$seconds = $time_difference;
		$minutes = round($seconds / 60);//value 60 is seconds
		$hours = round($seconds / 3600);//value 3600 is 60 minutes * 60 sec
		$days = round($seconds / 86400);//86400 = 24 * 60 * 60
		$weeks = round($seconds / 604800);// 7*24*60*60
		$months = round($seconds / 2629440);//((365+365+365+365+366)/5/12)*24*60*60
		$years = round($seconds / 31553280);//(365+365+365+365+366)/5*24*60*60
		if ($seconds <= 60) {
			$str = "less than a minute";//seconds
		} else if ($minutes <= 60) {
			if ($minutes == 1)
				$str = "about a minute";//minute
			else
				$str = "$minutes minutes";//minutes
		} else if ($hours <= 24) {
			if ($hours == 1)
				$str = "about an hour";//hour
			else
				$str = "about $hours hours";//hours
		} else if ($days <= 7) {
			if ($days == 1)
				$str = "a day";//day
			else
				$str = "$days days";//days
		/*} else if ($weeks <= 4.3) { //4.3 == 52/12
			if ($weeks == 1)
				$str = "a week";
			else
				$str = "$weeks weeks";*/
		} else if ($months <= 12) {
			if ($months == 1)
				$str = "about a month";//month
			else
				$str = "$months months";//months
		} else {
			if ($years == 1)
				$str = "about a year";//year
			else
				$str = "$years years";//years
		}
		return $str.' ago';//suffixAgo
	}
}

if (!function_exists('alphaID')) {
	/**
	* Translates a number to a short alhanumeric version
	* https://kvz.io/blog/2009/06/10/create-short-ids-with-php-like-youtube-or-tinyurl/
	*
	* @author	Kevin van Zonneveld <kevin@vanzonneveld.net>
	* @author	Simon Franz
	* @author	Deadfish
	* @author  SK83RJOSH
	* @copyright 2008 Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	* @license   http://www.opensource.org/licenses/bsd-license.php New BSD Licence
	* @version   SVN: Release: $Id: alphaID.inc.php 344 2009-06-10 17:43:59Z kevin $
	* @link	  http://kevin.vanzonneveld.net/
	*
	* @param mixed   $in	  String or long input to translate
	* @param boolean $to_num  Reverses translation when true
	* @param mixed   $pad_up  Number or boolean padds the result up to a specified length
	* @param string  $pass_key Supplying a password makes it harder to calculate the original ID
	*
	* @return mixed string or long
	*/
	function alphaID($in, $to_num = false, $pad_up = 7, $passKey = null) {
		$index = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ_-";
		if ($passKey !== null) {
			for ($n = 0; $n < strlen($index); $n++)
				$i[] = substr($index, $n, 1);
			$passhash = hash('sha256',$passKey);
			$passhash = (strlen($passhash) < strlen($index)) ? hash('sha512',$passKey) : $passhash;
			for ($n=0; $n < strlen($index); $n++)
				$p[] = substr($passhash, $n ,1);
			array_multisort($p, SORT_DESC, $i);
			$index = implode($i);
		}
		$base = strlen($index);
		if ($to_num) {
			$in = strrev($in);
			$out = 0;
			$len = strlen($in) - 1;
			for ($t = 0; $t <= $len; $t++) {
				$bcpow = pow($base, $len - $t);//changed from bcpow
				$out = $out + strpos($index, substr($in, $t, 1)) * $bcpow;
			}
			if (is_numeric($pad_up)) {
				$pad_up--;
				if ($pad_up > 0)
					$out -= pow($base, $pad_up);
			}
			$out = sprintf('%F', $out);
			$out = substr($out, 0, strpos($out, '.'));
		} else {
			if (is_numeric($pad_up)) {
				$pad_up--;
				if ($pad_up > 0)
					$in += pow($base, $pad_up);
			}
			$out = "";
			for ($t = floor(log($in, $base)); $t >= 0; $t--) {
				$bcp = pow($base, $t);//changed from bcpow
				$a = floor($in / $bcp) % $base;
				$out = $out . substr($index, $a, 1);
				$in = $in - ($a * $bcp);
			}
			$out = strrev($out);
		}
		return $out;
	}
}

if (!function_exists('number_format_short')) {
	/**
	* Use to convert large positive numbers in to short form like 1.2K, 98K, etc
	* @access	public
	* @return	string
	*/
	function number_format_short($n = null) {
		$pmvalue2 = $n;
		if (isset($n)) {
			if ($n >= 1000000) {
				$numval = $n/1000000;
				$numfor = $numval < 10 ? 1 : 0;
				$pmvalue2 = number_format($numval,$numfor).'M';
			} else if ($n >= 1000) {
				$numval = $n/1000;
				$numfor = $numval < 10 ? 1 : 0;
				$pmvalue2 = number_format($numval,$numfor).'K';
			}
		}
		return $pmvalue2;
	}
}

if (!function_exists('zoneinfo')) {
	/**
	* Convert timezone offset (minutes) to zoneinfo like UTC+7:30
	* @access	public
	* @return	string
	*/
	function zoneinfo($minutes = 0) {
		if (!$minutes)
			return 'UTC';
		$inh = $minutes/60;
		$first = $inh;
		$secnd = '';
		if (strpos($inh, ".") !== FALSE) {
			$arr = explode(".", $inh, 2);
			$first = $arr[0];
			$secnd = $arr[1]/100*60;
			if ($secnd < 10)
				$secnd .= '0';
		}
		return 'UTC'.($first>0?'+':'').$first.($secnd ? ':'.$secnd : '');
	}
}

if (!function_exists('readable_size')) {
	function readable_size($size = null) {
		if (!$size) return;
		$base = log($size) / log(1024);
		$suffix = array("Byte", "KiB", "MiB", "GiB", "TiB");
		$f_base = floor($base);
		return round(pow(1024, $base - floor($base)), 1).' '.$suffix[$f_base];
	}
}
if (!function_exists('readable_bps')) {
	function readable_bps($size = null) {
		if (!$size) return;
		$base = log($size) / log(1000);
		$suffix = array("bps", "Kbps", "Mbps", "Gbps");
		$f_base = floor($base);
		return round(pow(1000, $base - floor($base)), 0).' '.$suffix[$f_base];
	}
}
if (!function_exists('return_json')) {
	function return_json($response = '', $content_type = 'application/json') {
		$CI =& get_instance();
		$CI->output->set_content_type($content_type);
		$CI->output->set_output(json_encode($response));
	}
}