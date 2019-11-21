<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkin extends CI_Controller {
	protected $_ci;
	protected $db_simrs;
	protected $parameter;
	protected $urut_masuk;
	protected $kd_kasir 	= "01";
	protected $no_transaksi = "0000001";
	protected $kd_tarif = "";

	public function __construct(){
		parent::__construct();
		$this->_ci = &get_instance();
		include('./config.php');
		$this->load->model('Rs_visit');
		$this->load->model('Kunjungan');
		$this->load->model('Transaksi');
		$this->load->model('Asal_pasien');
		$this->load->model('Bagian_shift');
		$this->load->model('Tarif_cust');
		$this->load->model('Kasir');
		$this->load->model('Detail_transaksi');
		$this->load->model('Autocharge');
		$this->load->model('Tarif_Component');
		$this->load->model('Detail_component');
		$this->load->model('Sjp_kunjungan');
		$this->db_simrs = $this->load->database('second', TRUE);
	}

	public function index(){
		include('./config.php');
		$response = array();
		$response['status'] = true;
		$response['code'] 	= 200;
		$response['message']= "";
		$response['data_rs'] = $conf_db['rs'];
		$response['_include_css'] = $this->_ci->load->view('partials/include_css', $response, TRUE);
		$response['_header']      = $this->_ci->load->view('partials/header-checkin', $response, TRUE);
		$response['_include_js']  = $this->_ci->load->view('partials/include_js', $response, TRUE);
		$this->load->view('pages/checkin/index', $response);
	}

	public function search_process(){
		$response = array();
		$response['status'] = true;
		$response['code'] 	= 200;
		$response['message']= "";
		$this->Rs_visit->set_database($this->load->database('default',TRUE));
		$query = $this->Rs_visit->get_with_relation(" * ", array(
			'rs_visit.no_pendaftaran' 	=> $this->input->post('no_pendaftaran'),
			'rs_visit.entry_date' 		=> date("Y-m-d"),
			'rs_visit.hadir' 			=> '0',
		));
		if ($query->num_rows() > 0) {
			$this->load->view('pages/checkin/step2-review', array(
				'data' => $query,
			));
		}else{
			$response['status'] = false;
			$response['code'] 	= 401;
			$response['message']= "Data tidak ditemukan";
			$this->load->view('pages/checkin/step1-search', $response);
		}
	}

	public function confirm_form(){
		$response = array();
		$response['status'] = true;
		$response['code'] 	= 200;
		$response['message']= "";
		$response['no_pendaftaran'] = $this->input->post('no_pendaftaran');
		$this->load->view('pages/checkin/step3-confirmation', $response);
	}

	public function search_form(){
		$response = array();
		$response['status'] = true;
		$response['code'] 	= 200;
		$response['message']= "";
		$this->load->view('pages/checkin/step1-search', $response);
	}

	public function process(){
		$result 		= true;
		$criteria 		= array();
		$params 		= array();
		$response 		= array();
		$response['code'] 		= 200;
		$response['message'] 	= "Checkin berhasil";
		$this->db_simrs->trans_begin();

		$this->Rs_visit->set_database($this->load->database('default', TRUE));
		$query = $this->Rs_visit->get_with_relation(" * ", array(
			'rs_visit.no_pendaftaran' 	=> $this->input->post('no_pendaftaran'),
			'rs_visit.hadir' 			=> '0',
		));

		/*
			=========================================================================================
			CRUD : KUNJUNGAN
			=========================================================================================
		*/
		if ($query->num_rows() > 0) {
			$this->parameter = $query->result();
			$response['kunjungan'] = $this->CRUD_kunjungan($this->parameter);
			if ($response['kunjungan']['result'] == 0) {
				$response['code'] 		= 401;
				$response['message'] 	= "Checkin gagal";
			}
		}

		/*
			=========================================================================================
			CRUD : TRANSAKSI
			=========================================================================================
		*/
		if ($response['code'] == 200) {
			$this->parameter = $query->result();
			$response['transaksi'] = $this->CRUD_transaksi($this->parameter);
			if ($response['transaksi']['result'] == 0) {
				$response['code'] 		= 401;
				$response['message'] 	= "Checkin gagal";
			}
		}

		/*
			=========================================================================================
			GET : KODE TARIF CUS/ KD TARIF
			=========================================================================================
		*/
		if ($response['code'] == 200) {
			$this->Tarif_cust->set_database($this->load->database('second', TRUE));
			$kd_tarif = $this->Tarif_cust->get(" kd_tarif ", array( 'kd_customer' => $this->parameter[0]->customer_code, ));
			if($kd_tarif->num_rows() > 0){
				$this->kd_tarif = $kd_tarif->row()->kd_tarif;
			}else{
				$response['code'] 		= 401;
				$response['message'] 	= "Get kode tarif, gagal";
			}
		}

		/*
			=========================================================================================
			INSERT : DETAIL TRANSAKSI / AUTOCHARGE
			=========================================================================================
		*/
		if ($response['code'] == 200) {
			$this->parameter = $query->result();
			$response['autocharge'] = $this->CRUD_autocharge($this->parameter);
			if ($response['autocharge']['result'] == 0) {
				$response['code'] 		= 401;
				$response['message'] 	= "Checkin gagal";
			}
		}


		/*
			=========================================================================================
			INSERT : DETAIL COMPONENT
			=========================================================================================
		*/
		if ($response['code'] == 200) {
			$this->parameter = $query->result();
			$response['transaksi'] = $this->CRUD_component($this->parameter);
			if ($response['transaksi']['result'] == 0) {
				$response['code'] 		= 401;
				$response['message'] 	= "Checkin gagal";
			}
		}

		/*
			=========================================================================================
			GENERATE SEP
			=========================================================================================
		*/
		$tmp_sep = "";
		if ($response['code'] == 200 ) {
			$this->parameter = $query->result();
			if ($this->parameter[0]->kd_rujukan != '') {
				$response['sep'] = json_decode($this->GENERATE_SEP($this->parameter));
				// var_dump($response['sep']);die;
				if ($response['sep']->metaData->code !== '200') {
					$response['code'] 		= 401;
					$response['message'] 	= $response['sep']->metaData->message;
					$tmp_sep = $response['sep']->response->sep->noSep;
				}else{
					$response['message'] = $response['message'].", no sep : ".$response['sep']->response->sep->noSep;
				}
			}
		}

		if ($response['code'] == 200) {
			$this->parameter = $query->result();
			$this->db_simrs->trans_commit();
			$this->Rs_visit->set_database($this->load->database('default',TRUE));
			$this->Rs_visit->update(
				array( 'no_pendaftaran' => $this->parameter[0]->no_pendaftaran, ), 
				array( 'hadir' => 1, 'kode_sep' => $tmp_sep,)
			);
			// $this->db_simrs->trans_rollback();
		}else{
			$this->db_simrs->trans_rollback();
		}
		$this->db_simrs->close();
		$this->load->view('pages/checkin/step1-search', $response);
	}

	private function GENERATE_SEP($parameter){
		include('./config.php');
		$curl  	= curl_init();
		$url = $conf_app['bpjs']['url_generate_sep'];
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_PORT, 8080);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $this->parameter_bpjs($parameter));
		curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getSignature()); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201');
		$data = curl_exec($curl);
		curl_close($curl);
		return $data;
	}

	private function CRUD_kunjungan($parameter){
		$params 				= array();
		$response 				= array();
		$params['urut_masuk'] 	= 0;

		$this->Kunjungan->set_database($this->load->database('second', TRUE));
		$query = $this->Kunjungan->get(
			" * ", 
			array(
				'kd_pasien' => $parameter[0]->patient_code,
				'kd_unit' 	=> $parameter[0]->unit_code,
				'tgl_masuk'	=> date('Y-m-d')
			),
			array(
				'field' 	=> "urut_masuk",
				'order' 	=> "desc",
			),
			'1'
		);

		if ($query->num_rows() > 0) {
			$params['urut_masuk']  	= $query->row()->urut_masuk;
			$params['urut_masuk']  	= (int)$params['urut_masuk'] + 1;
		}
		$this->urut_masuk 		= $params['urut_masuk'];

		$params['kd_pasien'] 		= $parameter[0]->patient_code;
		$params['kd_unit']   		= $parameter[0]->unit_code;
		$params['tgl_masuk'] 		= $parameter[0]->entry_date;
		$params['urut_masuk']		= $params['urut_masuk'];
		$params['no_sjp']			= '';
		$params['kd_dokter']		= '000';
		$params['baru']				= '0';
		$params['kd_customer']		= $parameter[0]->customer_code;
		$params['shift']			= $this->get_shift($parameter[0]->unit_code);
		$this->Asal_pasien->set_database($this->load->database('second', TRUE));
		$params['asal_pasien']		= $this->Asal_pasien->query("SELECT kd_asal from asal_pasien where kd_unit='".substr($parameter[0]->unit_code, 0, 1)."'");
		if ($params['asal_pasien']->num_rows() > 0) {
			$params['asal_pasien'] = $params['asal_pasien']->row()->kd_asal;
		}else{
			$params['asal_pasien'] = "";
		}
		$params['jam_masuk']		= '1900-01-01 '.gmdate("H:i:s", time()+60*61*7);
		$params['karyawan']			= '0';
		$params['kontrol']			= 'false';
		$params['antrian']			= '0';
		$params['online']			= '1';
		$params['anamnese']			= $parameter[0]->keluhan;

		if ($parameter[0]->kd_rujukan !== '') {
			
		}else{
			$params['cara_penerimaan'] = 99;
		}

		if ($parameter[0]->kd_rujukan !== '') {
			
		}else{
			$params['kd_rujukan'] = 0;
		}

		$this->Kunjungan->set_database($this->db_simrs);
		return $this->Kunjungan->create($params);
	}

	private function CRUD_component($parameter){
		$query = "
		SELECT
			row_number ( ) OVER ( ORDER BY AutoCharge.kd_produk DESC ) AS urut,
			tarif.kd_tarif,
			AutoCharge.kd_produk,
			AutoCharge.kd_unit,
			max( tarif.tgl_berlaku ) AS tglberlaku,
			max( tarif.tarif ) AS tarifx
		FROM
			AutoCharge
			INNER JOIN tarif ON tarif.kd_produk = autoCharge.kd_Produk
			AND tarif.kd_unit = autoCharge.kd_unit
			INNER JOIN produk ON produk.kd_produk = tarif.kd_produk
		WHERE
			AutoCharge.kd_unit = '" . $parameter[0]->unit_code . "'
			and LOWER(kd_tarif)=LOWER('".$this->kd_tarif."')
			and tgl_berlaku <= '". $parameter[0]->entry_date."'
		GROUP BY
			AutoCharge.kd_unit,
			AutoCharge.kd_produk,
			AutoCharge.shift,
			tarif.kd_tarif
		ORDER BY
			AutoCharge.kd_produk ASC";
		$this->Autocharge->set_database($this->db_simrs);
		$query = $this->Autocharge->query($query);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $result_row) {
				unset($params);
				$query = "
					SELECT
						'".$this->kd_kasir."',
						'".$this->no_transaksi."',
						".$result_row->urut.",
						'" . $parameter[0]->entry_date . "',
						kd_component,
						tarif,
						0
					FROM Tarif_Component
					WHERE
						KD_Unit='".$parameter[0]->unit_code."' And
						Tgl_Berlaku='".$result_row->tglberlaku."' And
						KD_Tarif='".$this->kd_tarif."'
						And Kd_Produk='".$result_row->kd_produk."'";
				$this->Tarif_Component->set_database($this->db_simrs);
				$query = $this->Tarif_Component->query($query);

				if ($query->num_rows() > 0) {
					foreach ($query->result() as $row) {
						$params = array(
							'Kd_Kasir' 		=> $this->kd_kasir,
							'No_Transaksi' 	=> $this->no_transaksi,
							'Urut' 			=> $result_row->urut,
							'Tgl_Transaksi' => $parameter[0]->entry_date,
							'Kd_Component' 	=> $row->kd_component,
							'Tarif' 		=> $row->tarif,
							'Disc' 			=> 0,
						);

						$this->Detail_component->set_database($this->db_simrs);
						$result = $this->Detail_component->create($params);
						if ($result['result'] == 0) {
							break;
						}
					}
				}
			}
		}else{
			$result['result'] 	= 1;
			$result['error'] 	= "";
		}
		return $result;
	}

	private function CRUD_autocharge($parameter){
		$query 	= "SELECT
			'".$this->kd_kasir."' AS kd_kasir,
			'".$this->no_transaksi."' AS no_transaksi,
			'" . $parameter[0]->entry_date . "' AS tgl_transaksi,
			'0' AS kd_user,
			'true' AS charge,
			'true' AS adjust,
			'A' AS folio,
			1 AS qty,
			".$this->get_shift($parameter[0]->unit_code)." AS shift,
			'false' AS tag,
			'' AS no_faktur,
			ROW_NUMBER() OVER (
		      ORDER BY AutoCharge.kd_produk
		   	) AS urut,
			AutoCharge.appto,
			tarif.kd_tarif,
			AutoCharge.kd_produk,
			AutoCharge.kd_unit,
			MAX ( tarif.tgl_berlaku ) AS tglberlaku,
			tarif.tarif AS tarif
		FROM
			AutoCharge
			INNER JOIN tarif ON tarif.kd_produk = autoCharge.kd_Produk 
			AND tarif.kd_unit = autoCharge.kd_unit
			INNER JOIN produk ON produk.kd_produk = tarif.kd_produk 
		WHERE
			AutoCharge.kd_unit='" . $parameter[0]->unit_code . "'
			and LOWER(kd_tarif)=LOWER('".$this->kd_tarif."')
			and tgl_berlaku <= '".date('Y-m-d')."'
		GROUP BY
			AutoCharge.kd_unit,
			AutoCharge.kd_produk,
			AutoCharge.shift,
			tarif.kd_tarif,
			tarif.tarif,
			AutoCharge.appto,
			tarif.tgl_berlaku 
		ORDER BY
			tglberlaku DESC;
		";
		/* and AutoCharge.appto in ".$parameter['getappto']." */

		$this->Autocharge->set_database($this->db_simrs);
		$query = $this->Autocharge->query($query);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $result_row) {
				unset($params);
				$params = array(
					'kd_kasir' 		=> $result_row->kd_kasir,
					'no_transaksi' 	=> $result_row->no_transaksi,
					'urut' 			=> $result_row->urut,
					'tgl_transaksi' => $result_row->tgl_transaksi,
					'kd_user' 		=> $result_row->kd_user,
					'kd_tarif' 		=> $result_row->kd_tarif,
					'kd_produk' 	=> $result_row->kd_produk,
					'kd_unit' 		=> $result_row->kd_unit,
					'tgl_berlaku' 	=> $result_row->tglberlaku,
					'charge' 		=> $result_row->charge,
					'adjust' 		=> $result_row->adjust,
					'folio' 		=> $result_row->folio,
					'qty' 			=> $result_row->qty,
					'harga' 		=> $result_row->tarif,
					'shift' 		=> $result_row->shift,
					'tag' 			=> $result_row->tag,
					'no_faktur' 	=> $result_row->no_faktur,
				);
				$this->Detail_transaksi->set_database($this->db_simrs);
				$result = $this->Detail_transaksi->create($params);
				if ($result['result'] == 0) {
					break;
				}
			}
		}else{
			$result['result'] 	= 1;
			$result['error'] 	= "";
		}
		return $result;
	}

	private function CRUD_transaksi($parameter){
		$result 				= true;
		$params 				= array();
		$response 				= array();
		$template_no_trans 		= "0000000";
		$params['kd_kasir'] 	= $this->kd_kasir;
		$params['no_transaksi'] = $this->no_transaksi;
		$this->Transaksi->set_database($this->load->database('second', TRUE));
		$query = $this->Transaksi->get(" MAX(no_transaksi) as no_transaksi ", array(
			'kd_kasir' 	=> $params['kd_kasir'],
		));
		$tmp_notrans = (int)$query->row()->no_transaksi + 1;
		if ($query->num_rows() > 0) {
			$params['no_transaksi'] = substr($template_no_trans, 0, strlen($template_no_trans)-strlen($tmp_notrans)).$tmp_notrans;
		}else{
			$params['no_transaksi'] = substr($template_no_trans, 0, strlen($template_no_trans)-1)."1";
		}
		$this->no_transaksi = $params['no_transaksi'];

		if ($result === true || $result > 0) {
			$this->Kasir->set_database($this->db_simrs);
			$result = $this->Kasir->update(
				array(
					'kd_kasir' 	=> $params['kd_kasir'],
				),
				array(
					'counter' 	=> (int)$params['no_transaksi'],
				)
			);

			if ($result['result'] == 0){
				$result = 0;
			}else{
				$result = 1;
			}
		}

		if ($result === true || $result > 0) {
			$params['kd_pasien'] 	= $parameter[0]->patient_code;
			$params['kd_unit'] 		= $parameter[0]->unit_code;
			$params['tgl_transaksi']= $parameter[0]->entry_date;
			$params['urut_masuk']	= $this->urut_masuk;
			$params['tgl_co']		= null;
			$params['co_status']	= 'false';
			$params['ispay']		= 'false';
			$params['app']			= 'false';
			$params['lunas']		= 'false';
			$params['kd_user']		= '0';
			$params['tag']			= null;
			$params['tgl_lunas']	= null;

			$this->Transaksi->set_database($this->db_simrs);
			return $this->Transaksi->create($params);
		}else{
			return array(
				'result' 	=> 0,
			);
		}
	}

	private function get_shift($criteria = 2){
		$parameter = array();
		$this->Bagian_shift->set_database($this->load->database('second', TRUE));
		$query 	= $this->Bagian_shift->get(" shift ", array(
			'kd_bagian' => substr($criteria,0,1)
		));

		if ($query->num_rows() > 0) {
			$parameter['shift'] = $query->row()->shift;
		}else{
			$parameter['shift'] = "";
		}

		$this->Bagian_shift->set_database($this->load->database('second', TRUE));
		$query = $this->Bagian_shift->get(" lastdate ", array(
			'kd_bagian' 	=> substr($criteria,0,1),
		));
		if ($query->num_rows() > 0) {
			$parameter['lastdate'] = date_format(date_create($query->row()->lastdate), "Y-m-d");
		}else{
			$parameter['lastdate'] = "";
		}

		if ($parameter['lastdate'] <> date('Y-m-d') && $parameter['shift'] === '3') {
			$parameter['shift'] = '4';
		} else {
			$parameter['shift'] = $parameter['shift'];
		}

		return $parameter['shift'];
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

	function parameter_bpjs($parameter){
		include('./config.php');
		$this->Sjp_kunjungan->set_database($this->load->database('second', TRUE));
		$query 	= $this->Sjp_kunjungan->get(" COALESCE(max(no_dpjp),0) as no_dpjp ", "no_dpjp <> '' AND no_dpjp is not null");
		if ($query->num_rows() > 0) {
			$no_surat = (int)$query->row()->no_dpjp + 1;
		} 

		$json='{
           "request": {
              "t_sep": {
                 "noKartu": "'.$parameter[0]->nomor_peserta.'",
                 "tglSep": "'. date("Y-m-d").'",
                 "ppkPelayanan": "'.$conf_app['bpjs']['ppk_pelayanan'].'",
                 "jnsPelayanan": "2",
                 "klsRawat": "'.$parameter[0]->kd_kelas.'",
                 "noMR": "'.$parameter[0]->patient_code.'",
                 "rujukan": {
                    "asalRujukan": "'.$parameter[0]->faskes_asal.'",
                    "tglRujukan": "'.$parameter[0]->tgl_rujukan.'",
                    "noRujukan": "'.$parameter[0]->no_rujukan.'",
                    "ppkRujukan": "'.$parameter[0]->kd_rujukan.'"
                 },
                 "catatan": "Pendaftaran Online",
                 "diagAwal": "'.$parameter[0]->kd_diagnosa.'",
                 "poli": {
                    "tujuan": "'.$parameter[0]->kd_poli.'",
                    "eksekutif": "0"
                 },
                 "cob": {
                    "cob": "0"
                 },
                 "katarak": {
                    "katarak": "0"
                 },
                 "jaminan": {
                    "lakaLantas": "0",
                    "penjamin": {
                        "penjamin": "0" ,
                        "tglKejadian": "'.date('Y-m-d').'",
                        "keterangan": "",
                        "suplesi": {
                            "suplesi": "0",
                            "noSepSuplesi":  "0",
                            "lokasiLaka": {
                                "kdPropinsi":  "0",
                                "kdKabupaten":  "0",
                                "kdKecamatan":  "0"
                                }
                        }
                    }
                 },
                 "skdp": {
                    "noSurat": "'.$no_surat.'",
                    "kodeDPJP": "'.$parameter[0]->kd_dpjp.'"
                 },
                 "noTelp": "'.$parameter[0]->phone_number.'",
                 "user": "Coba Ws"
              }
           }
        }';
       return $json;

	}
}
