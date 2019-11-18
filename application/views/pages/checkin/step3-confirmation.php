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
	<div id="_content-3">
		<div class="row" style="margin-top: 25px;">
			<div class="col-md-12">
				<h1 class="display-4">Konfirmasi, apakah data sudah benar ? </h1>
				<hr>
				<button id="btn_check_in-3" class="btn btn-success btn-lg">Check in</button>
				<button id="btn_reload-3" class="btn btn-danger btn-lg">Batal</button>
			</div>
		</div>
	</div>

	<div id="_load-3" align="center" style="display: none;">
		<div class="row">
			<div class="col-md-12">
				<img src="<?php base_url(); ?>assets/image/basicloader.gif" width="450"><br>
				<button id="btn_back-3" class="btn btn-warning btn-lg">Kembali</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$("#btn_check_in-3").click(function(){
		$.ajax({
			type: "POST", 
			url: "<?php echo base_url(); ?>"+"checkin/confirm",
			data: { no_pendaftaran : "<?php echo $no_pendaftaran; ?>" }, 
			success: function(response) {
				$("#main").html(response);
			},
			error: function(xhr, ajaxOptions, thrownError) { 
			}
		});
	});

	$("#btn_reload-3, #btn_back-3").click(function(){
		location.reload();
	});
</script>