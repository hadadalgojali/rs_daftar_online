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
	<main role ="main">
		<div class ="album py-4">
			<div class="container">
				<div class="row">
					<?php echo $_menu; ?>
					<div class="col-md-9">
						<div class="row">
							<div class="col-md-12 py-2">
								<div class="card">
									<div class="card-header">
										<b>PENDAFTARAN</b> PASIEN LAMA :
									</div>
									<div class="card-body">

										<div class="row">
											<div class="col-md-6 mb-3">
												<div class="input-group">
													<div class="input-group-prepend">
														<span class="input-group-text" style="width: 100px;">No Medrec</span>
													</div>
													<input type="text" class="form-control" id="firstName" placeholder="" value="_-__-__-__" data-mask="_-__-__-__" required>
													<div class="invalid-feedback">
														Valid first name is required.
													</div>
												</div>
											</div>
											<div class="col-md-6 mb-3">
												<div class="input-group">
													<div class="input-group-prepend">
														<span class="input-group-text" style="width: 100px;">Nama</span>
													</div>
													<input type="text" class="form-control" id="firstName" placeholder="" value="" required disabled="disabled">
													<div class="invalid-feedback">
														Valid first name is required.
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											
											<!-- <div class="col-md-6 mb-3">
												<label for="firstName">Tgl Lahir</label>
												<input type="text" class="form-control" id="firstName" placeholder="" value="DD-MM-YYYY" data-mask="__-__-____" required>
												<div class="invalid-feedback">
													Valid first name is required.
												</div>
											</div> -->
											<div class="col-md-6 mb-3" >
												<div class="input-group">
													<div class="input-group-prepend">
														<span class="input-group-text" style="width: 100px;">Tgl Lahir</span>
													</div>
													<input type="text" class="form-control" id="datepicker" name="tgl_lahir" value="__-__-____" data-date-format="dd/mm/yyyy" data-mask="__-__-____" value="" required>
													<div class="invalid-feedback">
														Tanggal lahir is required.
													</div>
												</div>
											</div>
											<!-- <div class="input-group date" data-provide="datepicker">
											    <input type="text" class="form-control">
											    <div class="input-group-addon">
											        <span class="glyphicon glyphicon-th"></span>
											    </div>
											</div> -->
											<div class="col-md-6 mb-3">
												<label for="lastName">Alamat</label>
												<textarea class="form-control" id="address" name="address" disabled="disabled"></textarea>
												<div class="invalid-feedback">
													Valid last name is required.
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
	<?php echo $_footer; ?>
	<?php echo $_include_js; ?>
	<script type="text/javascript">
		// $.fn.datepicker.defaults.format = 'dd/mm/yyyy';
		$('#datepicker').datepicker({
			// format: 'dd/mm/yyyy',
			dateFormat: "dd-mm-yy"
		});
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