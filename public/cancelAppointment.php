<?php

include("header.php"); 
require_once '../app/Class/CancellationToken.php';
$cancelToken = new CancellationToken();

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $result = $cancelToken->cancelAppointment($token);
} 

?>

<?php if (isset($token) && $result): ?>
    <div class="d-flex justify-content-center align-items-center text-center my-4" style="min-height: 350px;">
        Your Appointment have been cancelled.
    </div>
<?php else: ?>
    <div class="my-4 px-4">
        <div class="d-flex justify-content-center align-items-center text-center my-4" style="min-height: 350px;">
            <div>
                <h1 class="display-4">404</h1>
                <p class="lead">Oops! Page not found.</p>
                <p>Sorry, the content you are looking for could not be found.</p>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php include("footer.php"); ?>

<script>
    UpdateDocumentTitle("Cancel Appointment");
</script>