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
