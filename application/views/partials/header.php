
	<header>
		<div class="collapse bg-dark" id="navbarHeader">
			<div class="container">
				<div class="row">
				<div class="col-sm-8 col-md-7 py-4">
					<h4 class="text-white">About</h4>
					<p class="text-muted">Add some information about the album below, the author, or any other background context. Make it a few sentences long so folks can pick up some informative tidbits. Then, link them off to some social networking sites or contact information.</p>
				</div>
				<div class="col-sm-4 offset-md-1 py-4">
					<h4 class="text-white">Option</h4>
					<ul class="list-unstyled">
						<li><a href="<?php echo base_url(); ?>auth/login" class="text-white">Login</a></li>
						<li><a href="#" class="text-white">Like on Facebook</a></li>
						<li><a href="#" class="text-white">Email me</a></li>
					</ul>
				</div>
				</div>
			</div>
		</div>

		<div class="navbar navbar-dark bg-dark box-shadow">
			<div class="container d-flex justify-content-between">
				<a href="<?php echo base_url(); ?>" class="navbar-brand d-flex align-items-center">
					<i class="fa fa-book" aria-hidden="true"></i><strong>Pendaftaran <?php echo $data_rs['name'] ?></strong>
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
			</div>
		</div>
	</header>