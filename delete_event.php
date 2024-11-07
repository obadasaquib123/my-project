<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "calendar_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
    // Prepare the SQL statement to delete the event
    $sql = "DELETE FROM calendar_event_master WHERE event_id = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        echo json_encode(['status' => false, 'msg' => 'Prepare failed: ' . $conn->error]);
        exit();
    }
    
    $stmt->bind_param("i", $event_id);
    
    // Execute the statement and check if it was successful
    if ($stmt->execute()) {
        echo json_encode(['status' => true, 'msg' => 'Deleted successfully!']);
    } else {
        echo json_encode(['status' => false, 'msg' => 'Failed to delete event: ' . $stmt->error]);
    }
    
    $stmt->close();
} else {
    echo json_encode(['status' => false, 'msg' => 'Invalid request.']);
}

$conn->close();
?>
