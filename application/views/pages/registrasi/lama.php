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
	<style type="text/css">
		.ui-selectmenu-menu .ui-menu {max-height: 160px;}
	</style>
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
													<input type="text" class="form-control" id="kd_pasien" name="kd_pasien" placeholder="" value="_-__-__-__" data-mask="_-__-__-__" required>
												</div>
											</div>
											<div class="col-md-6 mb-3">
												<div class="input-group">
													<div class="input-group-prepend">
														<span class="input-group-text" style="width: 100px;">Nama</span>
													</div>
													<input type="text" class="form-control" id="nama" name="nama" required disabled="disabled">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 mb-3" >
												<div class="input-group">
													<div class="input-group-prepend">
														<span class="input-group-text" style="width: 100px;">Tgl Lahir</span>
													</div>
													<input type="text" class="form-control" id="tgl_lahir" name="tgl_lahir" value="__-__-____" data-date-format="dd/mm/yyyy" data-mask="__-__-____" required>
												</div>
											</div>
											<div class="col-md-6 mb-3">
												<div class="input-group">
													<div class="input-group-prepend">
														<span class="input-group-text" style="width: 100px;">Alamat</span>
													</div>
													<input type="text" class="form-control" id="alamat" required disabled="disabled">
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-12">
												<div class="input-group">
													<button class="btn btn-primary" id="btn_search"><i id="btn_load_search" class="fa fa-search"></i> Cari</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12 py-2">
								<div class="card">
									<div class="card-header">
										<b>DATA</b> KUNJUNGAN :
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="staticEmail" class="col-sm-3 col-form-label">Penjamin</label>
													<div class="col-sm-9">
														<select name="kelompok" id="kelompok" class="form-control"></select>
													</div>
												</div>
												<div class="form-group row">
													<label for="inputPassword" class="col-sm-3 col-form-label">Keluhan</label>
													<div class="col-sm-9">
														<textarea class="form-control"></textarea>
													</div>
												</div>
												<div class="form-group row">
													<label for="inputPassword" class="col-sm-3 col-form-label">Tanggal</label>
													<div class="col-sm-9">
														<input type="text" class="form-control" id="tgl_kunjungan" readonly name="tgl_kunjungan" value="<?php echo date("d-m-Y"); ?>" data-date-format="dd/mm/yyyy" data-mask="__-__-____" required>
													</div>
												</div>
												<div class="form-group row">
													<label for="inputPassword" class="col-sm-3 col-form-label">Telepon</label>
													<div class="col-sm-9">
														<input type="text" class="form-control" id="telepon" name="telepon" required>
													</div>
												</div>
												<div class="form-group row">
													<label for="staticEmail" class="col-sm-3 col-form-label">Poliklinik</label>
													<div class="col-sm-9">
														<select name="poliklinik" id="poliklinik" class="form-control"></select>
													</div>
												</div>
												<div class="form-group">
													<table width="100%">
														<tr>
															<td><?php echo $image_captcha; ?></td>
															<td><input type="text" class="form-control" id="captcha" name="captcha"></td>
														</tr>
													</table>
												</div>
											</div>


											<div class="col-md-6" id="form-bpjs" style="display: none;">
												<form>
													<div class="form-group row">
														<label for="staticEmail" class="col-sm-3 col-form-label">Email</label>
														<div class="col-sm-9">
															<input type="text" class="form-control" id="staticEmail" value="email@example.com">
														</div>
													</div>
													<div class="form-group row">
														<label for="inputPassword" class="col-sm-3 col-form-label">Password</label>
														<div class="col-sm-9">
															<input type="password" class="form-control" id="inputPassword" placeholder="Password">
														</div>
													</div>
												</form>
											</div>
										</div>

										<div class="alert alert-success" role="alert">
											<table>
												<tr>
													<td width="120">Hari/ Tanggal</td>
													<td>: <span id="ket_tgl_checkin"><?php echo date('d-m-Y'); ?></span></td>
												</tr>
												<tr>
													<td>Jam Checkin</td>
													<td>: <span id="ket_jam_checkin"><?php echo $check_in_at." - ".$check_in_to; ?></span></td>
												</tr>
												<tr>
													<td>Klinik</td>
													<td>: <span id="ket_klinik"></span></td>
												</tr>
											</table>
										</div>
										<div class="form-group">
											<button class="btn btn-primary" id="btn_save">Simpan</button>
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

	    function validate_time(t,st,et){
	       t = t.split(/-/);
	       st = st.split(/-/);
	       et = et.split(/-/);
	       return (t[0] < st[0] 
	            || t[0] > et[0] 
	            || (t[0] == st[0] && t[1] < st[1])
	            || (t[0] == et[0] && t[1] > et[1]));
	    }

	    // Call like:

		var getnow     = new Date();
		var hrs_now = getnow.getHours() < 10 ? "0" + getnow.getHours() : getnow.getHours();
		var mnt_now = getnow.getMinutes() < 10 ? "0" + getnow.getMinutes() : getnow.getMinutes();

		var getNextDay = new Date();
		getNextDay.setDate(getNextDay.getDate()+1); //date + 1
		var tgl_tommorow = ("0" + (getNextDay.getDate())).slice(-2); // format 2 digit
		var bulan_besok = ("0" + (getNextDay.getMonth()+1)).slice(-2); //format 2 digit
		var NextDay = tgl_tommorow+'-'+bulan_besok+'-'+getNextDay.getFullYear();


		$("#btn_save").click(function(){
			if ($('#tgl_kunjungan').val() == NextDay || $('#tgl_kunjungan').val() == "<?php echo date('d-m-Y') ?>") {
				if (validate_time("<?php echo $check_in_to; ?>","<?php echo $check_in_at; ?>",hrs_now+"-"+mnt_now) === false) {
					$.toast({
						heading: 'Infomasi',
						text: 'Masa pendaftaran telah berakhir',
						icon: 'warning',
						position: 'top-right',
					});
				}else if($('#captcha').val() !== "<?php echo $word_captcha; ?>"){
					$.toast({
						heading: 'Infomasi',
						text: 'Captcha salah, silahkan ulangi kembali',
						icon: 'warning',
						position: 'top-right',
					});
				}else{
					$.toast({
						heading: 'Infomasi',
						text: 'Pendaftaran telah berhasil',
						icon: 'info',
						position: 'top-right',
					});
				}
			}
		});

		$('#kelompok').selectmenu({
			create: function(evt,ui) {
				$.ajax({
					url 		: "<?php echo base_url()?>Daftar/search_customer",
					dataType 	: 'json',
					delay 		: 2000,
					success: function(data) {
						if (data.status === true) {
							$.each(data.customer, function (index, data) {
								$("#kelompok").append("<option value='" + data.customer_code + "'>" + data.customer_name + "</option>");
							});
						}
					}
				})
			},
			select : function(evt, ui){
				// console.log(ui.item);
			},
			style: 'dropdown',
			width:'100%',
		});

		$('#poliklinik').selectmenu({
			create: function(evt,ui) {
				$.ajax({
					url 		: "<?php echo base_url()?>Daftar/search_unit",
					dataType 	: 'json',
					delay 		: 2000,
					type 		: "POST",
					data 		: {
						criteria: JSON.stringify({ unit_type : 'UNITTYPE_RWJ', }),
					},
					success: function(data) {
						if (data.status === true) {
							$.each(data.unit, function (index, data) {
								$("#poliklinik").append("<option value='" + data.unit_code + "'>" + data.unit_name + "</option>");
							});
						}
					}
				})
			},
			select : function(evt, ui){
				// console.log(ui.item.label);
				document.getElementById('ket_klinik').innerHTML = ui.item.label;
			},
			style: 'dropdown',
			width:'100%',
		});

		$('#tgl_lahir').datepicker({
			dateFormat: "dd-mm-yy"
		});

		$('#tgl_kunjungan').datepicker({
			dateFormat 	: "dd-mm-yy",
			minDate 	: '<?php echo $tanggal_at; ?>', 
			maxDate 	: '<?php echo $tanggal_to; ?>',
			onSelect 	: function(dateText, inst) {
				document.getElementById('ket_tgl_checkin').innerHTML = dateText;
			}
		});

		$('#btn_search').click(function(){
			$("#btn_load_search").attr('class', 'fa fa-spinner fa-spin');
			$("#btn_search").attr("disabled", true);

			$.ajax({
				url: "<?php echo base_url(); ?>"+"Daftar/search_patient",
				type: "POST",
				data: {
					kd_pasien : $("#kd_pasien").val(),
					tgl_lahir : $("#tgl_lahir").val(),
				},
				success: function (response) {
					var Obj = JSON.parse(response);
					$("#btn_load_search").attr('class', 'fa fa-save');
					$("#btn_search").attr("disabled", false);

					if (Obj.status === false && Obj.patient.num_rows == 0) {
						$.toast({
							heading: 'Infomasi',
							text: [
								'Data tidak ditemukan', 
								'Periksa kembali Kode Pasien dan Tanggal Lahir', 
							],
							icon: 'info',
							position: 'top-right',
						});
					}else{
						$("#nama").val(Obj.patient[0].name);
						$("#alamat").val(Obj.patient[0].address);
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(textStatus, errorThrown);
				}
			});
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