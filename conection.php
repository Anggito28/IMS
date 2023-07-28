<?php 

$dbhost = 'localhost';
$dbuser = 'root';
$password = '';
$dbname = 'ims_project';

$dbconnect = new mysqli($dbhost, $dbuser, $password, $dbname);

if($dbconnect->connect_error){
    die('server down');
}

?>