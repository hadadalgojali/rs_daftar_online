<?php

			$conf_app 	= array();
			$conf_db 	= array();

			// DEFAULT DATABASE MYSQL
			$conf_db['default']['hostname']    = "localhost";
			$conf_db['default']['database']    = "nci_online";
			$conf_db['default']['username']    = "root";
			$conf_db['default']['password']    = "";
			$conf_db['default']['dbdriver']    = "mysqli";
			$conf_db['default']['port']        = "3306";
			
			// DATABASE SECONDARY
			$conf_db['second']['hostname']     = "192.168.0.138";
			$conf_db['second']['database']     = "unand";
			$conf_db['second']['username']     = "postgres";
			$conf_db['second']['password']     = "123456";
			$conf_db['second']['dbdriver']     = "postgre";
			$conf_db['second']['port']         = "3306";

			// INFORMATION RS
			$conf_db['rs']['name']             = "RSUD Ternate";
			$conf_db['rs']['address']          = "Ternate";

			// KONFIGURASI APP
			$conf_app['tanggal_at']            = "0";
			$conf_app['tanggal_to']            = "1";
			$conf_app['check_in_at']           = "07.00";
			$conf_app['check_in_to']           = "18.00";
			
			// CAPCHA 
			$conf_app['capcha']['background']  = "255, 255, 255";
			$conf_app['capcha']['border']      = "158, 252, 230";
			$conf_app['capcha']['text']        = "0, 0, 0";
			$conf_app['capcha']['grid']        = "150, 255, 230";
			
			// BPJS 
			$conf_app['bpjs']['secret_key']    	= "8eXF12CA03";
			$conf_app['bpjs']['customer_id']   	= "25246";
			$conf_app['bpjs']['url_rujukan']   	= "https://new-api.bpjs-kesehatan.go.id:8080/new-vclaim-rest/Rujukan/";
			$conf_app['bpjs']['url_dokter_dpjp']= "https://new-api.bpjs-kesehatan.go.id:8080/new-vclaim-rest/referensi/dokter/pelayanan/";
		
?>