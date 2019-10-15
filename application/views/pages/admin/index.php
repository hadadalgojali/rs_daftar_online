<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
	<title>Pendaftaran Online</title>
	<!-- <link rel="stylesheet" type="text/css" href="<?php //echo base_url(); ?>assets/Extjs/build/packages/ext-theme-classic/build/resources/ext-theme-classic-all.css"> -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/Extjs/build/packages/ext-theme-neptune/build/resources/ext-theme-neptune-all.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/font-awesome/css/font-awesome.min.css" />
	<!-- <link rel="stylesheet" type="text/css" href="<?php //echo base_url(); ?>assets/admin_style.css"> -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/Extjs/build/ext-all.js"></script>
	<!-- <script type="text/javascript" src="<?php //echo base_url(); ?>app/system/Common.js"></script> -->
	<style type="text/css">
		body{
			margin : 0px;
			padding: 0px;
		}
	</style>
	<script type="text/javascript">
		var url 	= "<?php echo base_url(); ?>";
		var session = {};
		session.user= [];
		session.menu= [];
	</script>
</head>
<body>
	<?php echo $_include_js; ?>
	<script type="text/javascript" src="<?php echo base_url(); ?>app/app.js"></script>
</body>
</html>