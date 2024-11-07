<?php


$conn = new mysqli("localhost", "root", "", "calendar_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['event_id'], $_POST['event_name'], $_POST['event_start_date'], $_POST['event_end_date'], $_POST['event_color'])) {
    $event_id = $_POST['event_id'];
    $event_name = $_POST['event_name'];
    $event_start_date = $_POST['event_start_date'];
    $event_end_date = $_POST['event_end_date'];
    $event_color = $_POST['event_color'];

    $sql = "UPDATE calendar_event_master SET event_name = ?, event_start_date = ?, event_end_date = ?, event_color = ? WHERE event_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(['status' => false, 'msg' => 'Prepare failed: ' . $conn->error]);
        exit();
    }

    $stmt->bind_param("ssssi", $event_name, $event_start_date, $event_end_date, $event_color, $event_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => true, 'msg' => 'Event updated successfully.']);
    } else {
        echo json_encode(['status' => false, 'msg' => 'Failed to update event: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => false, 'msg' => 'Invalid request.']);
}

$conn->close();
?>
