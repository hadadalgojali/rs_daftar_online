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
	<link href="<?php echo base_url(); ?>/assets/bootstrap/css/step-form-v2.css" rel="stylesheet" type="text/css" />
	<style type="text/css">
		.ui-selectmenu-menu .ui-menu {max-height: 160px;}
	</style>
</head>
<body>
	<script type="text/javascript">
		var status_    	= {};
		var parameter 	= {};
		var _rujukan 	= {};
		_rujukan.kd_kelas 		= "";
		_rujukan.no_kartu 		= "";
		_rujukan.kd_poli 		= "";
		_rujukan.kd_diagnosa 	= "";
		_rujukan.rujukan 		= "";
		_rujukan.faskes 		= 1;
		_rujukan.kd_faskes 		= "";
		_rujukan.tgl_rujukan 	= "";
		_rujukan.kd_dpjp 		= "";

		parameter.penjamin  		= "";
		parameter.jenis_penjamin  	= "0";
		parameter.klinik  			= "";

		status_.get_pasien 		= false;
		status_.check_validasi 	= false;
	</script>
	<?php echo $_header; ?>
	<main role ="main">
		<div class ="album py-4">
			<div class="container">
				<div class="row">
					<?php //echo $_menu; ?>
					<div class="col-md-12">

						<div class="row">
							<div class="col-md-12 py-2">
								<div class="alert alert-success" role="alert" style="display: none;" id="result_pendaftaran">
									Pendaftaran Berhasil.<br>
									Harap Catat Nomor Pendaftaran dibawah ini untuk kunjungan Rumah Sakit:
									<h3><span id="result_no_pendaftaran">-</span></h3>
									Atas :
									<table border="0" width="100%">
										<tr>
											<td>Medrec</td>
											<td>: <span id="result_medrec">-</span></td>
											<td width="120" rowspan="4">
												<img id="img_qr_code" width="120">
											</td>
										</tr>
										<tr>
											<td>Nama</td>
											<td>: <span id="result_nama">-</span></td>
										</tr>
										<tr>
											<td width="120">Hari/ Tanggal</td>
											<td>: <span id="result_tgl_checkin">-</span></td>
										</tr>
										<tr>
											<td>Klinik</td>
											<td>: <span id="result_klinik">-</span></td>
										</tr>
									</table>
								</div>

								<!-- <div class="card">
									<div class="card-header">
										<b>PENDAFTARAN</b> PASIEN LAMA :
									</div>
									<div class="card-body">
									</div>
								</div> -->
							</div>
						</div>

<div class="row" style="text-align: left;">
	<div class="col-md-12 py-2">
		<div class="card">
			<div class="card-header">
				<b>DATA</b> KUNJUNGAN :
			</div>

            <!-- fieldsets -->
<div class="card-body">
	<div class="row">
		<div class="col-md-12">
        <form id="regForm" action="javascript:;" method="post">
<!-- One "tab" for each step in the form: -->
<div class="tab">
	<div class="row">
		<div class="col-md-12 mb-3">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text" style="width: 100px;">No Medrec</span>
				</div>
				<input type="text" class="form-control" id="kd_pasien" name="kd_pasien" placeholder="" value="_-__-__-__" data-mask="_-__-__-__" required>
			</div>
		</div>
		<div class="col-md-12 mb-3" >
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text" style="width: 100px;">Tgl Lahir</span>
				</div>
				<input type="text" class="form-control" id="tgl_lahir" name="tgl_lahir" value="__-__-____" data-date-format="dd-mm-yyyy" data-mask="__-__-____" required>
			</div>
		</div>
		<div class="col-md-12 mb-3">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text" style="width: 100px;">Nama</span>
				</div>
				<input type="text" class="form-control" id="nama" name="nama" required disabled>
			</div>
		</div>
		<div class="col-md-12 mb-3">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text" style="width: 100px;">Alamat</span>
				</div>
				<input type="text" class="form-control" id="alamat" required disabled>
			</div>
		</div>
	</div>
</div>

<div class="tab">
 	<div class="form-group row">
		<label for="staticEmail" class="col-sm-3 col-form-label">Penjamin</label>
		<div class="col-sm-9">
			<select name="kelompok" id="kelompok" class="form-control"></select>
		</div>
	</div>
	<div class="form-group row" style="display: none;" id="select_jenis_kunjungan">
		<label for="staticEmail" class="col-sm-3 col-form-label">Jenis Kunj</label>
		<div class="col-sm-9">
			<select name="jenis_kunjungan" id="jenis_kunjungan" class="form-control">
				<option value="1" selected="selected">Episode Baru</option>
				<option value="2">Episode Lanjutan</option>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label for="inputPassword" class="col-sm-3 col-form-label">Keluhan</label>
		<div class="col-sm-9">
			<textarea class="form-control" style="height: 95px;" id="keluhan"></textarea>
		</div>
	</div>
	<div class="form-group row">
		<label for="inputPassword" class="col-sm-3 col-form-label">Telepon</label>
		<div class="col-sm-9">
			<input type="text" class="form-control" id="telepon" name="telepon" required>
		</div>
	</div>
	<div class="form-group row">
		<label for="staticKlinik" class="col-sm-3 col-form-label">Poliklinik</label>
		<div class="col-sm-9">
			<select name="poliklinik" id="poliklinik" class="form-control"></select>
		</div>
	</div>
	<div class="form-group row">
		<label for="staticDokter" class="col-sm-3 col-form-label">Dokter</label>
		<div class="col-sm-9">
			<select name="dokter" id="dokter" class="form-control"></select>
		</div>
	</div>
	<div class="form-group row">
		<label for="inputTglMasuk" class="col-sm-3 col-form-label">Tanggal</label>
		<div class="col-sm-9">
			<input type="text" class="form-control" id="tgl_kunjungan" readonly name="tgl_kunjungan" data-date-format="dd-mm-yyyy" data-mask="__-__-____" value="__-__-____" placeholder="__/__/____" required>
		</div>
	</div>
</div>

<div class="tab">
	<!-- <div id="form-bpjs" > -->
	 	<div class="form-group row">
			<label for="staticEmail" class="col-sm-3 col-form-label">No Rujuk</label>
			<div class="col-sm-9">
				<div class="input-group">
					<input type="text" class="form-control" id="no_rujukan" name="no_rujukan">
					<div class="input-group-prepend">
						<button class="btn btn-primary" id="btn_no_rujukan"><span id="check_btn_no_rujukan">Cek</span> <i class="fa fa-spinner fa-spin" style="display: none;" id="check_load_no_rujukan"></i></button>
					</div>
				</div>
			</div>
		</div>

	 	<div class="form-group row">
			<label for="staticEmail" class="col-sm-3 col-form-label">Tgl Rujuk</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="tgl_rujukan" name="tgl_rujukan" disabled="disabled">
			</div>
		</div>
		
		<div class="form-group row">
			<label for="staticEmail" class="col-sm-3 col-form-label">Faskes</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="faskes" name="faskes" disabled="disabled">
			</div>
		</div>

		<div class="form-group row">
			<label for="staticEmail" class="col-sm-3 col-form-label">Kelas</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="kelas" name="kelas" disabled="disabled">
			</div>
		</div>
		<div class="form-group row">
			<label for="staticEmail" class="col-sm-3 col-form-label">Diagnosa</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="diagnosa" name="diagnosa" disabled="disabled">
			</div>
		</div>
		<div class="form-group row">
			<label for="staticEmail" class="col-sm-3 col-form-label">Klinik Rujukan</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="klinik_rujukan" name="klinik_rujukan" disabled="disabled">
			</div>
		</div>
		<div class="form-group row">
			<label for="staticEmail" class="col-sm-3 col-form-label">Pemberi surat</label>
			<div class="col-sm-9">
				<select id="pemberi_surat" class="form-control"></select>
			</div>
		</div>
	<!-- </div> -->
</div>

<div class="tab">
	<div class="form-group row">
		<label for="inputTglMasuk" class="col-sm-3 col-form-label"><?php echo $image_captcha; ?></label>
		<div class="col-sm-9"><input type="text" class="form-control" id="captcha" name="captcha"></div>
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
</div>

<div style="overflow:auto;">
  <div style="float:right;">
    <button type="button" id="prevBtn" class="btn btn-default" onclick="nextPrev(-1)">Previous</button>
    <button type="button" id="nextBtn" class="btn btn-primary" onclick="nextPrev(1)">Next</button>
    <button class="btn btn-primary" id="btn_search"><i id="btn_load_search" class="fa fa-search"></i> Cari</button>
	<button class ="btn btn-primary" id="btn_save"><i class="fa fa-save" id="btn_load_save"></i> Simpan</button>
  </div>
</div>

<!-- Circles which indicates the steps of the form: -->
<div style="text-align:center;margin-top:40px;">
  <span class="step"></span>
  <span class="step"></span>
  <span class="step"></span>
  <span class="step"></span>
</div>
        </form>
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

	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title"><span id="ModalTitle" >Modal title</span></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<div class="modal-body">
				<span id="ModalBody"></span>
			</div>
			<div class="modal-footer">
				<button type="button" id="btnModal_close" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" id="btnModal_save" class="btn btn-primary">Save</button>
				<button type="button" id="btnModal_update" class="btn btn-success">Update</button>
				<button type="button" id="btnModal_delete" class="btn btn-danger">Delete</button>
			</div>
			</div>
		</div>
	</div>

	<?php echo $_footer; ?>
	<?php echo $_include_js; ?>
	<!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script> -->
	<script type="text/javascript" src="<?php echo base_url(); ?>/assets/bootstrap/js/step-form-v2.js"></script>
	<script type="text/javascript">
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
			field.addEventListener('keydown', changed)
		}

		function hide_btn_modal(){
			document.getElementById('btnModal_save').style.display   = 'none';
			document.getElementById('btnModal_update').style.display = 'none';
			document.getElementById('btnModal_delete').style.display = 'none';
		}

	    function validate_time(t,st,et){
	       t = t.split(/-/);
	       st = st.split(/-/);
	       et = et.split(/-/);
	       return (t[0] < st[0]
	            || t[0] > et[0]
	            || (t[0] == st[0] && t[1] < st[1])
	            || (t[0] == et[0] && t[1] > et[1]));
	    }

	    $("#btn_no_rujukan").click(function(){
			document.getElementById('check_btn_no_rujukan').style.display 	= "none";
			document.getElementById('check_load_no_rujukan').style.display 	= "";
	    	$.ajax({
				url 		: "<?php echo base_url()?>Vclaim/check_rujukan",
				dataType 	: 'json',
				delay 		: 2000,
				type 		: "POST",
				data 		: {
					no_signature 	: $('#no_rujukan').val(),
				},
				success: function(data) {
					document.getElementById('check_btn_no_rujukan').style.display 	= "";
					document.getElementById('check_load_no_rujukan').style.display 	= "none";
					if (data.metaData.code == 200) {
						$.toast({
							heading 	: 'Infomasi',
							text 		: 'No rujukan telah ditemukan',
							icon 		: 'info',
							position 	: 'top-right',
						});
						// DISINI
						$('#tgl_rujukan').val(data.response.rujukan.tglKunjungan);
						$('#faskes').val(data.response.rujukan.provPerujuk.nama);
						$('#kelas').val(data.response.rujukan.peserta.hakKelas.keterangan);
						$('#diagnosa').val(data.response.rujukan.diagnosa.kode+"-"+data.response.rujukan.diagnosa.nama);
						$('#klinik_rujukan').val(data.response.rujukan.poliRujukan.kode+"-"+data.response.rujukan.poliRujukan.nama);

						_rujukan.kd_kelas 		= data.response.rujukan.peserta.hakKelas.kode;
						_rujukan.no_kartu 		= data.response.rujukan.peserta.noKartu;
						_rujukan.kd_poli 		= data.response.rujukan.poliRujukan.kode;
						_rujukan.kd_diagnosa 	= data.response.rujukan.diagnosa.kode;
						_rujukan.rujukan 		= $('#no_rujukan').val();
						_rujukan.kd_faskes 		= data.response.rujukan.provPerujuk.kode;
						// _rujukan.faskes 		= data.response.rujukan.provPerujuk.nama;
						_rujukan.tgl_rujukan 	= data.response.rujukan.tglKunjungan;
						// rujukan.kd_dpjp 	= "";

				    	$.ajax({
							url 		: "<?php echo base_url()?>Vclaim/check_dokter_dpjp",
							dataType 	: 'json',
							delay 		: 2000,
							type 		: "POST",
							data 		: {
								pelayanan 	: 2,
								spesialis 	: data.response.rujukan.poliRujukan.kode,
							},
							success : function(data){
								// console.log(data.response.list.length);
								if (data.metaData.code == 200 || data.metaData.code == '200') {
									_rujukan.kd_dpjp = data.response.list[0].kode;
									for(var i = 0; i<data.response.list.length; i++){
										$('#pemberi_surat').append($('<option>', {
											value 	: data.response.list[i].kode,
											text 	: data.response.list[i].nama
										}));
									}
								}
							}
						});

				    	$.ajax({
							url 		: "<?php echo base_url()?>Vclaim/get_faskes",
							dataType 	: 'json',
							delay 		: 2000,
							type 		: "POST",
							data 		: {
								faskes 	: data.response.rujukan.provPerujuk.kode,
							},
							success : function(data){
								// console.log(data.response.list.length);
								if (data.metaData.code !== '200') {
									_rujukan.faskes = 2;
								}
							}
						});
					}else{
						$.toast({
							heading 	: 'Infomasi',
							text 		: 'No rujukan tidak ditemukan',
							icon 		: 'warning',
							position 	: 'top-right',
						});
					}
				}
			});
	    });

	    $('#pemberi_surat').change(function(text, evt){
	    	_rujukan.kd_dpjp = text.target.value;
	    });

	    // Call like:
		var getnow     = new Date();
		var hrs_now = getnow.getHours() < 10 ? "0" + getnow.getHours() : getnow.getHours();
		var mnt_now = getnow.getMinutes() < 10 ? "0" + getnow.getMinutes() : getnow.getMinutes();
		var capthca = $('#captcha').val();
		$("#btn_save").click(function(){
			if($('#kd_pasien').val() == "_-__-__-__" && $('#tgl_lahir').val() == "__-__-____"){
				$.toast({
					heading: 'Infomasi',
					text: 'Pasien belum dipilih',
					icon: 'warning',
					position: 'top-right',
				});
				status_.check_validasi = false;
			}else if (validate_time("<?php echo $check_in_to; ?>","<?php echo $check_in_at; ?>",hrs_now+"-"+mnt_now) === false) {
				$.toast({
					heading: 'Infomasi',
					text: 'Masa pendaftaran telah berakhir',
					icon: 'warning',
					position: 'top-right',
				});
				status_.check_validasi = false;
			}else if($('#captcha').val().toLowerCase() !== "<?php echo strtolower($word_captcha); ?>"){
				console.log($('#captcha').val().toLowerCase());
				console.log("<?php echo strtolower($word_captcha); ?>");
				$.toast({
					heading: 'Infomasi',
					text: 'Captcha salah, silahkan ulangi kembali',
					icon: 'warning',
					position: 'top-right',
				});
				status_.check_validasi = false;
			}else if(status_.check_validasi === false && status_.get_pasien === false){
				$.toast({
					heading: 'Infomasi',
					text: 'Perhatikan kembali formulir pendaftaran',
					icon: 'warning',
					position: 'top-right',
				});
			}else if(parameter.klinik == ""){
				$.toast({
					heading 	: 'Infomasi',
					text 		: 'Anda belum memilih klinik',
					icon 		: 'warning',
					position 	: 'top-right',
				});
			}else{
				// $.toast({
				// 	heading: 'Infomasi',
				// 	text: 'Pendaftaran telah berhasil',
				// 	icon: 'info',
				// 	position: 'top-right',
				// });
				status_.check_validasi = true;
			}

			if (status_.check_validasi === true && status_.get_pasien === true) {
				$("#btn_load_save").attr('class', 'fa fa-spinner fa-spin');
				$.ajax({
					url 		: "<?php echo base_url()?>Daftar/create",
					dataType 	: 'json',
					delay 		: 2000,
					type 		: "POST",
					data 		: {
						patient_code 	: $('#kd_pasien').val(),
						penjamin 		: parameter.penjamin,
						jenis_kunjungan	: parameter.jenis_penjamin,
						keluhan			: $('#keluhan').val(),
						tgl_kunjungan	: $('#tgl_kunjungan').val(),
						telepon			: $('#telepon').val(),
						klinik			: parameter.klinik,
						no_rujukan 		: $('#no_rujukan').val(),
						data_rujukan 	: JSON.stringify(_rujukan),
					},
					success: function(data) {
						$("#btn_load_save").attr('class', 'fa fa-save');
						// console.log(data);
						if (data.status === true) {
							document.getElementById('result_pendaftaran').style.display = "";
							document.getElementById('result_nama').innerHTML            = data.patient[0].name;
							document.getElementById('result_tgl_checkin').innerHTML     = data.parameter.tgl_kunjungan;
							document.getElementById('result_medrec').innerHTML     		= data.parameter.patient_code;
							document.getElementById('result_klinik').innerHTML     		= data.unit[0].unit_name;
							document.getElementById('result_klinik').innerHTML     		= data.unit[0].unit_name;
							document.getElementById('result_no_pendaftaran').innerHTML  = data.parameter.no_pendaftaran;
							// img_qr_code
							document.getElementById("img_qr_code").src = "<?php echo base_url() ?>"+"/assets/image/qrcode/"+data.parameter.no_pendaftaran+".png";
						}
					}
				});
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
								$("#kelompok").append("<option value='" + data.customer_code + "' initial='" + data.bpjs + "'>" + data.customer_name + "</option>");
							});
						}
					}
				})
			},
			select : function(evt, ui){
				// console.log(ui.item.element[0].attributes[1].value);
				parameter.penjamin  		= ui.item.value;
				if (ui.item.element[0].attributes[1].value == '1'){
					parameter.jenis_penjamin = "1";
					document.getElementById('select_jenis_kunjungan').style.display = '';
					// document.getElementById('form-bpjs').style.display = '';
					// $("#form-bpjs *").enable();
					// $('#form-bpjs *').prop('disabled',false);
					$('#no_rujukan').prop('disabled',false);
					$('#pemberi_surat').prop('disabled',false);
					$('#btn_no_rujukan').prop('disabled',false);
				}else{
					parameter.jenis_penjamin = "0";
					document.getElementById('select_jenis_kunjungan').style.display = 'none';
					// $("#form-bpjs *").disable();
					// $('#form-bpjs *').prop('disabled',true);
					$('#no_rujukan').prop('disabled',true);
					$('#pemberi_surat').prop('disabled',true);
					$('#btn_no_rujukan').prop('disabled',true);
					// document.getElementById('form-bpjs').style.display = 'none';

					_rujukan.kd_kelas 		= "";
					_rujukan.kd_poli 		= "";
					_rujukan.kd_diagnosa 	= "";
					_rujukan.rujukan 		= "";
					_rujukan.tgl_rujukan 	= "";
					_rujukan.kd_dpjp 		= "";

					$('#no_rujukan').val('');
					$('#tgl_rujukan').val('');
					$('#faskes').val('');
					$('#kelas').val('');
					$('#diagnosa').val('');
					$('#klinik_rujukan').val('');
					$('#pemberi_surat').empty();
				}
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
								$("#poliklinik").append("<option value='" + data.unit_id + "'>" + data.unit_name + "</option>");
							});
						}
					}
				});
			},
			select : function(evt, ui){
				document.getElementById('ket_klinik').innerHTML = ui.item.label;
				parameter.klinik = ui.item.value;

				// $("#dokter").empty();
				// $('#dokter option').remove();
				// document.getElementById('dokter').value = '';
				$("#dokter option").each(function(){$(this).remove();});
				$("#dokter option[value='']").attr('selected', true);

				document.getElementById("dokter").innerHTML = "";
				$.ajax({
					url 		: "<?php echo base_url()?>Daftar/search_dokter",
					dataType 	: 'json',
					delay 		: 2000,
					type 		: "POST",
					data 		: {
						criteria: JSON.stringify({ active_flag : '1', job_id : '2', unit_id : ui.item.value }),
					},
					success: function(data) {
						if (data.status === true) {
							if (data.dokter.length > 0) {
								$("#dokter option").each(function(){$(this).remove();});
								$("#dokter option[value='']").attr('selected', true);
								$.each(data.dokter, function (index, data) {
									$("#dokter").append("<option value='" + data.employee_id + "'>" + data.first_name+ " " +data.last_name + "</option>");
								});
							}
						}
						$( '#dokter' ).selectmenu( "refresh" );
					}
				});
			},
			style: 'dropdown',
			width:'100%',
		});

		function get_jadwal(tmp_unit_id = null, tmp_dokter_id = null){
			$.ajax({
				url 		: "<?php echo base_url()?>Daftar/search_jadwal",
				dataType 	: 'json',
				delay 		: 2000,
				type 		: "POST",
				data 		: {
					criteria: JSON.stringify({ unit_id : tmp_unit_id, employee_id : tmp_dokter_id }),
				},
				success: function(data) {
					if (data.status === true) {
						var tmp_days = [];
						$.each(data.jadwal, function (index, data) {
							var tmp_day = data.hari;
							console.log(tmp_day.toLowerCase());
							if (tmp_day.toLowerCase() == "senin") {
								tmp_days.push(1);
								console.log(1);
							}else if (tmp_day.toLowerCase() == "selasa") {
								tmp_days.push(2);
							}else if (tmp_day.toLowerCase() == "rabu") {
								tmp_days.push(3);
							}else if (tmp_day.toLowerCase() == "kamis") {
								tmp_days.push(4);
							}else if (tmp_day.toLowerCase() == "jumat") {
								tmp_days.push(5);
							}else if (tmp_day.toLowerCase() == "sabtu") {
								tmp_days.push(6);
							}else if (tmp_day.toLowerCase() == "minggu") {
								tmp_days.push(0);
							}
							// $("#dokter").append("<option value='" + data.employee_id + "'>" + data.first_name+ " " +data.last_name + "</option>");
						});

						// console.log(tmp_days);
						var tmp_date_disable = [0,1,2,3,4,5,6];
						$.each(tmp_days, function (index, data) {
							for(var i in tmp_date_disable){
								if(tmp_date_disable[i]==data){
									tmp_date_disable.splice(i,1);
								}
							}
						});

						console.log(tmp_date_disable);
						$('#tgl_kunjungan').datepicker('setDaysOfWeekDisabled',tmp_date_disable);
						$('#tgl_kunjungan').datepicker('minDate', new Date());
					}
				}
			});
		}

		$('#dokter').selectmenu({
			select : function(evt, ui){
				parameter.employee_id = ui.item.value;
				get_jadwal(parameter.klinik, ui.item.value);
			},
			style: 'dropdown',
			width:'100%',
		});

		$('#tgl_lahir').datepicker({
			dateFormat 	: "dd-mm-yyyy",
		});

		/*$('#tgl_kunjungan').datepicker({
			dateFormat 	: "dd/mm/yyyy",
			minDate 	: '<?php //echo $tanggal_at; ?>',
			maxDate 	: '<?php //echo $tanggal_to; ?>',
			// daysOfWeekDisabled: "0,6",
			// daysOfWeekDisabled: [0,1,2,3,4,5,6],
			onSelect 	: function(dateText, inst) {
				document.getElementById('ket_tgl_checkin').innerHTML = dateText;
			}
		});*/

		$('#tgl_kunjungan').datepicker({
			dateFormat 	: "dd-mm-yy",
			startDate 	: new Date(),
			onSelect 	: function(dateText, inst) {
				document.getElementById('ket_tgl_checkin').innerHTML = dateText;
			}
		}).on('changeDate', function(evt){
			// console.log(evt);
			var dateTypeVar = $('#tgl_kunjungan').datepicker('getDate');
			dateTypeVar = $.datepicker.formatDate('DD', dateTypeVar);

			$.ajax({
				url 		: "<?php echo base_url()?>Daftar/get_jam",
				dataType 	: 'json',
				delay 		: 2000,
				type 		: "POST",
				data 		: {
					criteria: JSON.stringify({ unit_id : parameter.klinik, employee_id : parameter.employee_id, day : dateTypeVar }),
				},
				success: function(data) {
					if (data.status === true) {
					}
				}
			});
		});
        // $("#tgl_kunjungan").datepicker("setDate", '');

		$("#jenis_kunjungan").change(function(text, evt){
			parameter.jenis_penjamin  	= text.originalEvent.target.value;
			hide_btn_modal();
			document.getElementById('ModalTitle').innerHTML = "Informasi";
			if (text.originalEvent.target.value == "1") {
				document.getElementById('ModalBody').innerHTML = "Episode Baru adalah pasien yang belum cetak SEP dan akan memulai pemeriksaan baru.";
				$("#btn_no_rujukan").attr('disabled', false);
			}else{
				document.getElementById('ModalBody').innerHTML = "Episode Lanjutan adalah Pasien yang sudah cetak SEP dan belum selesai pemeriksaan di hari yang sama kemudian dilanjutkan di hari berikutnya tanpa cetak SEP.";
				$("#btn_no_rujukan").attr('disabled', true);
			}
			$("#exampleModal").modal('show');
		});

		$('#btn_search').click(function(){
			$("#btn_load_search").attr('class', 'fa fa-spinner fa-spin');
			$("#btn_search").attr("disabled", true);
			$("#btn_next").attr("disabled", true);

			$.ajax({
				url: "<?php echo base_url(); ?>"+"Daftar/search_patient",
				type: "POST",
				data: {
					kd_pasien : $("#kd_pasien").val(),
					tgl_lahir : $("#tgl_lahir").val(),
				},
				success: function (response) {
					var Obj = JSON.parse(response);
					$("#btn_load_search").attr('class', 'fa fa-search');
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
						status_.get_pasien = false;
					}else{
						$("#btn_next").attr("disabled", false);
						$("#nama").val(Obj.patient[0].name);
						$("#alamat").val(Obj.patient[0].address);
						status_.get_pasien = true;
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(textStatus, errorThrown);
				}
			});
		});


	</script>
</body>
</html>
