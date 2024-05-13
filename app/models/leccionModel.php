<?php

/**
 * Plantilla general de modelos
 * Versión 1.0.1
 *
 * Modelo de leccion
 */
class leccionModel extends Model
{
  public static $t1   = 'lecciones'; // Nombre de la tabla en la base de datos;

  // Nombre de tabla 2 que talvez tenga conexión con registros
  //public static $t2 = '__tabla 2___'; 
  //public static $t3 = '__tabla 3___'; 

  function __construct()
  {
    // Constructor general
  }

  static function all()
  {
    // Todos los registros
    $sql = 'SELECT * FROM lecciones ORDER BY id DESC';
    return ($rows = parent::query($sql)) ? $rows : [];
  }

  static function by_id($id)
  {
    // Un registro con $id
    $sql = 
    'SELECT 
    l.* ,
    m.nombre AS materia
    FROM lecciones l
    LEFT JOIN materias m ON m.id = l.id_materia
     WHERE l.id = :id LIMIT 1';
    return ($rows = parent::query($sql, ['id' => $id])) ? $rows[0] : [];
  }

  static function by_materia_profesor($id_materia, $id_profesor)
  {
    $sql =
      'SELECT
     l.*,
     m.nombre AS materia,
     u.nombre_completo AS profesor
     FROM
     lecciones l
     JOIN materias_profesores mp ON mp.id_materia = l.id_materia
     AND mp.id_profesor = l.id_profesor
     LEFT JOIN materias m ON m.id = mp.id_materia
     LEFT JOIN usuarios u ON u.id = mp.id_profesor AND u.rol = "profesor"
     WHERE
     l.id_materia = :id_materia AND l.id_profesor = :id_profesor';
    return PaginationHandler::paginate($sql, ['id_materia' => $id_materia, 'id_profesor' => $id_profesor]);
  }

  static function by_materia($id_materia)
  {
    $sql =
      'SELECT
     l.*,
     m.nombre AS materia,
     u.nombre_completo AS profesor
     FROM
     lecciones l
     JOIN materias_profesores mp ON mp.id_materia = l.id_materia
     AND mp.id_profesor = l.id_profesor
     LEFT JOIN materias m ON m.id = mp.id_materia
     LEFT JOIN usuarios u ON u.id = mp.id_profesor AND u.rol = "profesor"
     WHERE
     l.id_materia = :id_materia';
    return PaginationHandler::paginate($sql, ['id_materia' => $id_materia]);
  }
}
