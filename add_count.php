<?php
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the data from the request body (assuming the data is sent as JSON)
    $requestData = json_decode(file_get_contents('php://input'), true);

  
    if (isset($requestData['count']) && !empty($requestData['count'])) {
        // Database connection
        $dbhost = 'localhost';
        $dbuser = 'root';
        $password = '';
        $dbname = 'ims_project';

        $dbconnect = new mysqli($dbhost, $dbuser, $password, $dbname);

        if ($dbconnect->connect_error) {
            die("Connection failed: " . $dbconnect->connect_error);
        }

        // Sanitize the input data to prevent SQL injection
        $count = $dbconnect->real_escape_string($requestData['count']);

        // Insert data into the database
        $insertQuery = "INSERT INTO tb_count (count) VALUES ('$count')";

        if ($dbconnect->query($insertQuery) === TRUE) {
            http_response_code(201); // Created
            echo json_encode(array("status" => "success", "message" => "Data count berhasil ditambah."));
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(array("status" => "error", "message" => "Error adding count: " . $dbconnect->error));
        }

        // Close the database connection
        $dbconnect->close();
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(array("message" => "Invalid data."));
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("message" => "Only POST method is allowed."));
}