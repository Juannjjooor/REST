<?php

function getRequestBody(){
  $json = file_get_contents('php://input');
  
  return json_decode($json, true);
}

function createTask($conn, $userData){
  $createTask = [
    ':title' => $userData['title'],
    ':category' => $userData['category'],
    ':description' => $userData['description'],
    ':created_date' => (new DateTime())->format('Y-m-d H:i:s'),
    ':current_date' => (new DateTime())->format('Y-m-d H:i:s')
  ];
  
  $insertSQL = "INSERT INTO usuarios (title, category, description, created_date, current_date) VALUES (:title, :category, :description, :created_date, :current_date)";
  //le decimos a PDO que prepare la consulta de $insertSQL para su uso posterior
  $query = $conn->prepare($insertSQL);
  
  try{
    // Vincula y ejecuta
    if($query->execute($createTask)) {
        return $conn->lastInsertId();
    }
  }catch(Exception $e){
    return $e->getMessage();
  }
}

function getTask($conn, $id){
  $userSQL = "SELECT * FROM usuarios WHERE id=:id";
  $query = $conn->prepare($userSQL);
  // Especificamos el fetch mode antes de llamar a fetch()
  $query->setFetchMode(PDO::FETCH_ASSOC);
  // Ejecutamos
  $query->execute([':id' => $id]);
  // Mostramos los resultados
  $users = $query->fetchAll();

  if(count($users) === 0){
    return null;
  }

  return $users[0];
}

function getTaskList($conn){
  $usersSQL = "SELECT * FROM usuarios ORDER BY created_date ASC";
  $query = $conn->prepare($usersSQL);
  // Especificamos el fetch mode antes de llamar a fetch()
  $query->setFetchMode(PDO::FETCH_ASSOC);
  // Ejecutamos
  $query->execute();
  // retornamos los resultados de la base de datos según la consulta SQL y los devolvemos directamente
  return $query->fetchAll();
}
  
function updateTask($conn, $userData, $id){
  $updateTask = [
    ':title' => $userData['title'],
    ':category' => $userData['category'],
    ':description' => $userData['description'],
    //':created_date' => $userData['created_date'],
    //':current_date' => $userData['current_date'],
    ':id' => $id
  ];
  
  //$updateSQL = "UPDATE usuarios SET title=:title, category=:category, description=:description, created_date=:created_date, current_date=:current_date WHERE id=:id";
  $updateSQL = "UPDATE usuarios SET title=:title, category=:category, description=:description WHERE id=:id";
  //le decimos a PDO que prepare la consulta de $insertSQL para su uso posterior
  $query = $conn->prepare($updateSQL);
  
  //try{
    // Vincula y executa
    if($query->execute($updateTask)) {
        return $id;
    }
  //}catch(Exception $e){
    return null;
  //}
}

function deleteTask($conn, $id){
  $deleteTask = [
    ':id' => $id
  ];
  
  $deleteSQL = "DELETE FROM usuarios WHERE id=:id";
  //le decimos a PDO que prepare la consulta de $insertSQL para su uso posterior
  $query = $conn->prepare($deleteSQL);
  
  try{
    // Vincula y executa
    if($query->execute($deleteTask)) {
      return $query->rowCount();
    }
  }catch(Exception $e){
    return 0;
  }
}