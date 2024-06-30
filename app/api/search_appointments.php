<?php
require_once "../init.php";
require_once "../Class/Appointment.php";
$appointment = new Appointment();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && (isset($_GET['email']) || isset($_GET['id']))) 
{
    if (isset($_GET['email'])) {
        $email = $_GET['email'];
        $result = $appointment->getAppointmentByEmail($email);
        $type = 'email';
    } 
    else {
        $id = $_GET['id'];
        $result = $appointment->getAppointmentById($id);
        $type = 'id';
    }

    if ($result) {
        echo json_encode(['success' => true, 'type' => $type, 'data' => $result]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No appointment found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
