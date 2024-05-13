<?php

/**
 * Plantilla general de controladores
 * Versión 1.0.2
 *
 * Controlador de lecciones
 */
class leccionesController extends Controller
{
  function __construct()
  {
    // Validación de sesión de usuario, descomentar si requerida 
    if (!Auth::validate()) {
      Flasher::new('Debes iniciar sesión primero.', 'danger');
      Redirect::to('login');
    }
  }

  function index()
  {
    $data =
      [
        'title' => 'Reemplazar título',
        'msg'   => 'Bienvenido al controlador de "lecciones", se ha creado con éxito si ves este mensaje.'
      ];

    // Descomentar vista si requerida
    View::render('index', $data);
  }

  function ver($id)
  {
    View::render('ver');
  }

  function agregar()
  {
    if (!is_profesor(get_user_role())) {
      Flasher::new(get_notificaciones(), 'danger');
      Redirect::to('dashboard');
    }

    $id_profesor = get_user('id');
    $data =
      [
        'title'             => 'Agregar nueva lección',
        'slug'              => 'grupos',
        'id_profesor'       => $id_profesor,
        'id_materia'        => isset($_GET["id_materia"]) ? $_GET["id_materia"] : null,
        'materias_profesor' => materiaModel::materias_profesor($id_profesor)

      ];

    View::render('agregar', $data);
  }

  function post_agregar()
  {
    try {
      if (!check_posted_data(['csrf', 'titulo', 'video', 'contenido', 'id_materia', 'id_profesor', 'fecha_max', 'status'], $_POST) || !Csrf::validate($_POST['csrf'])) {
        throw new Exception(get_notificaciones());
      }

      // Validar rol
      if (!is_profesor(get_user_role())) {
        throw new Exception(get_notificaciones(1));
      }

      $titulo      = clean($_POST['titulo']);
      $video       = clean($_POST['video']);
      $contenido   = clean($_POST['contenido'], true);
      $id_profesor = clean($_POST['id_profesor']);
      $id_materia  = clean($_POST['id_materia']);
      $fecha_max   = clean($_POST['fecha_max']);
      $status      = clean($_POST['status']);

      // Validar que el profesor exista
      if (!$profesor = profesorModel::by_id($id_profesor)) {
        throw new Exception('El profesor de la lección no existe en la base de datos.');
      }

      // Validar la materia
      if (!$materia = materiaModel::by_id($id_materia)) {
        throw new Exception('La materia no existe en la base de datos.');
      }

      $sql = 'SELECT mp.* FROM materias_profesores mp WHERE mp.id_materia = :id_materia AND mp.id_profesor = :id_profesor';
      if (!profesorModel::query($sql, ['id_materia' => $id_materia, 'id_profesor' => $id_profesor])) {
        throw new Exception(sprintf('El profesor no tiene asignada la materia <b>%s</b>.', $materia['nombre']));
      }

      // Validar el titulo del usuario
      if (strlen($titulo) < 5) {
        throw new Exception('Ingresa un título mayor a 5 caracteres.');
      }

      // Validar que el url del video
      if (!filter_var($video, FILTER_VALIDATE_URL) && !empty($video)) {
        throw new Exception('Ingresa una URL de video válida.');
      }

      // Lección a guardar
      $data = 
      [
        'id_materia'       => $id_materia,
        'id_profesor'      => $id_profesor,
        'titulo'           => $titulo,
        'video'            => $video,
        'contenido'        => $contenido,
        'status'           => $status,
        'fecha_disponible' => $fecha_max,
        'creado'           => now()
      ];

      // Insertar a la base de datos
      if (!$id = leccionModel::add(leccionModel::$t1, $data)) {
        throw new Exception(get_notificaciones(2));
      }

      Flasher::new(sprintf('Nueva lección titulada <b>%s</b> agregada con éxito para la materia <b>%s</b>.', add_ellipsis($titulo, 20), $materia['nombre']), 'success');
      Redirect::to(sprintf('grupos/materia/%s', $id_materia));

    } catch (PDOException $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::back();
    } catch (Exception $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::back();
    }
  }

  function editar($id)
  {
    if (!is_profesor(get_user_role())) {
      Flasher::new(get_notificaciones(), 'danger');
      Redirect::to('dashboard');
    }

    //validar que exista la lección
    if(!$leccion = leccionModel::by_id($id)){
      Flasher::new('No existe la lección seleccionada.', 'danger');
      Redirect::back();
    }

    $id_profesor = get_user('id');

    //validar el id del profesor y del registro
    if($leccion['id_profesor']!== $id_profesor && !is_admin(get_user_role())){
      Flasher::new(get_notificaciones(), 'danger');
      Redirect::back();
    }

    $data =
      [
        'title'             => 'Editar lección',
        'slug'              => 'grupos',
        'id_profesor'       => $id_profesor,
        'l'                 => $leccion,
        'button'            => ['url' => sprintf('grupos/materia/%s', $leccion['id_materia']), 'text' => '<i class="fas fa-undo"></i> Lecciones'],
      ];

    View::render('editar', $data);
  }


  function post_editar()
  {
    try {
      if (!check_posted_data(['csrf', 'id', 'titulo', 'video', 'contenido', 'fecha_max', 'status'], $_POST) || !Csrf::validate($_POST['csrf'])) {
        throw new Exception(get_notificaciones());
      }

      // Validar rol
      if (!is_profesor(get_user_role())) {
        throw new Exception(get_notificaciones(1));
      }

      //validar que exista la lección
      $id =clean($_POST["id"]);

      if (!$leccion =leccionModel::by_id($id)){
        throw new Exception('No existe la lección seleccionada.');
      }

      $id_profesor = get_user('id');

      //validar el id del profesor y del registro
      if($leccion['id_profesor']!== $id_profesor && !is_admin(get_user_role())){
        throw new Exception(get_notificaciones());
      }

      $titulo      = clean($_POST['titulo']);
      $video       = clean($_POST['video']);
      $contenido   = clean($_POST['contenido'], true);
      $fecha_max   = clean($_POST['fecha_max']);
      $status      = clean($_POST['status']);

      // Validar el titulo del usuario
      if (strlen($titulo) < 5) {
        throw new Exception('Ingresa un título mayor a 5 caracteres.');
      }

      // Validar que el url del video
      if (!filter_var($video, FILTER_VALIDATE_URL) && !empty($video)) {
        throw new Exception('Ingresa una URL de video válida.');
      }

      // Lección a guardar
      $data = 
      [
        'titulo'           => $titulo,
        'video'            => $video,
        'contenido'        => $contenido,
        'status'           => $status,
        'fecha_disponible' => $fecha_max,
      ];

      // Actualizar registros a la base de datos
      if (!leccionModel::update(leccionModel::$t1, ['id' => $id], $data)) {
        throw new Exception(get_notificaciones(3));
      }

      Flasher::new(sprintf('Lección titulada <b>%s</b> actualizada con éxito.', add_ellipsis($titulo, 50)), 'success');
      Redirect::to(sprintf('grupos/materia/%s', $leccion['id_materia']));

    } catch (PDOException $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::back();
    } catch (Exception $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::back();
    }
  }

  function borrar($id)
  {
    // Proceso de borrado
  }
}
