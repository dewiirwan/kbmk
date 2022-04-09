<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {    
	public function __construct($config = array()) {
		parent::__construct($config);
	}

	public function valid_date($date = null, $format = 'Y-m-d H:i:s') {
		$d = DateTime::createFromFormat($format, $date);
		if ($d && $d->format($format) === $date) {
			$z = DateTime::createFromFormat($format, $date);
			if ($z->format('Y-m-d') > date('Y-m-d')) {
				$this->ci = & get_instance();
				$this->ci->form_validation->set_message('valid_date', '%s tidak dapat melebihi hari ini.');
				return FALSE;
			}
			return TRUE;
		}
		return FALSE;

	}
}