<?php
$conn = new mysqli("localhost", "root", "", "calendar_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$event_name = $_POST["event_name"];
$event_start_date = $_POST["event_start_date"];
$event_end_date = $_POST["event_end_date"];
$event_color = $_POST["event_color"];

$sql = "INSERT INTO calendar_event_master (event_name, event_start_date, event_end_date, event_color)
        VALUES ('$event_name', '$event_start_date', '$event_end_date', '$event_color')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => true, "msg" => "7 Crore...... event add hogaya"]);
} else {
    echo json_encode(["status" => false, "msg" => "Error: " . $conn->error]);
}
?>
