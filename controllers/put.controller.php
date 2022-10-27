<?php
//obtenemos el body de la petición (función creada por nosotros)
$userData = getRequestBody();
//Si no es un array lo que llega en el body cortamos ejecución, no han llegado datos en el body
if(!is_array($userData)){
//devolvemos un error
http_response_code(400);
echo '{"message": "Wrongly formed request"}';
return;
}

//validamos que exista el parámetro
if(!key_exists('title',$userData)){
http_response_code(400);
echo '{"message": "title must be specified"}';
return;
}

//validamos que exista el parámetro
if(!key_exists('category',$userData)){
http_response_code(400);
echo '{"message": "category must be specified"}';
return;
}

//validamos que exista el parámetro
if(!key_exists('description',$userData)){
http_response_code(400);
echo '{"message": "description must be specified"}';
return;
}

//validamos que exista el parámetro
if(!key_exists('created_date',$userData)){
http_response_code(400);
echo '{"message": "created_date must be specified"}';
return;
}

//validamos que exista el parámetro
if(!key_exists('current_date',$userData)){
http_response_code(400);
echo '{"message": "current_date must be specified"}';
return;
}


//partimos la ruta para extraer recurso + id de la tarea que se quiere acceder
$uriParts = explode('/',substr($uri,1));

//si la ruta no tiene 2 framentos (recurso + id) no ejecuta el código dentro del if
if($uriParts[0] === 'users' && count($uriParts) === 2){
//editamos la tarea, si todo va bien tenemos el id de la tarea, en caso contrario un null
$id = updateTask($conn, $userData, $uriParts[1]);

//si no se ha editado la tarea devolvemos un error
if(!$id){
    //devolvemos un error
    http_response_code(400);
    echo '{"message": "Error updating the task, please verify that the data were sent correctly"}';
    return;
}

//obtenemos los datos de la tarea
$user = getTask($conn, $id);
//eliminamos el campo contraseña para evitar filtrados
unset($user['password']);
//devolvemos la respuesta con código 200 + json con datos del usuario
http_response_code(200);
echo json_encode($user);
}