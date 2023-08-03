<?php
include 'conection.php';

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

$count = mysqli_query($dbconnect, "SELECT * FROM tb_count WHERE id =(SELECT MAX(id) FROM tb_count)");
$history = mysqli_query($dbconnect, "SELECT * FROM tb_count");
$sql = mysqli_query($dbconnect, "SELECT * FROM tb_kontrol");
while ($row = mysqli_fetch_assoc($sql)) {
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
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.4/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap4.min.css">
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
            <div class="col-md-4 mb-3">
                <div class="card pb-3">
                    <div class="card-body mb-4 text-center">
                        <h4>Time Process</h4>
                        <span id="countdown" class="font-weight-bold"
                            style="font-weight: bold; font-size: 48px">00.00</span>
                        <br>
                        <a class="btn btn-success" href="timer.php?timer=1&state=1" onclick="reloadP()">START</a>
                        <a class="btn btn-danger" href="timer.php?timer=1&state=0">STOP</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4 ">
                <div class="card pb-5">
                    <div class="card-body text-center">
                        <h4>Count</h4>
                        <div>
                            <?php
                                if ($row['aktifasi'] == '0') { ?>
                            <span id="count" class="font-weight-bold"
                                style="font-weight: bold; font-size: 48px">0</span>
                            <?php } else { ?>
                            <?php foreach ($count as $data) : ?>
                            <span id="count" class="font-weight-bold"
                                style="font-weight: bold; font-size: 48px"><?= $data['count'] ?></span>
                            <?php endforeach; ?>
                            <?php   } ?>
                        </div>
                        <div>
                            <a class="btn btn-danger" href="aktifasi.php?aksi=1&state=0">Reset</a>
                        </div>
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
                                <a href="aksi.php?motor=1&state=1&aktif=0" class="btn btn-success">
                                    Motor ON
                                </a>
                                <a href="aksi.php?motor=1&state=0&aktif=1" class="btn btn-danger">
                                    Motor OFF
                                </a>
                            </div>
                            <div class="col-md-6 text-center">
                                <h4>Status Motor</h4>
                                <span id="Status" class="font-weight-bold"
                                    style="font-weight: bold; font-size: 48px"><?php
                                                                                                                            if ($row['motor'] == '0') {
                                                                                                                                $state = "OFF";
                                                                                                                            } else {
                                                                                                                                $state = "ON";
                                                                                                                            }
                                                                                                                            echo $state;
                                                                                                                            ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Riwayat Deteksi Rotator Motor</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Count</th>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                    </tr>
                                </thead>
                                <?php foreach ($history as $data) : ?>
                                <tbody>
                                    <tr>
                                        <td><?= $data['id'] ?></td>
                                        <td><?= $data['count'] ?></td>
                                        <td><?= date('d F Y', strtotime($data['time'])) ?></td>
                                        <td><?= date('h:i:s A', strtotime($data['time'])) ?></td>
                                    </tr>
                                </tbody>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

    </script>
    <script>
    var timeInSecs;
    var ticker;
    var timer = <?= $row['time'] ?>;

    console.log(timer);


    function timerControl() {
        if (timer == '1') {
            startTimer();
        } else {
            stopTimer();
        }
    }

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

    window.onload = function() {
        var reloading = sessionStorage.getItem("reloading");
        if (reloading) {
            sessionStorage.removeItem("reloading");
            timerControl();
        }
    }

    function reloadP() {
        sessionStorage.setItem("reloading", "true");
        document.location.reload();
    }
    </script>

    <?php
}
// }
    ?>
    <!-- end main -->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script>
    $(document).ready(function() {
        $('#datatable').DataTable();
    });
    </script>
    <script>
    function toggleElement() {
        var x = document.getElementById("count");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.bootstrap4.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.print.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.colVis.min.js" type="text/javascript"></script>
</body>

</html>