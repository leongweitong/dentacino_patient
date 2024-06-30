<?php
require_once "../init.php";
require_once "../Class/CancellationToken.php";
$cancelToken = new CancellationToken();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON input from the request body
    $input = json_decode(file_get_contents('php://input'), true);

    if ($input) {
        $id = $input['id'];
        $email = $input['email'];
        $name = $input['name'];
        
        $token = $cancelToken->requestCancellation($id);
        $cancelToken->sendCancellationEmail($email, $name, $token);

        if ($token) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create cancel token.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
