<?php
require_once "../app/Database.php";

Class Inquire{
    use Database;
    private $con="";
    public function __construct(){
        $this->con = $this->connect(); 
    }
    function InsertInquire($name, $email, $contact, $type, $message){
        $stmt = $this->con->prepare("INSERT INTO patient_inquiry (Patient_Name, Patient_Email, Patient_Contact, QuestionType, Patient_Message) VALUES (:name, :email, :contact, :type, :message)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':contact', $contact);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':message', $message);

        if ($stmt->execute()) {
            ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: "Submit Successfully",
                        text: "Thank you for contacting us, we will reply as soon as possible.",
                        icon: "success"
                    }).then(function() {
                        window.location = 'contactus.php';
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
                            window.location = 'contactus.php';
                        });
                    });
                </script>
                <?php
        }
        ob_end_flush();
        
    }
}
?>