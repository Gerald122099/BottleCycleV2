<?php

$servername = "localhost";
$username = "root";  // Replace with your database username
$password = "";      // Replace with your database password
$dbname = "bottlecycle-ctu";
// Set the response type to JSON
header('Content-Type: application/json');

// Database connection (replace with your actual DB credentials)
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

// SQL query to get the total of all bins and include bin_code
$sql = "SELECT DATE(timestamp) AS date,
            bin_code,
            SUM(total_small) AS total_small,
            SUM(total_medium) AS total_medium,
            SUM(total_large) AS total_large,
            SUM(total_bottles) AS total_bottles
        FROM bin_summary  -- Table name is bin_summary
        GROUP BY bin_code";  // Group by bin_code to get individual totals per bin

$result = $mysqli->query($sql);

// Check if the query was successful
if ($result) {
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;  // Store each row of the result in the data array
    }
    echo json_encode($data); // Return the result as a JSON response
} else {
    echo json_encode(['error' => 'Failed to fetch data']);
}

// Close the database connection
$mysqli->close();
?>