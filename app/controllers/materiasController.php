<?php

/**
 * Plantilla general de controladores
 * Versión 1.0.2
 *
 * Controlador de materias
 */
class materiasController extends Controller
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
        'title' => 'Todas las Materias',
        'slug' => 'materias',
        'button' => ['url' => 'materias/agregar', 'text'=>'<i class="fas fa-plus"></i> Agregar materia'],
        'materias' => materiaModel::all()
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

    $data =
      [
        'title' => 'Agregar Materia',
        'slug' => 'materias'

      ];

    View::render('agregar', $data);
  }

  function post_agregar()
  {
    try {
      if (!check_posted_data(['csrf', 'nombre', 'descripcion'], $_POST) || !Csrf::validate($_POST['csrf'])) {
        throw new Exception('Acceso no autorizado');
      }

      $nombre = clean($_POST["nombre"]);
      $descripcion = clean($_POST["descripcion"]);

      //validaciones de nombre
      if (empty($nombre)) {
        throw new Exception('El campo nombre es requerido.');
      }

      if (!preg_match('/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑüÜ]+$/', $nombre)) {
        throw new Exception('El nombre solo puede contener letras, números y espacios.');
    }    

      if (strlen($nombre) < 4 || strlen($nombre) > 50) {
        throw new Exception('El nombre debe tener entre 3 y 50 caracteres.');
      }

      //validaciones de la descripción
      if (!empty($descripcion) && strlen($descripcion) > 5000) {
        throw new Exception('La descripción no puede exceder los 5000 caracteres.');
      }

      $data =
        [
          'nombre' => $nombre,
          'descripcion' => $descripcion,
          'creado' => now()

        ];

      if (!$id = materiaModel::add(materiaModel::$t1, $data)) {
        throw new Exception('No se pudo agregar la materia.');
      }
      Flasher::new(sprintf('Materia <b>%s</b> agregada con éxito.', $nombre), 'success');
      Redirect::back();
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
    View::render('editar');
  }

  function post_editar()
  {
  }

  function borrar($id)
  {
    // Proceso de borrado
  }
}
