<?php require_once INCLUDES . 'inc_header.php'; ?>

<!-- Content Row -->
<div class="row">

	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-primary shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
							Earnings (Monthly)</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
					</div>
					<div class="col-auto">
						<i class="fas fa-calendar fa-2x text-gray-300"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-success shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-success text-uppercase mb-1">
							Earnings (Annual)</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
					</div>
					<div class="col-auto">
						<i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-info shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks
						</div>
						<div class="row no-gutters align-items-center">
							<div class="col-auto">
								<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
							</div>
							<div class="col">
								<div class="progress progress-sm mr-2">
									<div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-auto">
						<i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Pending Requests Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-warning shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
							Pending Requests</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
					</div>
					<div class="col-auto">
						<i class="fas fa-comments fa-2x text-gray-300"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Content Row -->

<div class="row">

	<!-- Ingresos -->
	<div class="col-xl-8 col-lg-7">
		<div class="card shadow mb-4">
			<!-- Card Header - Dropdown -->
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Resumen de Ingresos</h6>
				<div class="dropdown no-arrow">
					<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
						<div class="dropdown-header">Acciones</div>
						<a class="dropdown-item recargar_resumen_ingresos_chart" href="#"><i class="fas fa-sync fa-fw"></i>Recargar</a>
					</div>
				</div>
			</div>
			<!-- Card Body -->
			<div class="card-body">
				<div class="chart-area">
					<canvas id="resumen_ingresos_chart"></canvas>
				</div>
			</div>
		</div>
	</div>

	<!-- Comunidad -->
	<div class="col-xl-4 col-lg-5">
		<div class="card shadow mb-4">
			<!-- Card Header - Dropdown -->
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Comunidad</h6>
			</div>
			<!-- Card Body -->
			<div class="card-body">
				<div class="chart-pie pt-4 pb-2">
					<canvas id="resumen_comunidad_chart"></canvas>
				</div>
			</div>
		</div>
	</div>

	<!-- Lecciones registradas por mes en un año -->
	<div class="col-xl-8 col-lg-7">
		<div class="card shadow mb-4">
			<!-- Card Header - Dropdown -->
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Resumen de Enseñanza</h6>
				<div class="dropdown no-arrow">
					<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
						<div class="dropdown-header">Acciones</div>
						<a class="dropdown-item recargar_resumen_enseñanza_chart" href="#"><i class="fas fa-sync fa-fw"></i>Recargar</a>
					</div>
				</div>
			</div>
			<!-- Card Body -->
			<div class="card-body">
				<div class="chart-area">
					<canvas id="resumen_enseñanza_chart"></canvas>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Content Row -->
<div class="row">

	<!-- Content Column -->
	<div class="col-lg-6 mb-4">

		<!-- Proyectos -->
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary">Proyectos</h6>
			</div>
			<div class="card-body">
				<h4 class="small font-weight-bold">Server Migration <span class="float-right">20%</span></h4>
				<div class="progress mb-4">
					<div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<h4 class="small font-weight-bold">Sales Tracking <span class="float-right">40%</span></h4>
				<div class="progress mb-4">
					<div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<h4 class="small font-weight-bold">Customer Database <span class="float-right">60%</span></h4>
				<div class="progress mb-4">
					<div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<h4 class="small font-weight-bold">Payout Details <span class="float-right">80%</span></h4>
				<div class="progress mb-4">
					<div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<h4 class="small font-weight-bold">Account Setup <span class="float-right">Complete!</span></h4>
				<div class="progress">
					<div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-6 mb-4">

		<!-- Anuncios Educativos -->
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary">Anuncio Educativo</h6>
			</div>
			<div class="card-body">
				<div class="text-center">
					<img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="img/undraw_posting_photo.svg" alt="...">
				</div>
				<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Accusantium repellat, veritatis accusamus voluptate quos cum repellendus quis ipsam velit odio sit. Officiis officia iusto modi magni voluptatum odio repellat praesentium tempore, sed eveniet provident. Repellendus temporibus eum voluptates repellat illo dolores, ipsum libero quas numquam iure, vel inventore minus, magni laudantium distinctio fugiat doloremque! Et debitis inventore distinctio similique corrupti quibusdam enim omnis eius iste voluptatem, sint reprehenderit sequi voluptas exercitationem? Vel rerum eligendi, quas aliquid at laborum beatae eum voluptatum atque veritatis placeat quod. Iste ea obcaecati adipisci nemo assumenda mollitia cumque provident natus. Nisi dicta ratione fuga nihil.</p>
				</p>
				<a target="_blank" rel="nofollow" href="https://undraw.co/">Browse Illustrations on
					unDraw &rarr;</a>
			</div>
		</div>
	</div>
</div>

<?php require_once INCLUDES . 'inc_footer.php'; ?>