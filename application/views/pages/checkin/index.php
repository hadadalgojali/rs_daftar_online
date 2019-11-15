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
	<?php echo $_include_css; ?>
	
</head>
<body>
	<?php echo $_header; ?>
	<div id="main">
		
	</div>
	<?php echo $_include_js; ?>
	<script type="text/javascript">
		$("#main").load("<?php echo base_url(); ?>"+"checkin/search_form", function(responseTxt, statusTxt, xhr){
		});
	</script>
</body>
</html>