<?php
require_once "../init.php";
require_once "../Class/Appointment.php";
$appointment = new Appointment();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON input from the request body
    $input = json_decode(file_get_contents('php://input'), true);

    if ($input) {
        $name = $input['name'];
        $email = $input['email'];
        $contact = $input['contact'];
        $date = $input['date'];
        $service_id = $input['service'];
        $operating_hour_id = $input['operatingHour'];
        
        $result = $appointment->makeAppointment($name, $email, $contact, $date, $service_id, $operating_hour_id);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create appointment.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
