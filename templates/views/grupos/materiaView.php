<?php require_once INCLUDES . 'inc_header.php'; ?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <?php echo $d->title; ?>
            <div class="btn-group float-right">
                <a class="btn btn-primary btn-sm" href="<?php echo buildURL('lecciones/agregar/', ['id_materia' => $d->materia->id], false, false); ?>"><i class="fas fa-plus"></i> Agregar lección</a>
            </div>
        </h6>
    </div>
    <div class="card-body">
        <?php if (!empty($d->lecciones->rows)) : ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th> <!-- Para icono -->
                            <th>Título de la lección</th>
                            <th>Video</th>
                            <th>Estado</th>
                            <th>Fecha máxima</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($d->lecciones->rows as $l) : ?>
                            <tr>
                                <td>
                                    <a href="<?php echo sprintf('lecciones/ver/%s', $l->id); ?>">
                                        <img src="<?php echo get_image('play.png'); ?>" alt="<?php echo $l->titulo; ?>" class="img-fluid" style="width: 40px;">
                                    </a>
                                </td>
                                <td><?php echo $l->titulo; ?></td>
                                <td>
                                    <?php if (!empty($l->video)) : ?>
                                        <span class="badge badge-success"><i class="fas fa-video"></i> Tiene video</span>
                                    <?php else : ?>
                                        <span class="badge badge-danger"><i class="fas fa-video"></i> Sin video</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $l->status; ?></td>
                                <td><?php echo format_date($l->fecha_disponible); ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-primary btn-sm" href="<?php echo sprintf('lecciones/editar/%s', $l->id); ?>"><i class="fas fa-edit"></i></a>
                                        <a class="btn btn-success btn-sm" href="<?php echo sprintf('lecciones/ver/%s', $l->id); ?>"><i class="fas fa-eye"></i></a>
                                        <a class="btn btn-danger btn-sm confirmar" href="<?php echo buildURL(sprintf('lecciones/borrar/%s', $l->id)); ?>"><i class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
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