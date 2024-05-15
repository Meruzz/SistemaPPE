<?php require_once INCLUDES . 'inc_header.php'; ?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Lista de lecciones disponibles
        </h6>
    </div>
    <div class="card-body">
        <?php if (!empty($d->lecciones->rows)) : ?>
            <ul class="list-group">
                <!-- Encabezados de columnas -->
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-1"></div> <!-- Para icono, si es necesario, o remover si no se usa -->
                        <div class="col-3">Materia</div>
                        <div class="col-2">Profesor</div>
                        <div class="col-2">Titulo de la lección</div>
                        <div class="col-2">Disponible el:</div>
                        <div class="col-2 text-right">Tienes hasta el:</div>
                    </div>
                </li>
                <!-- Detalles de cada lección -->
                <?php foreach ($d->lecciones->rows as $l) : ?>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-1">
                                <a href="<?php echo sprintf('alumno/leccion/%s', $l->id); ?>">
                                    <img src="<?php echo get_image('play.png'); ?>" alt="<?php echo $l->titulo; ?>" class="img-fluid" style="width: 40px;">
                                </a>
                            </div>
                            <div class="col-3">
                                <span class="text-dark"><strong><?php echo add_ellipsis($l->materia, 50); ?></strong></span>
                            </div>
                            <div class="col-2">
                                <span class="text-dark"><?php echo add_ellipsis($l->profesor, 50); ?></span>
                            </div>
                            <div class="col-2">
                                <span class="text-dark"><?php echo add_ellipsis($l->titulo, 50); ?></span>
                            </div>
                            <div class="col-2">
                                <span class="text-dark"><?php echo format_date($l->fecha_inicial); ?></span>
                                <span class="badge badge-<?php echo (strtotime($l->fecha_inicial) - time()) < 0 ? 'success' : 'danger'; ?>">
                                    <?php echo (strtotime($l->fecha_inicial) - time()) < 0 ? 'Ya disponible.' : 'No disponible aún.'; ?>
                                </span>
                            </div>
                            <div class="col-2">
                                <span class="text-dark"><?php echo format_date($l->fecha_disponible); ?></span>
                                <span class="badge badge-<?php echo (strtotime($l->fecha_disponible) - time()) < 0 ? 'danger' : 'light'; ?>">
                                    <?php echo (strtotime($l->fecha_disponible) - time()) < 0 ? 'Ya no esta disponible.' : format_tiempo_restante($l->fecha_disponible); ?>
                                </span>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>


            <?php echo $d->lecciones->pagination; ?>
        <?php else : ?>
            <div class="py-5 text-center">
                <img src="<?php echo IMAGES . 'undraw_professor.svg'; ?>" alt="No hay registros" style="width: 150px;">
                <p class="text-muted mt-3">No hay lecciones disponibles.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once INCLUDES . 'inc_footer.php'; ?>