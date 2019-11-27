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
	<link href="<?php echo base_url(); ?>assets/jquery-colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet">
</head>
<body>
	<?php echo $_header; ?>
	<main role ="main">
		<div class ="album py-4">
			<div class="container">
				<div class="row">
					<?php echo $_menu; ?>
					<div class="col-md-9">
						<form action="<?php base_url(); ?>Setup/update" method="POST">
							<div class="row">
								<div class="col-md-12 py-2">
									<div class="card">
										<div class="card-header">
											<b>SETUP</b> APLIKASI :
										</div>
										<div class="card-body">
											<div class="row">
												<?php  
													foreach ($config_app as $key => $value) {
														?>
														<?php if ($key !== "capcha" && $key !== "bpjs") { ?>
															<div class="col-md-12 mb-3">
																<div class="input-group">
																	<div class="input-group-prepend">
																		<span class="input-group-text" style="width: 200px;"><?php echo strtoupper($key); ?></span>
																	</div>
																	<?php 
																		if (strtoupper($key) == "CHECK_IN_AT" || strtoupper($key) == "CHECK_IN_TO") {
																			?>
																			<input type="text" class="form-control" id="<?php echo "conf_app#".$key; ?>" name="<?php echo "conf_app#".$key; ?>" placeholder="" value="<?php echo $value; ?>" data-mask="__.__" required>
																			<?php
																		}else{
																			?>
																			<input type="text" class="form-control" id="<?php echo "conf_app#".$key; ?>" name="<?php echo "conf_app#".$key; ?>" placeholder="" value="<?php echo $value; ?>" required>
																			<?php
																		}
																	?>
																</div>
															</div>
														<?php } ?>
														<?php
													}
												?>
												<?php 
													foreach ($config_app['capcha'] as $key => $value) {
														?>
														<div class="col-md-12 mb-3">
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text" style="width: 200px;"><?php echo strtoupper($key); ?></span>
																</div>
																<input type="text" class="form-control warna" name="<?php echo "conf_app#".$key; ?>" value="rgb(<?php echo $value; ?>)" />
															</div>
														</div>
														<?php 
													}
												?>
												<?php 
													foreach ($config_app['bpjs'] as $key => $value) {
														?>
														<div class="col-md-12 mb-3">
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text" style="width: 200px;"><?php echo strtoupper($key); ?></span>
																</div>
																<input type="text" class="form-control" name="<?php echo "conf_app#".$key; ?>" value="<?php echo $value; ?>" />
															</div>
														</div>
														<?php 
													}
												?>
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-12 py-2">
									<input type="submit" id="btn_save" value="Simpan" class="btn btn-primary" style="float:right;">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</main>
	<?php echo $_footer; ?>
	<?php echo $_include_js; ?>
	<script src ="<?php echo base_url(); ?>assets/jquery-colorpicker/js/bootstrap.bundle.min.js"></script>
	<script src ="<?php echo base_url(); ?>assets/jquery-colorpicker/js/bootstrap-colorpicker.js"></script>
	<script type="text/javascript">
		$('.warna').colorpicker();

		Array.prototype.forEach.call(document.body.querySelectorAll("*[data-mask]"), applyDataMask);

		function applyDataMask(field) {
			var mask = field.dataset.mask.split('');
			
			// For now, this just strips everything that's not a number
			function stripMask(maskedData) {
				function isDigit(char) {
					return /\d/.test(char);
				}
				return maskedData.split('').filter(isDigit);
			}
		    
		    // Replace `_` characters with characters from `data`
			function applyMask(data) {
				return mask.map(function(char) {
					if (char        != '_') return char;
					if (data.length == 0) return char;
					return data.shift();
				}).join('')
			}
		    
			function reapplyMask(data) {
				return applyMask(stripMask(data));
			}
		    
			function changed() {   
				var oldStart         = field.selectionStart;
				var oldEnd           = field.selectionEnd;
				
				field.value          = reapplyMask(field.value);
				
				field.selectionStart = oldStart;
				field.selectionEnd   = oldEnd;
			}
		    
			field.addEventListener('click', changed)
			field.addEventListener('keyup', changed)
		}
	</script>
</body>
</html>