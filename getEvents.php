<?php
$apiKey = 'FfyNyDq4UMJU0t0dVtTgNVGDLaSHvAxw'; // Replace with your actual API key
$countryCode = 'IN'; // For India
$year = 2024; // Year for the holidays

// Fetch holidays from the Calendarific API
$apiUrl = "https://calendarific.com/api/v2/holidays?api_key={$apiKey}&country={$countryCode}&year={$year}";
$apiResponse = file_get_contents($apiUrl);
$holidaysData = json_decode($apiResponse, true);

$holidays = [];
if ($holidaysData && isset($holidaysData['response']['holidays'])) {
    foreach ($holidaysData['response']['holidays'] as $holiday) {
        $holidays[] = [
            'title' => $holiday['name'],
            'start' => $holiday['date']['iso'],
            'color' => "#ff5733" // Custom color for holidays
        ];
    }
}

// Fetch saved events from the database
$conn = new mysqli("localhost", "root", "", "calendar_db");
$sql = "SELECT event_id, event_name, event_start_date, event_end_date, event_color FROM calendar_event_master";
$result = $conn->query($sql);

$events = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $events[] = [
            'id' => $row['event_id'],
            'title' => $row['event_name'],
            'start' => $row['event_start_date'],
            'end' => $row['event_end_date'],
            'color' => $row['event_color']
        ];
    }
}

// Combine holidays and events
$allEvents = array_merge($holidays, $events);

// Output combined events as JSON
header('Content-Type: application/json');
echo json_encode(["data" => $allEvents]);
?>
