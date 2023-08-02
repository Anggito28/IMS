<?php 

$dbhost = 'localhost';
$dbuser = 'root';
$password = '';
$dbname = 'ims_project1';

$dbconnect = new mysqli($dbhost, $dbuser, $password, $dbname);

if($dbconnect->connect_error){
    die('server down');
}
