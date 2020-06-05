<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

//include "https://serverapiprueba.herokuapp.com/config/config.php";

define('DB_NAME','UZMZrLAgvJ');
define('DB_USER','UZMZrLAgvJ');
define('DB_PASSWORD','sxpAB2clyp');
define('DB_HOST','https://remotefesfsmysql.com/phpmyadmin/sql.php');


$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);



$postjson = json_decode(file_get_contents('php://input'),true);
if($postjson['aksi']=="register"){
    $password = md5($postjson['password']);
    $query = mysqli_query($mysqli, "INSERT INTO user SET
        name = '$postjson[name]',
        last_name = '$postjson[last_name]',
        username = '$postjson[username]',
        email = '$postjson[email]',
        password = '$password'
    ");
    
    if($query) $result = json_encode(array('success'=>true));
    else $result = json_encode(array('success'=>false, 'msg'=>$query));

    echo $result;
  }
?>