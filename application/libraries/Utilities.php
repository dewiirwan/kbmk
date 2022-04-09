<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utilities 
{
	function __construct()
	{
		$CI =& get_instance();
        $this->db = $CI->load->database('default',TRUE);
    }
	
	function notification($tipe, $message)
	{
		$CI =& get_instance();
		switch($tipe)
			{
				case 'success' : $CI->session->set_flashdata(''.$tipe.'','<div class="alert alert-success alert-styled-left alert-arrow-left alert-bordered">
										<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
										<span class="text-semibold">Berhasil!</span> '.$message.'.
								    </div>');
				break;
				
				case 'danger' : $CI->session->set_flashdata(''.$tipe.'','<div class="alert alert-danger alert-styled-left alert-bordered">
										<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
										<span class="text-semibold">Gagal !</span> '.$message.'.
								    </div>');
				break;
			}
		return TRUE;
	}
    
    function indonesian_date ($timestamp = '', $date_format = 'l, j F Y | H:i', $suffix = 'WIB') {
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
	
	//untuk mengetahui bulan bulan

    function bulan($bln)
    {
        switch ($bln)
        {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }

 
    function tanggal($tgl)
    {
        $ubah = gmdate($tgl, time()+60*60*8);
        $pecah = explode("-",$ubah);  //memecah variabel berdasarkan -
        $tanggal = $pecah[2];
        $bulan = $this->bulan($pecah[1]);
        $tahun = $pecah[0];
        return $tanggal.' '.$bulan.' '.$tahun; //hasil akhir
    }

 
 
	function tanggal_waktu($tgl)
	{
    	//$inttime=date('Y-m-d H:i:s',$tgl); //mengubah format menjadi tanggal biasa
    	$tglBaru=explode(" ",$tgl); //memecah berdasarkan spaasi
     
    	$tglBaru1=$tglBaru[0]; //mendapatkan variabel format yyyy-mm-dd
    	$tglBaru2=$tglBaru[1]; //mendapatkan fotmat hh:ii:ss
    	$tglBarua=explode("-",$tglBaru1); //lalu memecah variabel berdasarkan -
 
    	$tgl=$tglBarua[2];
    	$bln=$tglBarua[1];
    	$thn=$tglBarua[0];
 
    	$bln=$this->bulan($bln); //mengganti bulan angka menjadi text dari fungsi bulan
    	$ubahTanggal="$tgl $bln $thn | $tglBaru2 "; //hasil akhir tanggal
 
    	return $ubahTanggal;
	}
	
	function countDays($tgl_awal, $tgl_akhir)
	{
		//$awal  = date_create($tgl_awal);
		$tawal = date("Y-m-d");
		$awal = date_create($tawal);
		$akhir = date_create($tgl_akhir);
		$diff  = date_diff( $awal, $akhir );
		$count = $diff->days;
		return $count;
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
        
        if($percent_now < 25)
        {
            $bg = 'danger';
            $percent = $percent_now;
        }
        else if($percent_now < 50)
        {
            $bg = 'warning';
            $percent = $percent_now;
        }
        else if($percent_now < 99)
        {
            $bg = 'success';
            $percent = $percent_now;
        }
        else if($percent_now <= 100)
        {
            $bg = 'primary';
            $percent = $percent_now;
        }
        
		$return = array(
							'bar' =>'<div class="progress-bar bg-info progress-bar-striped" role="progressbar" aria-valuenow="'.$percent.'" aria-valuemin="'.$awal.'" aria-valuemax="100" style="width: '.$percent.'%"><span class="sr-only">'.$percent.'% Terpantau (success)</span></div>',
							'background' => $bg
					);
		
		return $return;
	}
	
	function rupiah($nominal)  
    {  
  		$result = "Rp ".number_format($nominal,2,",",".");  
   		return $result;  
	} 
	
	function uploadGambar($name, $folder, $type, $maxsize, $filename, $maxwidth = 1024, $maxheight = 800)
        {
				$CI =& get_instance();
                $config['upload_path']          = $folder;
                $config['allowed_types']        = $type;
                $config['max_size']             = $maxsize;
                $config['max_width']            = $maxwidth;
                $config['max_height']           = $maxheight;
				$config['file_name']			= $filename;

                $CI->load->library('upload', $config);

                if ( ! $CI->upload->do_upload($name))
                {
                        $error = array('error' => $CI->upload->display_errors());
						$this->notification('danger', ''.$error['error'].'');
						$data = FALSE;
						//$data = ''.$folder.'/logotangsel.png';
                        //$this->load->view('upload_form', $error);
                }
                else
                {
                        $result = $CI->upload->data();
						$data = ''.$folder.'/'.$result['file_name'].'';
						
                        //$this->load->view('upload_success', $data);
                }
				
				return $data;
        }
		
	function uploadFile($name, $folder, $type, $maxsize, $filename)
        {
				$CI =& get_instance();
				unset($config);
                $config['upload_path']          = $folder;
                $config['allowed_types']        = $type;
                $config['max_size']             = $maxsize;
				$config['file_name']			= $filename;

                $CI->load->library('upload');
				$CI->upload->initialize($config);

                if ( ! $CI->upload->do_upload($name))
                {
                        $error = array('error' => $CI->upload->display_errors());
						$this->notification('danger', ''.$error['error'].'');
						$data = FALSE;
						//$data = ''.$folder.'/logotangsel.png';
                        //$this->load->view('upload_form', $error);
                }
                else
                {
                        $result = $CI->upload->data();
						$data = ''.$folder.'/'.$result['file_name'].'';
						
                        //$this->load->view('upload_success', $data);
                }
				
				return $data;
        }
		
	function sendmail($to, $from, $from_desc, $subject, $view, $data)
		{
			$CI =& get_instance();
			$config = array(  
				'protocol' => 'smtp',
				'smtp_host' => 'aspmx.l.google.com',      
				'smtp_port' => 25,
				'smtp_timeout' => '4',
				'mailtype'  => 'html', 
				'charset'   => 'utf-8',
				'newline' => "\r\n"
			);
			$CI->email->initialize($config);
			$CI->email->set_newline("\r\n");
		
			$CI->email->from($from, $from_desc);
			$CI->email->to($to);  // replace it with receiver mail id
			$CI->email->subject($subject); // replace it with relevant subject 
		
			$body = $CI->load->view($view,$data,TRUE);
			$CI->email->message($body);   
			$CI->email->send();
    	}
		
	function selectQuery($q, $key, $val)
	{
		$sql = $this->db->query($q);
		if($sql->num_rows()>0)
		{
			foreach($sql->result() as $row)
				{
					$result[] = '<option value="'.$row->$key.'">'.$row->$val.'</option>';	
				}
						
					return $result;	
		}	
	}
	
	function keyHash($length = 8) 
    {
		
        $keyHash = '';
        $chars     = "abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ123456789";
        for($i = 0; $i < $length; $i++) 
        {
            $x = mt_rand(0, strlen($chars) -1);
            $keyHash .= $chars{$x};
        }

        return $keyHash;
    }
}