<?php require_once INCLUDES . 'inc_header.php'; ?>

<div class="row">
    <!-- Card de Grupos -->
    <div class="col-xl-4 col-md-6 col-12">
        <!-- Collapsable Card Example -->
        <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#grupo_data" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="grupo_data">
                <h6 class="m-0 font-weight-bold text-primary">Información general</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="grupo_data">
                <div class="card-body">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control disabled" id="nombre" name="nombre" value="<?php echo $d->g->nombre; ?>" disabled>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea name="descripcion" id="descripcion" cols="10" rows="5" class="form-control disabled" disabled><?php echo $d->g->descripcion; ?></textarea>
                        <div class="form-group">
                            <label for="descripcion">Horario de actividades</label>
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
    </div>

    <!-- Card de Alumnos -->
    <div class="col-xl-4 col-md-6 col-12">
        <!-- Collapsable Card Example -->
        <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#grupo_alumnos" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="grupo_alumnos">
                <h6 class="m-0 font-weight-bold text-primary">Alumnos del grupo</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="grupo_alumnos">
                <div class="card-body">
                    <?php if (!empty($d->g->alumnos)) : ?>
                        <ul class="list-group">
                            <?php foreach ($d->g->alumnos as $a) : ?>
                                <li class="list-group-item">
                                    <div class="btn-group float-right">
                                        <a class="btn btn-success btn-sm " href="<?php echo sprintf('mailto:%s?subject=[%s] - Mensaje de %s para %s', $a->email, get_sitename(), get_user('nombre_completo'), $a->nombre_completo); ?>"><i class="fas fa-envelope"></i></a>
                                    </div>

                                    <b><?php echo $a->nombre_completo; ?></b>
                                    <br><?php echo format_estado_usuario($a->status); ?>
                                </li>
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
                <h6 class="m-0 font-weight-bold text-primary">Materias y Profesores</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="grupo_materias">
                <div class="card-body">

                    <form id="grupo_asignar_materia_form" method="post">

                        <?php echo insert_inputs(); ?>
                        <input type="hidden" name="id_grupo" value="<?php echo $d->g->id; ?>" required>

                        <div class="form-group">
                            <label for="id_mp">Selecciona una opción disponible:</label>
                            <select name="id_mp" id="id_mp" class="form-select" require>

                            </select>
                        </div>

                        <button class="btn btn-success" type="submit">Agregar</button>

                    </form>
                    <hr>
                    <div class="wrapper_materias_grupo" data-id="<?php echo $d->g->id; ?>"><!-- Agregar con ajax a la lista de materias --></div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php require_once INCLUDES . 'inc_footer.php'; ?>