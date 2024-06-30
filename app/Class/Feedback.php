<?php
require_once "../app/Database.php";

Class Feedback{
    use Database;
    private $con="";
    public function __construct(){
        $this->con = $this->connect(); 
    }
    function InsertFeedback($title, $star, $comment, $id){
        ?>
        <?php
        if($comment==""){
            $stmt = $this->con->prepare("INSERT INTO feedback (Feedback_Title, Feedback_Star, Feedback_Status, Appointment_ID) 
            VALUES (:title, :star, :status, :id)");
            $status="0";
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':star', $star);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);

        } else {
            $stmt = $this->con->prepare("INSERT INTO feedback (Feedback_Title, Feedback_Star, Feedback_Comment, Feedback_Status, Appointment_ID) 
            VALUES (:title, :star, :comment, :status, :id)");
            $status="0";
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':star', $star);
            $stmt->bindParam(':comment', $comment);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);
        }
        
        if ($stmt->execute()) {
            ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: "Submit Successfully",
                        text: "Thank you for your feedback.",
                        icon: "success"
                    }).then(function() {
                        window.location = 'home.php';
                    });
                });
            </script>
            <?php
        } else {
            ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: "Submit Unsuccessful",
                        text: "Please contact the administrator.",
                        icon: "error"
                    }).then(function() {
                        window.location = 'home.php';
                    });
                });
            </script>
            <?php
        }
        ob_end_flush();
    
    }

    function CheckValidFeedback($id){
        $checkvalid = "SELECT * FROM appointment where Appointment_ID = :id AND Appointment_Status != '2'";
        $stmt = $this->con->prepare($checkvalid);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $rowcounts = $stmt->rowCount();

        if ($rowcounts != 0) {
            ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: "The form cannot be filled out",
                        text: "The appointment is not completed yet. Please complete the appointment before providing feedback.",
                        icon: "error"
                    }).then(function() {
                        window.location = 'home.php';
                    });
                });
            </script>
            <?php
        }

        $checkvalid = "SELECT * FROM appointment where Appointment_ID = :id";
        $stmt = $this->con->prepare($checkvalid);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $rowcounts = $stmt->rowCount();

        if ($rowcounts == 0) {
            ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: "Invalid Appointment",
                        text: "The provided appointment is not valid. Feedback form cannot be filled out.",
                        icon: "error"
                    }).then(function() {
                        window.location = 'home.php';
                    });
                });
            </script>
            <?php
        }
        
        $checkexisting = "SELECT * FROM feedback where Appointment_ID = :id";
        $stmt = $this->con->prepare($checkexisting);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $rowcount = $stmt->rowCount();
        
        if ($rowcount != 0) { 
            // Alert Feedback already exists
            ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: "Form Already Submitted",
                        text: "The feedback form for this appointment has already been filled out and cannot be submitted again.",
                        icon: "error"
                    }).then(function() {
                        window.location = 'home.php';
                    });
                });
            </script>
            <?php
        } 
    }

    function GetFeedback(){
        $sql = "SELECT appointment.Patient_Name, feedback.Feedback_Title, feedback.Feedback_Star, feedback.Feedback_Comment
                FROM feedback
                INNER JOIN appointment ON feedback.Appointment_ID=appointment.Appointment_ID
                WHERE feedback.Feedback_Status='1';";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $result;
    }
}
?>