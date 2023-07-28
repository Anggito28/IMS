<?php 
  include 'conection.php';

  session_start();
 
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

  $count = mysqli_query($dbconnect, "SELECT * FROM tb_count WHERE id =(SELECT MAX(id) FROM tb_count)");

  $sql = mysqli_query($dbconnect, "SELECT * FROM tb_kontrol");
  while($row = mysqli_fetch_assoc($sql)){
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />

    <title>IMS - Politeknik Negeri Ujung Padang</title>
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="./image/logo2.png" style="width: 30%" alt="" srcset="" />
            </a>
            <h4>INDUSTRIAL MECHATRONICS SYSTEM</h4>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </nav>
    <!-- end navbar -->

    <!-- main -->

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-4 mb-4">
                <div class="card pb-2">
                    <div class="card-body m-3 text-center">
                        <h4>Time Process</h4>
                        <span id="countdown" class="font-weight-bold"
                            style="font-weight: bold; font-size: 48px">00.00</span>
                        <br>
                        <Button class="btn btn-success" onclick="startTimer();">Start Timer</Button>
                        <Button class="btn btn-danger" onclick="stopTimer();">Stop Timer</Button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4 ">
                <div class="card pb-5">
                    <div class="card-body m-3 text-center">
                        <h4>Count</h4>
                        <?php foreach($count as $data) : ?>
                        <span id="count" class="font-weight-bold"
                            style="font-weight: bold; font-size: 48px"><?= $data['count'] ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body m-3 text-center">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Control Motor</h4>
                                <br />
                                <a href="aksi.php?motor=1&state=1" class="btn btn-success">
                                    Motor ON
                                </a>
                                <a href="aksi.php?motor=1&state=0" class="btn btn-danger">
                                    Motor OFF
                                </a>
                            </div>
                            <div class="col-md-6 text-center">
                                <h4>Status Motor</h4>
                                <span id="Status" class="font-weight-bold" style="font-weight: bold; font-size: 48px"><?php
                                    if($row['motor'] == '0'){
                                        $state = "OFF";
                                    }else {
                                        $state = "ON";
                                    }
                                    echo $state;
                                    ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php 
    }   
// }
?>
    <script>
    var timeInSecs;
    var ticker;

    function startTimer(secs) {
        timeInSecs = parseInt(25);
        ticker = setInterval("tick()", 1000);
    }

    function stopTimer(secs) {
        timeInSecs = parseInt(0);
    }

    function tick() {
        var secs = timeInSecs;
        if (secs > 0) {
            timeInSecs--;
        } else {
            clearInterval(ticker);
            //   startTimer(5 * 60); // 4 minutes in seconds
        }

        var mins = Math.floor(secs / 60);
        secs %= 60;
        var pretty =
            (mins < 10 ? "0" : "") + mins + ":" + (secs < 10 ? "0" : "") + secs;

        document.getElementById("countdown").innerHTML = pretty;
    }
    // 4 minutes in seconds
    </script>
    <!-- end main -->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
</body>

</html>