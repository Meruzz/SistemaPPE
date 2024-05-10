<?php

/**
 * Regresa el rol del usuario
 * 
 * @return mixed
 */
function get_user_role()
{
  return $rol = get_user('rol');
}

function get_default_roles()
{
  return ['root', 'admin',];
}

function is_root($rol)
{
  return in_array($rol, ['root']);
}

function is_admin($rol)
{
  return in_array($rol, ['admin', 'root']);
}
function is_profesor($rol)
{
  return in_array($rol, ['profesor', 'admin', 'root']);
}

function is_alumno($rol)
{
  return in_array($rol, ['alumno', 'admin', 'root']);
}

function is_user($rol, $roles_aceptados)
{
  $default = get_default_roles();

  if (!is_array($roles_aceptados)) {
    array_push($default, $roles_aceptados);
    return in_array($rol, $default);
  }
  return in_array($rol, array_merge($default, $roles_aceptados));
}

/**
 * 0 Acceso no autorizado
 * 1 Acción no autorizada
 * 2 Agregar
 * 3 Actualizar
 * 4 Borrar
 *
 * @param integer $index
 * @return string
 */

function get_notificaciones($index = 0)
{
  $notificaciones = [
    'Acceso no autorizado.',
    'Acción no autorizada.',
    'Hubo un error al agregar el registro.',
    'Hubo un error al actualizar el registro.',
    'Hubo un error al borrar el registro.'
  ];

  return isset($notificaciones[$index]) ? $notificaciones[$index] : $notificaciones[0];
}

function get_estados_usuarios()
{
  return [
    ['pendiente', 'Pendiente de activación'],
    ['activo', 'Activo'],
    ['suspendido', 'Suspendido']
  ];
}

function format_estado_usuario($status)
{
  $placeholder = '<div class="badge %s"><i class="%s"></i> %s</div>';
  $classes = '';
  $icon = '';
  $text = '';

  switch ($status) {
    case 'pendiente':
      $classes = 'badge-warning text-dark';
      $icon = 'fas fa-clock';
      $text = 'Pendiente';
      break;

    case 'activo':
      $classes = 'badge-success';
      $icon = 'fas fa-check';
      $text = 'Activo';
      break;

    case 'suspendido':
      $classes = 'badge-danger';
      $icon = 'fas fa-times';
      $text = 'Suspendido';
      break;

    default:
      $classes = 'badge-danger';
      $icon = 'fas fa-question';
      $text = 'Desconocido';
      break;
  }

  return sprintf($placeholder, $classes, $icon, $text);
}

/**
 * Enviar email de activación de correo electrónico
 *
 * @param int $id_usuario
 * @return bool
 */
function mail_confirmar_cuenta($id_usuario)
{
  if (!$usuario = usuarioModel::by_id($id_usuario)) return false; // Nuevo método creado en modelo

  $nombre = $usuario['nombres'];
  $hash = $usuario['hash'];
  $email = $usuario['email'];
  $status = $usuario['status'];

  // Si no es pendiente el status no requiere activación
  if ($status !== 'pendiente') return false;

  $subject = sprintf('Confirma tu correo electrónico por favor %s.', $nombre);
  $alt     = sprintf('Debes confirmar tu correo electrónico para poder ingresar a %s.', get_sitename());
  $url     = buildURL(URL . 'login/activate', ['email' => $email, 'hash' => $hash], false, false);
  $text    = '¡Hola %s!<br>Para ingresar al sistema de <b>%s</b> primero debes confirmar tu dirección de correo electrónico dando clic en el siguiente enlace seguro: 
    <a href="%s">%s</a>';

  $body = sprintf($text, $nombre, get_sitename(), $url, $url);

  if (send_email(get_siteemail(), $email, $subject, $body, $alt) !== true) return false;

  return true;
}

function mail_recuperacion_contrasena($id_usuario)
{
  $usuario = usuarioModel::by_id($id_usuario);

  if (empty($usuario)) return false;

  // Array para nuevo token
  $email   = $usuario['email'];
  $nombre  = $usuario['nombre_completo'];
  $token   = generate_token();
  $url     = buildURL(URL.'login/password', ['id' => $id_usuario, 'token' => $token], false, false);
  $post    = 
  [
    'tipo'       => 'token_recuperacion',
    'id_ref'     => 0,
    'id_usuario' => $id_usuario,
    'titulo'     => 'Token de recuperación de contraseña',
    'contenido'  => $token,
    'permalink'  => $url,
    'creado'     => now()
  ];

  // Agregando el post / token a la base de datos
  if (!$id_post = postModel::add(postModel::$t1, $post)) {
    return false;
  }

  $subject = sprintf('Recuperación de contraseña para %s', $nombre);
  $alt    = 'Ingresa para realizar el cambio de contraseña para tu cuenta.';
  $text    = '¡Hola %s!<br>Para actualizar tu contraseña ingresa al siguiente enlace: <a href="%s">%s</a>';
  $body    = sprintf($text, $nombre, $url, $url);

  // Creando el correo electrónico
  if (!send_email(get_siteemail(), $email, $subject, $body, $alt) !== true) return false;
  return true;
}

/**
   * Enviar email de suspensión de cuenta
   *
   * @param integer $id_usuario
   * @return bool
   */
  function mail_suspension_cuenta($id_usuario)
  {
    $usuario = usuarioModel::by_id($id_usuario);

    if (empty($usuario)) return false;

    $nombre = $usuario['nombre_completo'];
    $email  = $usuario['email'];
    $status = $usuario['status'];

    if ($status !== 'suspendido') return false;

    $subject = sprintf('%s tu cuenta ha sido suspendida', $nombre);
    $alt     = sprintf('Regulariza tu situación en %s para poder ingresar.', get_sitename());
    $text    = "Hola %s<br>Te informamos que tu cuenta ha sido suspendida, regulariza tu situación para poder ingresar de nuevo a <b>%s</b>.";
    $body    = sprintf($text, $nombre, get_sitename());

    // Creando el correo electrónico
    if (send_email(get_siteemail(), $email, $subject, $body, $alt) !== true) return false;

    return true;
  }

  /**
   * Enviar email de retiro de suspensión
   *
   * @param integer $id_usuario
   * @return bool
   */
  function mail_retirar_suspension_cuenta($id_usuario)
  {
    $usuario = usuarioModel::by_id($id_usuario);

    if (empty($usuario)) return false;

    $nombre = $usuario['nombre_completo'];
    $email  = $usuario['email'];
    $status = $usuario['status'];

    if ($status === 'suspendido') return false;

    $subject = sprintf('%s suspensión retirada de tu cuenta', $nombre);
    $alt     = sprintf('Puedes ingresar de nuevo a %s.', get_sitename());
    $text    = "Hola %s<br>Te informamos que tu cuenta ha sido habilitada de nuevo, ya puedes ingresar a <b>%s</b>.";
    $body    = sprintf($text, $nombre, get_sitename());

    // Creando el correo electrónico
    if (send_email(get_siteemail(), $email, $subject, $body, $alt) !== true) return false;

    return true;
  }
