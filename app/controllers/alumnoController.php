<?php

/**
 * Plantilla general de controladores
 * Versión 1.0.2
 *
 * Controlador de alumno
 */
class alumnoController extends Controller
{
  private $id_alumno = null;

  function __construct()
  {
    // Validación de sesión de usuario, descomentar si requerida
    if (!Auth::validate()) {
      Flasher::new('Debes iniciar sesión primero.', 'danger');
      Redirect::to('login');
    }

    if (!is_alumno(get_user_role())) {
      Flasher::new(get_notificaciones(), 'danger');
      Redirect::back();
    }


    $this->id_alumno = get_user('id');
  }

  function index()
  {
    $this->grupo();
  }

  function grupo(){
    if(!$grupo = grupoModel::by_alumno($this->id_alumno)){
      Flasher::new('No existe grupo en la base de datos.', 'danger');
      Redirect::back();
    }

    $data =
    [
      'title' => $grupo['nombre'],
      'slug'  => 'alumno-grupo',
      'g'     => $grupo
    ];

    View::render('grupo', $data);

  }

}
