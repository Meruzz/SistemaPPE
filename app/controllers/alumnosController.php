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
    if (!$alumno = alumnoModel::by_id($id)) {
      Flasher::new('No existe alumno en la base de datos.', 'danger');
      Redirect::back();
    }

    $data = [
      'title'        => sprintf('Alumno #%s', $alumno['numero']),
      'slug'         => 'alumnos',
      'button'       => ['url' => 'alumnos', 'text' => '<i class="fas fa-table"></i> Alumnos'],
      'grupos'       => grupoModel::all(),
      'a'            => $alumno
    ];

    View::render('ver', $data);
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
      if (alumnoModel::emailExists($email)) {
        throw new Exception('Este correo electrónico ya está registrado. Por favor, usa otro.');
      }

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

      if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        throw new Exception('La contraseña debe contener al menos una letra y un número.');
      }

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
    try {
      if (!check_posted_data(['csrf', 'id', 'nombres', 'apellidos', 'email', 'telefono', 'password', 'conf_password', 'id_grupo'], $_POST) || !Csrf::validate($_POST['csrf'])) {
        throw new Exception(get_notificaciones(0));
      }

      //Validar rol
      if (!is_admin(get_user_role())) {
        throw new Exception(get_notificaciones(1));
      }

      $id = clean($_POST["id"]);
      if (!$alumno = alumnoModel::by_id($id)) {
        throw new Exception('No existe el alumno en la base de datos.');
      }

      $db_email       = $alumno['email'];
      $db_pw          = $alumno['password'];
      $db_status      = $alumno['status'];
      $db_id_g        = $alumno['id_grupo'];

      $nombres        = clean($_POST["nombres"]);
      $apellidos      = clean($_POST["apellidos"]);
      $email          = clean($_POST["email"]);
      $telefono       = clean($_POST["telefono"]);
      $password       = clean($_POST["password"]);
      $conf_password  = clean($_POST["conf_password"]);
      $id_grupo       = clean($_POST["id_grupo"]);
      $changed_email  = $db_email === $email ? false : true;
      $changed_pw     = false;
      $changed_g      = $db_id_g === $id_grupo ? false : true;

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

      // Validar que el correo sea válido
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Ingresa un correo electrónico válido.');
      }

      // Verificar si el correo electrónico ya existe
      if (alumnoModel::emailExists($email)) {
        throw new Exception('Este correo electrónico ya está registrado. Por favor, usa otro.');
      }

      //Validación de contraseña
      $pw_ok = password_verify($db_pw, $password . AUTH_SALT);
      if (!empty($password) && $pw_ok === false && strlen($password) < 8) {
        throw new Exception('La contraseña debe tener al menos 8 caracteres.');
      }

      if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        throw new Exception('La contraseña debe contener al menos una letra y un número.');
      }

      if (!empty($password) && $pw_ok === false &&  $password !== $conf_password) {
        throw new Exception('Las contraseñas no coinciden.');
      }

      // Validar que el id_grupo exista

      if ($id_grupo === '' || !grupoModel::by_id($id_grupo)) {
        throw new Exception('Selecciona un grupo valido.');
      }

      $data = [
        'nombres'         => $nombres,
        'apellidos'       => $apellidos,
        'nombre_completo' => sprintf('%s %s', $nombres, $apellidos),
        'email'           => $email,
        'telefono'        => $telefono,
        'status'          => $changed_email ? 'pendiente' : $db_status
      ];

      //Actualización de contraseña
      if (!empty($password) && $pw_ok === false) {
        $data['password'] = password_hash($password . AUTH_SALT, PASSWORD_BCRYPT);
        $changed_pw = true;
      }

      //Actualizar base de datos
      if (!alumnoModel::update(alumnoModel::$t1, ['id' => $id], $data)) {
        throw new Exception(get_notificaciones(2));
      }

      if ($changed_g) {
        if (!grupoModel::update(grupoModel::$t3, ['id_alumno' => $id], ['id_grupo' => $id_grupo])) {
          throw new Exception(get_notificaciones(2));
        }
      }

      $alumno = alumnoModel::by_id($id);
      $grupo = grupoModel::by_id($id_grupo);


      Flasher::new(sprintf('Alumno <b>%s</b> actualizado con éxito.', $alumno['nombre_completo']), 'success');

      if ($changed_email) {
        mail_confirmar_cuenta($id);
        Flasher::new(sprintf('Se ha enviado un correo electrónico a <b>%s</b> para confirmar el cambio de correo electrónico.', $email), 'info');
      }

      if ($changed_pw) {
        Flasher::new(sprintf('La contraseña del alumno ha sido actualizada.'));
      }

      if ($changed_g) {
        Flasher::new(sprintf('El alumno <b>%s</b> ha sido asignado al grupo <b>%s</b>.', $alumno['nombre_completo'], $grupo['nombre']), 'success');
      }
      Redirect::back();
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

    try {
      if (!check_get_data(['_t'], $_GET) || !Csrf::validate($_GET['_t'])) {
        throw new Exception(get_notificaciones(0));
      }

      //Validar rol
      if (!is_admin(get_user_role())) {
        throw new Exception(get_notificaciones(1));
      }

      // Validar que el alumno exista
      if (!$alumno = alumnoModel::by_id($id)) {
        throw new Exception('No existe el alumno en la base de datos.');
      }

      //Borramos el registro y sus conexiones
      if (alumnoModel::eliminar($alumno['id']) === false) {
        throw new Exception(get_notificaciones(4));
    }
    
    Flasher::new(sprintf('Alumno <b>%s</b> borrado con éxito.', $alumno['nombre_completo']), 'success');
    Redirect::to('alumnos');

    } catch (PDOException $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::back();
    } catch (Exception $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::back();
    }
  }
}
