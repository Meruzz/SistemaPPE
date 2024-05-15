<?php require_once INCLUDES . 'inc_header.php'; ?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Lista de lecciones disponibles</h6>
    </div>
    <div class="card-body">
        <?php if (!empty($d->lecciones->rows)) : ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%"></th> <!-- Para icono -->
                            <th>Materia</th>
                            <th>Profesor</th>
                            <th>Título de la lección</th>
                            <th>Disponible el:</th>
                            <th>Tienes hasta el:</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($d->lecciones->rows as $l) : ?>
                            <tr>
                                <td>
                                    <a href="<?php echo sprintf('alumno/leccion/%s', $l->id); ?>">
                                        <img src="<?php echo get_image('play.png'); ?>" alt="Play" class="img-fluid" style="width: 24px; height: 24px;"> <!-- Asegúrate de que las dimensiones están especificadas -->
                                    </a>
                                </td>
                                <td><strong><?php echo $l->materia; ?></strong></td>
                                <td><?php echo $l->profesor; ?></td>
                                <td><?php echo $l->titulo; ?></td>
                                <td>
                                    <span class="text-dark"><?php echo format_date($l->fecha_inicial); ?></span><br>
                                    <span class="badge badge-<?php echo (strtotime($l->fecha_inicial) - time()) < 0 ? 'success' : 'danger'; ?>">
                                        <?php echo (strtotime($l->fecha_inicial) - time()) < 0 ? 'Ya disponible.' : 'No disponible aún.'; ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-dark"><?php echo format_date($l->fecha_disponible); ?></span><br>
                                    <span class="badge badge-<?php echo (strtotime($l->fecha_disponible) - time()) < 0 ? 'danger' : 'info'; ?>">
                                        <?php echo (strtotime($l->fecha_disponible) - time()) < 0 ? 'Ya no esta disponible.' : format_tiempo_restante($l->fecha_disponible); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php echo $d->lecciones->pagination; ?>
            </div>
        <?php else : ?>
            <div class="py-5 text-center">
                <img src="<?php echo IMAGES . 'undraw_professor.svg'; ?>" alt="No hay registros" style="width: 150px;">
                <p class="text-muted">No hay lecciones disponibles.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once INCLUDES . 'inc_footer.php'; ?>