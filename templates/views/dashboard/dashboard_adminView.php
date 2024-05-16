<?php require_once INCLUDES . 'inc_header.php'; ?>

<!-- Content Row -->
<div class="row">

	<!-- Earnings Materias -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-primary shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Materias</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $d->stats->materias; ?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-book fa-2x text-gray-300"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Earnings Grupos -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-success shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Grupos</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $d->stats->grupos; ?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-user-friends fa-2x text-gray-300"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Earnings Alumnos -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-info shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Alumnos</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $d->stats->alumnos; ?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-user fa-2x text-gray-300"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Lecciones -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-warning shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Lecciones</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $d->stats->lecciones; ?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-layer-group fa-2x text-gray-300"></i>
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
	<div class="col-xl-12 col-lg-7">
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
				<?php foreach (get_proyectos() as $p) : ?>
					<h4 class="small font-weight-bold"><?php echo $p['titulo']; ?>
						<?php if ($p['progreso'] === 100) : ?>
							<span class="float-right">¡Completado!</span>
						<?php else : ?>
							<span class="float-right"><?php echo sprintf('%s%%', $p['progreso']); ?></span>
						<?php endif; ?>
					</h4>
					<div class="progress mb-4">
						<div class="progress-bar <?php echo $p['progreso'] === 100 ? 'bg-success' : sprintf('bg-%s', $p['tipo']); ?>" role="progressbar" style="<?php echo sprintf('width: %s%%', $p['progreso']); ?>" aria-valuenow="<?php echo $p['progreso']; ?>" aria-valuemin="0" aria-valuemax="100">
						</div>
					</div>
				<?php endforeach; ?>
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