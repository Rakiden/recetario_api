<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

define('DB_NAME','UZMZrLAgvJ');
define('DB_USER','UZMZrLAgvJ');
define('DB_PASSWORD','sxpAB2clyp');
define('DB_HOST','remotemysql.com');

$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

$postjson = json_decode(file_get_contents('php://input'),true);
if($postjson['mode']=="register"){
  $password = md5($postjson['password']);
  $query = mysqli_query($mysqli, "INSERT INTO user SET
      name = '$postjson[name]',
      last_name = '$postjson[last_name]',
      username = '$postjson[username]',
      email = '$postjson[email]',
      password = '$password'
  ");

  if($query) $result = json_encode(array('success'=>true));
  else $result = json_encode(array('success'=>false, 'msg'=>$"Error, intentelo de nuevo"));

  echo $result;
}elseif($postjson['mode']=="login"){
  $password = md5($postjson['password']);
  $query1 = mysqli_query($mysqli, "SELECT * FROM master_user WHERE username='$postjson[username]' AND password = '$password'");
  $query2 = mysqli_query($mysqli, "SELECT * FROM master_user WHERE email='$postjson[email]' AND password = '$password'");
  
  $check = mysqli_num_rows($query);

  if($query1){
    $check = mysqli_num_rows($query1);
  }elseif($query2){
    $check = mysqli_num_rows($query2);
  }

  if($check>0){
      $data = mysqli_fetch_array($query);
      $datauser = array(
          'user_id' =>$data['user_id'], 
          'username' =>$data['username'], 
          'password' =>$data['password']
      );
      $result = json_encode(array('success'=>true,'result' => $datauser));
  }else{
      $result = json_encode(array('success'=>false,'mgs' => "Nombre, Email o Contraseña incorrectos"));
  }
  
  echo $result;
}
?>