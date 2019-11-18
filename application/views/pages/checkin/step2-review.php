<style>
.footer {
	position: fixed;
	left: 0;
	bottom: 0;
	width: 100%;
	background-color: red;
	color: white;
	text-align: center;
}
</style>
<div class="container" align="center">
	<div id="_content-2">
		<div class="row">
			<div class="col-md-12">
				<h1 class="display-4">Data pribadi</h1>
				<hr>
				<font class="display-4" style="font-size: 32px;">
					<table width="80%" border="0">
						<tr>
							<td width="260">No Pendaftaran</td>
							<td>: <b><?php echo $data->row()->no_pendaftaran; ?></b></td>
						</tr>
						<tr>
							<td>Nama</td>
							<td>: <b><?php echo $data->row()->title.". ".$data->row()->name; ?></b></td>
						</tr>
						<tr>
							<td>Klinik</td>
							<td>: <b><?php echo $data->row()->unit_name; ?></b></td>
						</tr>
						<tr>
							<td>Dokter</td>
							<td>: <b><?php echo $data->row()->first_name; ?></b></td>
						</tr>
						<tr>
							<td>Pembayaran</td>
							<td>: <b><?php echo $data->row()->customer_name; ?></b></td>
						</tr>
					</table>
				</font>
				<hr>
				<button id="btn_check_in" class="btn btn-success btn-lg">Check in</button>
				<button id="btn_reload-2" class="btn btn-danger btn-lg">Batal</button>
			</div>
		</div>
	</div>
	<div id="_load-2" align="center" style="display: none;">
		<div class="row">
			<div class="col-md-12">
				<img src="<?php base_url(); ?>assets/image/basicloader.gif" width="450"><br>
				<button id="btn_back-2" class="btn btn-warning btn-lg">Kembali</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$("#btn_check_in").click(function(){
		document.getElementById("_content-2").style.display 	= "none";
		document.getElementById("_load-2").style.display 		= "";
		$.ajax({
			type: "POST", 
			url: "<?php echo base_url(); ?>"+"checkin/confirm_form",
			data: { no_pendaftaran : "<?php echo $data->row()->no_pendaftaran; ?>" }, 
			success: function(response) {
				$("#main").html(response);
			},
			error: function(xhr, ajaxOptions, thrownError) { 
				// alert(xhr.responseText); 
				document.getElementById("_load-2").style.display 		= "none";
				document.getElementById("_content-2").style.display 	= "";
			}
		});
	});

	$("#btn_reload-2, #btn_back-2").click(function(){
		location.reload();
	});

</script>