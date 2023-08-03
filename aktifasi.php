<?php

if (isset($_GET['aksi']) && isset($_GET['state'])) {
    include 'conection.php';
    $state = $_GET['state'];
    $aksi = $_GET['aksi'];

    if ($aksi == '1') {
        mysqli_query($dbconnect, "UPDATE tb_kontrol SET aktifasi='$state'");
    } else {
        echo "not valid";
    }
}
header('location: index.php');
exit;



?>';