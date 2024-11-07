<?php
$conn = new mysqli("localhost", "root", "", "calendar_db");
$sql = "SELECT event_id, event_name, event_start_date, event_end_date,event_color FROM calendar_event_master";
$result = $conn->query($sql);
$events = [];
while($row = $result->fetch_assoc()) {
    $events[] = $row;
}
echo json_encode(["data" => $events]);
?>
