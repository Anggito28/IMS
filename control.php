<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming the database connection is established in 'conection.php'
    include 'conection.php';

    // Read raw JSON data from the request body
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    if ($data && isset($data['token'])) {
        $key = $data['token'];

        // Sanitize the input to prevent SQL injection (you can use prepared statements for better security)
        $safe_key = mysqli_real_escape_string($dbconnect, $key);

        $sql = mysqli_query($dbconnect, "SELECT * FROM tb_kontrol WHERE token='$safe_key'");
        $query = mysqli_num_rows($sql);

        if ($query > 0) {
            $data = mysqli_fetch_assoc($sql);
            $response = ["status" => "success", "data" => $data];
        } else {
            $response = ["status" => "error", "message" => "Token not found"];
        }

        // Convert the response array to JSON format
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        $response = ["status" => "error", "message" => "Invalid or missing token"];
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
?>