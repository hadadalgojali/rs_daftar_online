<?php
	$conf_app = array();
	$conf_db  = array();

	// DEFAULT DATABASE MYSQL
	$conf_db['default']['hostname'] = "localhost";
	$conf_db['default']['database'] = "nci_online";
	$conf_db['default']['username'] = "root";
	$conf_db['default']['password'] = "";
	$conf_db['default']['dbdriver'] = "mysqli";
	$conf_db['default']['port'] 	= "3306";

	// DEFAULT DATABASE SECONDARY
	$conf_db['second']['hostname'] 	= "192.168.0.138";
	$conf_db['second']['database'] 	= "unand";
	$conf_db['second']['username'] 	= "postgres";
	$conf_db['second']['password'] 	= "123456";
	$conf_db['second']['dbdriver'] 	= "postgre";
	$conf_db['second']['port'] 		= "3306";

	// CONFIG ABOUT RS
	$conf_db['rs']['name'] 			= "Rumah Sakit Ternate";
	$conf_db['rs']['address'] 		= "Ternate";

	$conf_app['tanggal_at']			= 0;
	$conf_app['tanggal_to']			= 7;

	$conf_app['check_in_at']		= "07.00";
	$conf_app['check_in_to']		= "18.00";

