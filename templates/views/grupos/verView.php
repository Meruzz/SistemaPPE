<?php require_once INCLUDES . 'inc_header.php'; ?>

<div class="row">
    <div class="col-xl-4 col-md-6 col-12">
        <!-- Collapsable Card Example -->
        <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#grupo_data" class="d-block card-header py-3" data-toggle="collapse"
             role="button" aria-expanded="true" aria-controls="grupo_data">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo sprintf('Grupo #%s', $d->g->numero); ?></h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="grupo_data">
                <div class="card-body">

                    <form action="grupos/post_editar" method="post">

                        <?php echo insert_inputs(); ?>
                        <input type="hidden" name="id" value="<?php echo $d->g->id; ?>" required>

                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre"  value="<?php echo $d->g->nombre;?>"  required>
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea name="descripcion" id="descripcion" cols="10" rows="5" class="form-control"><?php echo $d->g->descripcion;?></textarea>
                        </div>

                        <button class="btn btn-success" type="submit">Guardar cambios</button>

                    </form>

                </div>
            </div>
        </div>
    </div>

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
                                <option value="">Una impartida por Alex</option>
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