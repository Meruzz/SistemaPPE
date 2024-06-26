<?php require_once INCLUDES . 'inc_header.php'; ?>

<!-- Content Row -->
<div class="row">

	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-primary shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Materias</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $d->stats->materias;?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-book fa-2x text-gray-300"></i>
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
						<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Grupos</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $d->stats->grupos;?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-user-friends fa-2x text-gray-300"></i>
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
						<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Alumnos</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $d->stats->alumnos;?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-user fa-2x text-gray-300"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

		<!-- Earnings (Monthly) Card Example -->
		<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-warning shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Lecciones</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $d->stats->alumnos;?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-layer-group fa-2x text-gray-300"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<style>
        html, body {
            height: 100%;
            margin: 0;
        }
        #content-wrapper {
            min-height: 62vh; /* Altura completa de la ventana de visualización */
            display: flex;
            flex-direction: column;
        }
        .footer {
            margin-top: auto; /* Empuja el footer al fondo si el contenido no es suficiente */
        }
    </style>

<?php require_once INCLUDES . 'inc_footer.php'; ?>