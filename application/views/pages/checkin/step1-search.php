<link href="<?php echo base_url()?>assets/Keyboard-master/css/keyboard.min.css" rel="stylesheet">
<div class="container" align="center">
	<div id ="div-input" style="padding-top: 1px;">
	<i><h3 class ="form-signin-heading"><center>QR Code Scanner</center></h3></i>
		<div id ="reader" style="width:300px;height:250px;margin:0 auto"></div>
		<div id ="read"></div>
	</div>
	<h4>Masukkan nomer pendaftaran</h4>
	<div class="row">
		<div class="col-md-12">
			<div class="form-inline">
				<input type="text" id="nomorPendaftaran" class="keyboard col-md-10 form-control" style="font-size:40px;" />
				<button id="btnSearch" type="button" style="float:left;margin-left: 10px;height: 70px;font-size:30px;" class="btn btn-success">
					<i class="fa fa-spinner fa-spin fa-fw" id="load_search" style="display: none;"></i>CARI
				</button>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url()?>assets/Keyboard-master/js/jquery.keyboard.min.js"></script>
<script type="text/javascript">
	$('#nomorPendaftaran').keyboard({
		layout: 'custom',
		customLayout : {
			'normal': [
				'1 2 3 4 5 6 7 8 9 0 {bksp}',
				'{accept}'
			]
		}
	});
	$("#btnSearch").click(function(){
		document.getElementById("load_search").style.display = '';
		document.getElementById("btnSearch").disabled = true;
		$.ajax({
			type: "POST", 
			url: "<?php echo base_url(); ?>"+"checkin/search_process",
			data: { no_pendaftaran : $('#nomorPendaftaran').val() }, 
			success: function(response) {
				$("#main").html(response);
			},
			error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); 
			}
		});
	});
</script>