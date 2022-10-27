<?php

// La petición está usando el verbo POST
  //ruta para creación de usuario
  if($uri = "/users"){
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

    //creamos la tarea
    $result = createTask($conn, $userData);
    //aquí deberíamos devolver un error si $result es null

    //obtenemos la info de la tarea anteriormente creada y la guardamos en $user
    $user = getTask($conn, $result);

    //quitamos la clave password para evitar filtraciones de la contraseña
    unset($user['password']);

    //devolvemos la respuesta con código 201 + json con datos de la tarea
    http_response_code(201);
    echo json_encode($user);
    return;
  }