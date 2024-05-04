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
