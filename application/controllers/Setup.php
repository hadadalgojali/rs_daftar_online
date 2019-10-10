<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup extends CI_Controller {
	protected $_ci;

	public function __construct(){
		parent::__construct();
		$this->_ci = &get_instance();
	}

	public function index(){
		include('./config.php');
		$response = array();

		$response['data_rs'] 		= $conf_db['rs'];
		$response['_header']      	= $this->_ci->load->view('partials/header', $response, TRUE);
		$response['_menu']        	= $this->_ci->load->view('partials/menu', $response, TRUE);
		$response['_footer']      	= $this->_ci->load->view('partials/footer', $response, TRUE);
		$response['_include_css'] 	= $this->_ci->load->view('partials/include_css', $response, TRUE);
		$response['_include_js']  	= $this->_ci->load->view('partials/include_js', $response, TRUE);

		$response['config_db'] 		= $conf_db;
		$response['config_app'] 	= $conf_app;
		$this->load->view('/pages/setup/index', $response);
	}

	public function update(){
		$target = "./";
		$string = "";
		$string .= "
			\$conf_app 	= array();
			\$conf_db 	= array();

			// DEFAULT DATABASE MYSQL
			\$conf_db['default']['hostname']    = \"".$this->input->post('default#hostname')."\";
			\$conf_db['default']['database']    = \"".$this->input->post('default#database')."\";
			\$conf_db['default']['username']    = \"".$this->input->post('default#username')."\";
			\$conf_db['default']['password']    = \"".$this->input->post('default#password')."\";
			\$conf_db['default']['dbdriver']    = \"".$this->input->post('default#dbdriver')."\";
			\$conf_db['default']['port']        = \"".$this->input->post('default#port')."\";
			
			// DATABASE SECONDARY
			\$conf_db['second']['hostname']     = \"".$this->input->post('second#hostname')."\";
			\$conf_db['second']['database']     = \"".$this->input->post('second#database')."\";
			\$conf_db['second']['username']     = \"".$this->input->post('second#username')."\";
			\$conf_db['second']['password']     = \"".$this->input->post('second#password')."\";
			\$conf_db['second']['dbdriver']     = \"".$this->input->post('second#dbdriver')."\";
			\$conf_db['second']['port']         = \"".$this->input->post('second#port')."\";

			// INFORMATION RS
			\$conf_db['rs']['name']             = \"".$this->input->post('rs#name')."\";
			\$conf_db['rs']['address']          = \"".$this->input->post('rs#address')."\";

			// KONFIGURASI APP
			\$conf_app['tanggal_at']            = \"".$this->input->post('conf_app#tanggal_at')."\";
			\$conf_app['tanggal_to']            = \"".$this->input->post('conf_app#tanggal_to')."\";
			\$conf_app['check_in_at']           = \"".$this->input->post('conf_app#check_in_at')."\";
			\$conf_app['check_in_to']           = \"".$this->input->post('conf_app#check_in_to')."\";
			
			// CAPCHA 
			\$conf_app['capcha']['background']  = \"".str_replace(")","", str_replace("rgb(", "", $this->input->post('conf_app#background')))."\";
			\$conf_app['capcha']['border']      = \"".str_replace(")","", str_replace("rgb(", "", $this->input->post('conf_app#border')))."\";
			\$conf_app['capcha']['text']        = \"".str_replace(")","", str_replace("rgb(", "", $this->input->post('conf_app#text')))."\";
			\$conf_app['capcha']['grid']        = \"".str_replace(")","", str_replace("rgb(", "", $this->input->post('conf_app#grid')))."\";
			
			// BPJS 
			\$conf_app['bpjs']['secret_key']    = \"".$this->input->post('conf_app#secret_key')."\";
			\$conf_app['bpjs']['customer_id']   = \"".$this->input->post('conf_app#customer_id')."\";
			\$conf_app['bpjs']['url_rujukan']   = \"".$this->input->post('conf_app#url_rujukan')."\";
		";

		$string = "<?php\n".$string."\n?>";
		$this->createFile($string, $target."config.php");

		redirect(base_url()."/setup");
	}


	private function createFile($string, $path){
	    $create = fopen($path, "w") or die("Change your permision folder for application and harviacode folder to 777");
	    fwrite($create, $string);
	    fclose($create);
	    return true;
	}
}
