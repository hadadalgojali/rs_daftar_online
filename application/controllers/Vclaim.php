<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vclaim extends CI_Controller {
	protected $_ci;

	public function __construct(){
		parent::__construct();
		$this->_ci = &get_instance();
		$this->load->model('rs_patient');
		$this->load->model('rs_customer');
		$this->load->model('rs_unit');
		$this->load->model('rs_visit');
		$this->load->model('rs_dokter_klinik');
		$this->load->helper('captcha');
	}

	public function check_rujukan(){
		include('./config.php');
		/*$opts = array(
		  'http'=>array(
			'method'=>'GET',
			'header'=>$this->getSignature()
		  )
		);
		$context = stream_context_create($opts);
		$res  	 = json_decode(file_get_contents($conf_app['bpjs']['url_rujukan'].$this->input->post('no_signature'),false,$context),false);
		echo json_encode($res);*/

		$url = $conf_app['bpjs']['url_rujukan'].$this->input->post('no_signature');
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getSignature()); 
		$data = curl_exec($curl);
		curl_close($curl);
		echo $data;
	}

	public function check_dokter_dpjp(){
		include('./config.php');
		// $opts = array(
		//   'http'=>array(
		// 	'method'=>'GET',
		// 	'header'=>$this->getSignature()
		//   )
		// );
		// $context = stream_context_create($opts);
		// $res  	 = json_decode(file_get_contents($conf_app['bpjs']['url_dokter_dpjp'].$this->input->post('pelayanan')."/tglPelayanan/".date("Y-m-d")."/Spesialis/".$this->input->post('spesialis'),false,$context),false);
		// echo json_encode($res);

		
		$url = $conf_app['bpjs']['url_dokter_dpjp'].$this->input->post('pelayanan')."/tglPelayanan/".date("Y-m-d")."/Spesialis/".$this->input->post('spesialis');
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getSignature()); 
		$data = curl_exec($curl);
		curl_close($curl);
		echo $data;
	}


	private function getSignature(){
		include('./config.php');

		$tmp_secretKey  = $conf_app['bpjs']['secret_key'];
		$tmp_costumerID = $conf_app['bpjs']['customer_id'];

		date_default_timezone_set('UTC');
		$tStamp = time();
		$signature = hash_hmac('sha256', $tmp_costumerID."&".$tStamp, $tmp_secretKey, true);
		$encodedSignature = base64_encode($signature);
		return array("X-Cons-ID: ".$tmp_costumerID,"X-Timestamp: ".$tStamp,"X-Signature: ".$encodedSignature);	
	}
	
}