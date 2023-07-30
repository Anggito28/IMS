<?php

   if(isset($_GET['timer']) && isset($_GET['state'])){
    include 'conection.php';
    $state = $_GET['state'];
    $time = $_GET['timer'];

    if($time == '1'){
        mysqli_query($dbconnect, "UPDATE tb_kontrol SET time='$state'");
    }else{
        echo "not valid";
    }
}
header('location: index.php');
exit;

?>