<?php

Class Appointment{
    use Database;
    use SendEmail;

    private $con = "";
    public function __construct() {
        $this->con = $this->connect();
    }

    public function getClosureDateString(){
        $stmt = $this->con->prepare("SELECT Date FROM closure_date");
        $stmt->execute();
        $closureDatesArray = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        $closureDatesString = implode(", ", array_map(function($date) {
            return "'".$date."'";
        }, $closureDatesArray));
        
        return $closureDatesString;
    }

    public function getAppointmentTimeString($date, $operatingHourId) {
        $stmt = $this->con->prepare("SELECT Start_Time, End_Time FROM operating_hours WHERE Operatinghours_ID = :id");
        $stmt->bindParam(':id', $operatingHourId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);

        if ($result) {
            $start_time = $result->Start_Time;
            $end_time = $result->End_Time;

            $start_datetime = new DateTime("$date $start_time");
            $end_datetime = new DateTime("$date $end_time");
    
            $start_time_formatted = $start_datetime->format('g:ia'); // 12-hour format with am/pm
            $end_time_formatted = $end_datetime->format('g:ia'); // 12-hour format with am/pm
    
            $date_formatted = $start_datetime->format('l, F j, Y'); // Full day of the week, full month name, day with leading zero, full year
    
            return "$start_time_formatted - $end_time_formatted, $date_formatted";
        } else {
            return "No matching operating hours found.";
        }
    }    

    public function getAvailableTimeSlots($date) {
        // Fetch available time slots from the operating_hours table
        $stmt = $this->con->prepare("SELECT Operatinghours_ID, Start_Time FROM operating_hours WHERE Operatinghours_Status = '2'");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_OBJ);
    
        // Fetch booked appointments for the given date
        $stmtAppointments = $this->con->prepare("SELECT DISTINCT Operatinghours_ID FROM appointment WHERE Appointment_Status IN ('1', '2', '9') AND Appointment_Date = :date");
        $stmtAppointments->bindParam(':date', $date);
        $stmtAppointments->execute();
        $bookedOperatingIDs = $stmtAppointments->fetchAll(PDO::FETCH_COLUMN);
    
        // Filter out any repeated operating IDs
        $filteredResults = [];
        foreach ($results as $timeSlot) {
            if (!in_array($timeSlot->Operatinghours_ID, $bookedOperatingIDs)) {
                $filteredResults[] = $timeSlot;
            }
        }
    
        return $filteredResults;
    }

    public function makeAppointment($name, $email, $contact, $date, $service_id, $operating_hour_id) {
        try{
            $checkStmt = $this->con->prepare("SELECT * FROM appointment WHERE Appointment_Date = :date AND Operatinghours_ID = :operatingID AND Appointment_Status IN ('1', '2', '9')");
            $checkStmt->bindParam(':date', $date);
            $checkStmt->bindParam(':operatingID', $operating_hour_id);
            $checkStmt->execute();

            if ($checkStmt->rowCount() > 0) {
                return false;
            }

            $id = $this->generateUniqueAppointmentID();
            $stmt = $this->con->prepare("INSERT INTO appointment (Appointment_ID, Patient_Name, Patient_Email, Patient_Contact, Appointment_Date, Appointment_Status, ServiceType_ID, Operatinghours_ID) VALUES (:id, :name, :email, :contact, :date, :status, :service_id, :operating_hour_id)");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':contact', $contact);
            $stmt->bindParam(':date', $date);
            $stmt->bindValue(':status', '9');
            $stmt->bindParam(':service_id', $service_id);
            $stmt->bindParam(':operating_hour_id', $operating_hour_id);
            $stmt->execute();
    
            $this->init();
            $this->setRecipient($email, $name);
    
            $subject = 'Confirmation of Your Appointment Schedule';
            $confirmationLink = PUBLIC_API . '/confirmSchedule.php?appointment=' . $id;
            $body = "
                <!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Confirmation of Your Appointment Schedule</title>
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
                        .btn {
                            display: inline-block;
                            padding: 10px 20px;
                            margin: 10px 0;
                            background-color: #4CAF50;
                            color: white;
                            text-decoration: none;
                            border-radius: 5px;
                        }
                        .btn:hover {
                            background-color: #45a049;
                        }
                        .text-center {
                            text-align: center
                        }
                    </style>
                </head>
                <body>
                    <div class='container text-center'>
                        <h2 style='text-align: center; color: #333;'>Confirmation of Your Appointment Schedule</h2>
                        <p>Hello {$name},</p>
                        <p>We are writing to confirm your appointment schedule with us.</p>
                        <p><strong>Appointment ID:</strong> #{$id}</p>
                        <p>Please click the button below to confirm your schedule:</p>
                        <p style='text-align: center;'>
                            <a href='{$confirmationLink}' class='btn'>Confirm Schedule</a>
                        </p>
                        <p>If you have any questions or need to reschedule, feel free to contact us.</p>
                        <p>Thank you!</p>
                        <p>Best regards,<br>Dentacino</p>
                    </div>
                </body>
                </html>
            ";
            $text = "
                Please click the button below to confirm your schedule:<br><br>
                <a href='{$confirmationLink}'>Confirm Schedule</a>
            ";
            $this->setContent($subject, $body, $text);
            $this->sendGmail();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    public function confirmAppointment($id) {
        $updateStmt = $this->con->prepare("UPDATE appointment SET Appointment_Status = '1' WHERE Appointment_ID = :id AND Appointment_Status = :status");
        $updateStmt->bindParam(':id', $id);
        $updateStmt->bindValue(':status', '9');
        $updateStmt->execute();

        // Fetch updated appointment details
        $appointment = $this->getAppointmentById($id);

        if($updateStmt->rowCount() > 0 && $appointment){
            $this->init();
            $this->setRecipient($appointment->Patient_Email, $appointment->Patient_Name);
            $body = "
                <!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Appointment Confirmation</title>
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
                        .appointment-details {
                            margin-top: 20px;
                            background-color: #f9f9f9;
                            padding: 10px;
                            border-radius: 5px;
                        }
                        .text-center {
                            text-align: center
                        }
                    </style>
                </head>
                <body>
                    <div class='container text-center'>
                        <h2 style='text-align: center; color: #333;'>Appointment Confirmed</h2>
                        <p>Hello {$appointment->Patient_Name},</p>
                        <p>Your appointment has been successfully scheduled.</p>
                        <div class='appointment-details'>
                            <p><strong>Appointment ID:</strong> {$id}</p>
                            <p><strong>Date:</strong> {$appointment->Appointment_Date}</p>
                            <p><strong>Time:</strong> {$appointment->Start_Time} - {$appointment->End_Time}</p>
                            <p><strong>Service:</strong> {$appointment->ServiceType_Name}</p>
                        </div>
                        <p>Thank you for choosing our services. We look forward to seeing you!</p>
                        <p>Best regards,<br>Dentacino</p>
                    </div>
                </body>
                </html>
            ";
            $text = "You have scheduled your event. Your appointment ID is {$id}. Here are your scheduled detail. <br>
                You will meet our team at {$appointment->Start_Time} - {$appointment->End_Time} for {$appointment->ServiceType_Name} <br>
                Thank you for your trust in us.";
            $this->setContent('Successfully Scheduled an Event', $body, $body);
            $this->sendGmail();

            $appointment->confirmed = true;
        } 
        else if($appointment)
            $appointment->confirmed = false;

        return $appointment;
    }
    
    public function getAppointmentByEmail($email) {
        $stmt = $this->con->prepare("SELECT 
                a.*,
                s.ServiceType_Name,
                o.Start_Time,
                o.End_Time
            FROM appointment a
            JOIN service_type s ON a.ServiceType_ID = s.ServiceType_ID
            JOIN operating_hours o ON a.Operatinghours_ID = o.Operatinghours_ID
            WHERE Patient_Email = :email"
        );

        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getAppointmentById($id) {
        $stmt = $this->con->prepare("
            SELECT 
                a.*,
                s.ServiceType_Name,
                o.Start_Time,
                o.End_Time
            FROM 
                appointment a
            JOIN 
                service_type s ON a.ServiceType_ID = s.ServiceType_ID
            JOIN 
                operating_hours o ON a.Operatinghours_ID = o.Operatinghours_ID
            WHERE 
                a.Appointment_ID = :id
        ");

        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function generateUniqueAppointmentID() {
        $prefix = 'A';
        $uniqueID = '';
        
        do {
            $randomString = $this->generateRandomString(10);
            $uniqueID = $prefix . $randomString;
            
            $stmt = $this->con->prepare("SELECT COUNT(*) FROM appointment WHERE Appointment_ID = :appointment_id");
            $stmt->bindValue(':appointment_id', $uniqueID);
            $stmt->execute();
            $count = $stmt->fetchColumn();
        } while ($count > 0);
        
        return $uniqueID;
    }
    
    public function generateRandomString($length) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
}
