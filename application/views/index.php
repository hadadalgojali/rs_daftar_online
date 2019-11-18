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
										<b>SYARAT DAN KETENTUAN</b> PENDAFTARAN ONLINE :
									</div>
									<div class="card-body">
										<!-- <p class="card-text"> -->
											<ol>
												<li>Pendaftaran online dapat dilakukan saat hari kunjung maksimal jam 13:30 dan 1 (satu) hari sebelum kunjungan.</li>
												<li>Pembayaran biaya pendaftaran untuk pasien umum dilakukan di loket kasir yang berlokasi di Rumah Sakit.</li>
												<li>Untuk pasien BPJS harus ada surat rujukan ke RS Soedono Madiun yang masih berlaku.</li>
												<li>Untuk pasien BPJS, nama poli tujuan kunjungan harus sama dengan nama poli pada surat rujukan.</li>
												<li>Untuk Pasien Hemodialisa silahkan datang langsung ke Loket Pendaftaran.</li>
												<li>Check in dapat dilakukan saat hari kunjungan pada jam 06:30 s/d 14:00.</li>
											</ol>	
										<!-- </p> -->
									</div>
								</div>
							</div>
							<div class="col-md-12 py-2">
								<div class="card">
									<div class="card-header">
										<b>PENDAFTARAN</b> PASIEN BARU :
									</div>
									<div class="card-body">
										Untuk pasien yang <u>belum memiliki nomer rekam medis</u> di <b><?php echo strtoupper($data_rs['name']); ?></b>.<br>
										<a href="javascript:;" class="btn btn-primary btn-sm">Lanjut daftar pasien baru</a>
									</div>
								</div>
							</div>
							<div class="col-md-12 py-2">
								<div class="card">
									<div class="card-header">
										<b>PENDAFTARAN</b> PASIEN LAMA :
									</div>
									<div class="card-body">
										Untuk pasien yang <u>sudah memiliki nomer rekam medis</u> di <b><?php echo strtoupper($data_rs['name']); ?></b>.<br>
										<a href="<?php echo base_url(); ?>daftar/lama" class="btn btn-primary btn-sm">Lanjut daftar pasien lama</a>
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
</body>
</html>