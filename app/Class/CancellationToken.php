<?php

Class CancellationToken{
    use Database;
    use SendEmail;

    private $con = "";
    public function __construct() {
        $this->con = $this->connect();
    }

    public function requestCancellation($appointmentId) {
        $token = bin2hex(random_bytes(16)); // Generate a random token
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token expires in 1 hour
    
        // Store token in the database
        $stmt = $this->con->prepare("INSERT INTO cancellation_tokens (token, Appointment_ID, expires_at) VALUES (:token, :appointment_id, :expires_at)");
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':appointment_id', $appointmentId);
        $stmt->bindParam(':expires_at', $expiry);
        $stmt->execute();
    
        return $token;
    }
    
    public function sendCancellationEmail($email, $name, $token) {
        $subject = "Appointment Cancellation Request";
        $body = "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Appointment Cancellation Link</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        line-height: 1.6;
                        background-color: #f4f4f4;
                        padding: 20px;
                    }
                    .container {
                        max-width: 600px;
                        margin: auto;
                        background: #fff;
                        padding: 20px;
                        border-radius: 5px;
                        box-shadow: 0 0 10px rgba(0,0,0,0.1);
                    }
                    p {
                        margin-bottom: 15px;
                    }
                    .button {
                        display: inline-block;
                        padding: 10px 20px;
                        margin: 10px;
                        background-color: #4CAF50;
                        color: white;
                        text-decoration: none;
                        border-radius: 5px;
                    }
                    .text-center {
                        text-align: center;
                    }
                </style>
            </head>
            <body>
                <div class='container text-center'>
                    <h2 style='text-align: center; color: #333;'>Appointment Cancellation Link</h2>
                    <p>Hello {$name},</p>
                    <p>To cancel your appointment, please click the link below:</p>
                    <p class='text-center'>
                        <a href='" . PUBLIC_API . "/cancelAppointment.php?token={$token}' class='button'>Cancel Appointment</a>
                    </p>
                    <p>If you did not request this cancellation, please ignore this message.</p>
                    <p>Best regards,<br>Dentacino</p>
                </div>
            </body>
            </html>
        ";
    
        // Plain text version for email clients that do not support HTML
        $text = "
            Hello {$name},
    
            To cancel your appointment, please click the following link:
            " . PUBLIC_API . "/cancelAppointment.php?token={$token}
    
            If you did not request this cancellation, please ignore this message.
    
            Best regards,
            Dentacino
        ";
    
        $this->init();
        $this->setRecipient($email, $name);
        $this->setContent($subject, $body, $text);
        $this->sendGmail();
    }    

    public function cancelAppointment($token) {
        // Retrieve token information from the database
        $stmt = $this->con->prepare("SELECT * FROM cancellation_tokens WHERE token = :token");
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $tokenData = $stmt->fetch(PDO::FETCH_OBJ);
    
        if ($tokenData) {
            // Token is valid, proceed with cancellation
            $appointmentId = $tokenData->Appointment_ID;
            $cancelStmt = $this->con->prepare("UPDATE appointment SET Appointment_Status = '0' WHERE Appointment_ID = :appointment_id");
            $cancelStmt->bindParam(':appointment_id', $appointmentId);
            $cancelStmt->execute();
    
            // Delete the token after use
            $deleteStmt = $this->con->prepare("DELETE FROM cancellation_tokens WHERE token = :token");
            $deleteStmt->bindParam(':token', $token);
            $deleteStmt->execute();
    
            return true;
        } else {
            // Token is invalid or expired
            return false;
        }
    }    
    
}
