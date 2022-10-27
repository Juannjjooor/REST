<?php
//todas las respuestas que devolverá serán de tipo JSON, lo configuramos al inicio para no repetir código
header('Content-Type: application/json; charset=utf-8');

/** INCLUIMOS EL FICHERO QUE CONTIENE LA CONEXIÓN A LA BASE DE DATOS */
require_once __DIR__ . '/db.php';
/** INCLUIMOS EL FICHERO QUE CONTIENE LAS FUNCIONES PARA TRABAJAR CON LA BASE DE DATOS **/
require_once __DIR__ . '/functions.php';

//obtenemos el path recibido en la petición para poder saber recurso e idientificador cuando hagamos las comprobaciones de qué acción ejecutar
$uri = $_SERVER['REQUEST_URI'];

//Si el proyecto está en un subdirectorio eliminamos la parte de la ruta correspondiente al subdirectorio (la forma más correcta es hacerlo mediante .htaccess)
$uri = str_replace('/CRUD-USUARIOS','',$uri);
//obtenemos el verbo http para saber qué acción se quiere realizar
$httpVerb = $_SERVER['REQUEST_METHOD'];

//acciones para verbo POST
if ($httpVerb === 'POST') {
  require_once __DIR__ . '/controllers/post.controller.php';
}

//acciones para verbo GET
if ($httpVerb === 'GET') {
  require_once __DIR__ . '/controllers/get.controller.php';
}

//acciones para verbo PUT
if ($httpVerb === 'PUT') {
  require_once __DIR__ . '/controllers/put.controller.php';
}

//acciones para verbo DELETE
if ($httpVerb === 'DELETE') {
  require_once __DIR__ . '/controllers/delete.controller.php';
}
