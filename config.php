<?php
define('DB_SERVER', 'db');
define('DB_USERNAME', 'user');
define('DB_PASSWORD', 'PASSWORD_test');
define('DB_NAME', 'myDb');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}


$db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if (mysqli_connect_errno()){
    $db = null;
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>