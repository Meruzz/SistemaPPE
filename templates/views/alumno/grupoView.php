<?php require_once INCLUDES . 'inc_header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Card de Grupos -->
        <div class="col-xl-4 col-md-6 col-12">
            <!-- Collapsable Card Example -->
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#grupo_data" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="grupo_data">
                    <h6 class="m-0 font-weight-bold text-primary">Mis grupos</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="grupo_data">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label" nombre">Nombre:</label>
                            <strong class="d-block"><?php echo $d->g->nombre; ?></strong>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="descripcion">Descripción:</label>
                            <strong class="d-block"><?php echo $d->g->descripcion; ?></strong><br>

                            <label for="descripcion">Horario de actividades:</label>
                            <?php if ($d->g->horario != null) : ?>
                                <?php if (is_file(UPLOADS . $d->g->horario)) : ?>
                                    <a href="<?php echo UPLOADED . $d->g->horario; ?>" data-lightbox="Horario" title="<?php echo sprintf('Horario del grupo %s', $d->g->nombre); ?>">
                                        <img src="<?php echo UPLOADED . $d->g->horario; ?>" alt="<?php echo sprintf('Horario del grupo %s', $d->g->nombre); ?>" class="img-fluid img-thumbnail">
                                    </a>
                                <?php else : ?>
                                    <p class="text-muted"><?php echo sprintf('El archivo <b>%s</b> no existe o está dañado.', $d->g->horario); ?></p>
                                <?php endif; ?>
                            <?php else : ?>
                                <p>No hay un horario definido aún para este grupo.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card de Alumnos -->
        <div class="col-xl-4 col-md-6 col-12">
            <!-- Collapsable Card Example -->
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#grupo_alumnos" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="grupo_alumnos">
                    <h6 class="m-0 font-weight-bold text-primary">Compañeros del grupo</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="grupo_alumnos">
                    <div class="card-body">
                        <?php if (!empty($d->g->alumnos)) : ?>
                            <ul class="list-group">
                                <?php foreach ($d->g->alumnos as $a) : ?>
                                    <?php if ($a->id == get_user('id')) : ?>
                                        <li class="list-group-item">
                                            <b><?php echo sprintf('%s (Tú)', $a->nombre_completo); ?></b>
                                        </li>
                                    <?php else : ?>
                                        <li class="list-group-item">
                                            <b><?php echo $a->nombre_completo; ?></b>
                                            <div class="btn-group float-right">
                                                <a class="btn btn-warning btn-sm " href="<?php echo sprintf('mailto:%s?subject=[%s] - Mensaje de %s para %s', $a->email, get_sitename(), get_user('nombre_completo'), $a->nombre_completo); ?>"><i class="fas fa-envelope"></i></a>
                                            </div>
                                        </li>
                                    <?php endif; ?>

                                <?php endforeach; ?>
                            </ul>
                        <?php else : ?>
                            <div class="text-center py-5">
                                <img src="<?php echo get_image('undraw_no_data.svg'); ?>" alt="No hay registros." class="img-fluid" style="width: 200px">
                                <p class="text-muted">No hay alumnos en este grupo.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card de materias-profesores -->
        <div class="col-xl-4 col-md-6 col-12">
            <!-- Collapsable Card Example -->
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#grupo_materias" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="grupo_materias">
                    <h6 class="m-0 font-weight-bold text-primary">Mis materias y profesores</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="grupo_materias">
                    <div class="card-body">
                        <?php if (!empty($d->g->materias)) : ?>
                            <ul class="list-group">
                                <?php foreach ($d->g->materias as $m) : ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><?php echo sprintf('<b>%s</b> por <b>%s</b>', $m->materia, $m->profesor); ?></span>

                                        <div class="btn-group">
                                            <a class="btn btn-info btn-sm" href="<?php echo buildURL('alumno/lecciones/',['id_materia'=> $m->id_materia, 'id_profesor'=>$m->id_profesor], false, false ); ?>"><i class="fas fa-eye"></i></a>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else : ?>
                            <div class="text-center py-5">
                                <img src="<?php echo get_image('undraw_no_data.svg'); ?>" alt="No hay registros." class="img-fluid" style="width: 200px;">
                                <p class="text-muted">No hay materias asignadas.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

<?php require_once INCLUDES . 'inc_footer.php'; ?>