<?php
require_once "../init.php";
require_once "../Class/Appointment.php";
$appointment = new Appointment();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['date'])) 
{
    $date = $_GET['date'];

    // Validate the date format (optional but recommended)
    $dateTime = DateTime::createFromFormat('Y-m-d', $date);
    if (!$dateTime || $dateTime->format('Y-m-d') !== $date) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid date format. Expected format: YYYY-MM-DD']);
        exit;
    }

    // Fetch available time slots for the given date
    $timeSlots = $appointment->getAvailableTimeSlots($date);

    echo json_encode($timeSlots);
} 
else 
{
    http_response_code(400);
    echo json_encode(['error' => 'Date parameter is required']);
}

?>
