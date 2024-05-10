<?php

/**
 * Plantilla general de controladores
 * Versión 1.0.2
 *
 * Controlador de alumnos
 */
class alumnosController extends Controller
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
    if (!is_admin(get_user_role())) {
      Flasher::new(get_notificaciones(), 'danger');
      Redirect::back();
    }

    $data =
      [
        'title'   => 'Todas los Alumnos',
        'slug'    => 'alumnos',
        'button'  => ['url' => 'alumnos/agregar', 'text' => '<i class="fas fa-plus"></i> Agregar alumno'],
        'alumnos' => alumnoModel::all_paginated()
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
        'title'   => 'Agregar alumno',
        'slug'    => 'alumnos',
        'button'  => ['url' => 'alumnos', 'text' => '<i class="fas fa-table"></i> Alumnos'],
        'grupos' => grupoModel::all()
      ];

    View::render('agregar', $data);
  }

  function post_agregar()
  {

    try {
      if (!check_posted_data(['csrf', 'nombres', 'apellidos', 'email', 'telefono', 'password', 'conf_password', 'id_grupo'], $_POST) || !Csrf::validate($_POST['csrf'])) {
        throw new Exception(get_notificaciones(0));
      }

      //Validar rol
      if (!is_admin(get_user_role())) {
        throw new Exception(get_notificaciones(1));
      }

      $nombres        = clean($_POST["nombres"]);
      $apellidos      = clean($_POST["apellidos"]);
      $email          = clean($_POST["email"]);
      $telefono       = clean($_POST["telefono"]);
      $password       = clean($_POST["password"]);
      $conf_password  = clean($_POST["conf_password"]);
      $id_grupo       = clean($_POST["id_grupo"]);


      // Validar que el correo sea válido
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Ingresa un correo electrónico válido.');
      }

      // Verificar si el correo electrónico ya existe
/*       if (alumnoModel::emailExists($email)) {
        throw new Exception('Este correo electrónico ya está registrado. Por favor, usa otro.');
      } */

      //validaciones de nombre
      if (empty($nombres)) {
        throw new Exception('El campo nombre es requerido.');
      }

      if (!preg_match('/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑüÜ]+$/', $nombres)) {
        throw new Exception('El nombre solo puede contener letras, números y espacios.');
      }

      if (strlen($nombres) < 4 || strlen($nombres) > 50) {
        throw new Exception('El nombre debe tener entre 4 y 50 caracteres.');
      }

      //Validación de Apellidos

      if (empty($apellidos)) {
        throw new Exception('El campo apellidos es requerido.');
      }

      if (!preg_match('/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑüÜ]+$/', $apellidos)) {
        throw new Exception('El apellidos solo puede contener letras, números y espacios.');
      }

      if (strlen($apellidos) < 4 || strlen($apellidos) > 50) {
        throw new Exception('El apellidos debe tener entre 3 y 50 caracteres.');
      }

      //Validación de teléfono
      if (empty($telefono)) {
        throw new Exception('El campo teléfono es requerido.');
      }

      if (!preg_match('/^\+?[0-9\s\-()]+$/', $telefono)) {
        throw new Exception('El teléfono solo puede contener números, espacios, y caracteres de (+,-,(),).');
      }

      if (strlen($telefono) < 7 || strlen($telefono) > 20) {
        throw new Exception('El teléfono debe tener entre 7 y 20 caracteres.');
      }

      //Validación de contraseña
      if (strlen($password) < 8) {
        throw new Exception('La contraseña debe tener al menos 8 caracteres.');
      }

/*       if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        throw new Exception('La contraseña debe contener al menos una letra y un número.');
      } */

      if ($password !== $conf_password) {
        throw new Exception('Las contraseñas no coinciden.');
      }

      // Validar que el id_grupo exista

      if ($id_grupo === '' || !grupoModel::by_id($id_grupo)) {
        throw new Exception('Selecciona un grupo valido.');
      }

      $data = [
        'numero'          => rand(111111, 999999),
        'nombres'         => $nombres,
        'apellidos'       => $apellidos,
        'nombre_completo' => sprintf('%s %s', $nombres, $apellidos),
        'email'           => $email,
        'telefono'        => $telefono,
        'password'        => password_hash($password . AUTH_SALT, PASSWORD_BCRYPT),
        'hash'            => generate_token(),
        'rol'             => 'alumno',
        'status'          => 'pendiente',
        'creado'          => now()
      ];

      $data2 = [
        'id_alumno' => null,
        'id_grupo'  => $id_grupo
      ];

      //Insertar a la base de datos
      if (!$id = alumnoModel::add(alumnoModel::$t1, $data)) {
        throw new Exception(get_notificaciones(2));
      }

      $data2['id_alumno'] = $id;

      //Insertar a la base de datos
      if (!$id_ga = grupoModel::add(grupoModel::$t3, $data2)) {
        throw new Exception(get_notificaciones(2));
      }

      //Email de confirmación de correo
      mail_confirmar_cuenta($id);

      $alumno = alumnoModel::by_id($id);
      $grupo = grupoModel::by_id($id_grupo);


      Flasher::new(sprintf('Alumno <b>%s</b> agregado con éxito y asignado al grupo. <b>%s</b>', $alumno['nombre_completo'], $grupo['nombre']), 'success');
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
