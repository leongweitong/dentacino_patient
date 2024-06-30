<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

Trait SendEmail{
    private $mail = "";

    private function init(){
        $this->mail = new PHPMailer(true);
        // Server settings
        $this->mail->SMTPDebug = 0; // Enable verbose debug output (0 = off)
        $this->mail->isSMTP(); // Set mailer to use SMTP
        $this->mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
        $this->mail->SMTPAuth = true; // Enable SMTP authentication
        $this->mail->Username = 'dentacino@gmail.com'; // Your Gmail address
        $this->mail->Password = 'hgdwddiqxcumbjjf'; // Your Gmail password or app password
        $this->mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
        $this->mail->Port = 587; // TCP port to connect to
    
        // Recipients
        $this->mail->setFrom('dentacino@gmail.com', 'Dentacino'); // Sender's email address and name
    }

    public function setRecipient($recipientEmail, $recipientName){
        $this->mail->addAddress($recipientEmail, $recipientName); // Add a recipient
    }

    public function setContent($subject, $body, $altBody){
        // Content
        $this->mail->isHTML(true); // Set email format to HTML
        $this->mail->Subject = $subject; // Email subject
        $this->mail->Body    = $body; // Email body in HTML
        $this->mail->AltBody = $altBody; // Email body in plain text
    }

    public function sendGmail (){
        try{
            $this->mail->send();
        }
        catch(Exception $e) {
            return $this->mail->ErrorInfo;
        }
    }
}