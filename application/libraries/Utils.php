<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Utils
{
    
    function number_format_indo( $n, $precision = 1 ) {
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        } else if ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M';
        } else if ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T';
        }

        if ( $precision > 0 ) {
            $dotzero = '.' . str_repeat( '0', $precision );
            $n_format = str_replace( $dotzero, '', $n_format );
        }

        return $n_format . $suffix;
    }
    
    function bar($total, $now, $awal = 0)
	{
		if($awal == 0)
		{
			$percent_now = 0;
		}
        if($total == 0)
		{
			$percent_now = 0;
		}
        if($now == 0)
		{
			$percent_now = 0;
		}
		else
        {
			$percent_now = ($now * 100)/$total;
		}
        
        //if($percent_now < 25)
//        {
//            $bg = 'danger';
//            $percent = $percent_now;
//        }
//        else if($percent_now < 50)
//        {
//            $bg = 'warning';
//            $percent = $percent_now;
//        }
//        else if($percent_now < 99)
//        {
//            $bg = 'success';
//            $percent = $percent_now;
//        }
//        else if($percent_now <= 100)
//        {
//            $bg = 'primary';
//            $percent = $percent_now;
//        }
        
		$return = array(
							//'bar' =>'<div class="progress-bar bg-info progress-bar-striped" role="progressbar" aria-valuenow="'.$percent.'" aria-valuemin="'.$awal.'" aria-valuemax="100" style="width: '.$percent.'%"><span class="sr-only">'.$percent.'% Terpantau (success)</span></div>',
//							'background' => $bg
                            'bar' =>'<div class="progress-bar bg-info progress-bar-striped" aria-valuenow="'.round($percent_now, 2).'" aria-valuemin="'.$awal.'" aria-valuemax="100" style="width: '.round($percent_now, 2).'%" role="progressbar"><span class="sr-only">'.round($percent_now, 2).'% Complete (success)</span></div>',
                            'persentase' => $percent_now
					);
		
		return $return;
	}
}
?>