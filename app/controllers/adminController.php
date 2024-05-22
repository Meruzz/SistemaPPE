<?php

/**
 * Plantilla general de controladores
 * Versión 1.0.2
 *
 * Controlador de admin
 */
class adminController extends Controller {
  function __construct()
  {
    // Validación de sesión de usuario, descomentar si requerida
    if (!Auth::validate()) {
      Flasher::new('Debes iniciar sesión primero.', 'danger');
      Redirect::to('login');
    }

    if (!is_admin(get_user_role())){
      Flasher::new(get_notificaciones(), 'danger');
      Redirect::back();
    }
    
  }
  
  function index()
  {
    $data = 
    [
      'title' => 'Administración',
      'slug'  => 'admin',
    ];
    
    // Descomentar vista si requerida
    View::render('index', $data);
  }

}