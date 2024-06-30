<?php

include("header.php"); 
require_once '../app/Class/Appointment.php';
$appointment = new Appointment();

if (isset($_GET['appointment'])) {
    $id = $_GET['appointment'];

    $appointment = $appointment->confirmAppointment($id);
} 

?>

<?php if (isset($appointment) && $appointment): ?>
    
    <div class="container my-4 px-4 shadow bg-body rounded">
        <div class="row">
            <div class="col fw-bold fs-4 p-3">
                <?php echo $appointment->confirmed? 'Your appointment has been confirmed. Here is your Appointment Details' : 'Appointment Details'?>
            </div>
        </div>
        <div class="row">
            <div class="col p-3">
                Appointment ID
            </div>
            <div class="col p-3">
                <?=$appointment->Appointment_ID?>
            </div>
        </div>
        <div class="row">
            <div class="col p-3">
                Patient Name
            </div>
            <div class="col p-3">
                <?=$appointment->Patient_Name?>
            </div>
        </div>
        <div class="row">
            <div class="col p-3">
                Patient Email
            </div>
            <div class="col p-3">
                <?=$appointment->Patient_Email?>
            </div>
        </div>
        <div class="row">
            <div class="col p-3">
                Patient Contact
            </div>
            <div class="col p-3">
                <?=$appointment->Patient_Contact?>
            </div>
        </div>
        <div class="row">
            <div class="col p-3">
                Appointment Date
            </div>
            <div class="col p-3">
                <?=$appointment->Appointment_Date?>
            </div>
        </div>
        <div class="row">
            <div class="col p-3">
                Appointment Time
            </div>
            <div class="col p-3">
                <?=$appointment->Start_Time . ' - ' . $appointment->End_Time?>
            </div>
        </div>
        <div class="row">
            <div class="col p-3">
                Service
            </div>
            <div class="col p-3">
                <?=$appointment->ServiceType_Name?>
            </div>
        </div>
    </div>
<?php else: ?>
    <script>window.location.href = 'home.php';</script>
<?php endif; ?>

<?php include("footer.php"); ?>

<script>
    UpdateDocumentTitle("Confirm Appointment");
</script>