<?php 

    if(isset($_GET['motor']) && isset($_GET['state'])){
        include 'conection.php';
        $state = $_GET['state'];
        $motor = $_GET['motor'];

        if($motor == '1'){
            mysqli_query($dbconnect, "UPDATE tb_kontrol SET motor='$state'");
        }else{
            echo "not valid";
        }
    }
    header('location: index.php');
    exit;

?>';