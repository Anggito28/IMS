<?php

if (isset($_GET['motor']) && isset($_GET['state'])) {
    include 'conection.php';
    $state = $_GET['state'];
    $aktif = $_GET['aktif'];
    $motor = $_GET['motor'];

    if ($motor == '1') {
        mysqli_query($dbconnect, "UPDATE tb_kontrol SET motor='$state', aktifasi='$aktif'");
    } else {
        echo "not valid";
    }
}
header('location: index.php');
exit;



?>';