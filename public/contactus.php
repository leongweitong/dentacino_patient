
<?php
require_once '../app/Class/Inquire.php'; 
include("header.php"); 
?>
    
<div class="content py-5">
    <div class="container">
        <div class="row align-items-stretch no-gutters contact-wrap p-4 rounded-3 shadow bg-white">
            <div class="col-md-12">
                <div class="form p-4 h-100">
                    <h3 class="text-center fw-bold">Get Touch With Us</h3>
                    <form class="mb-2" method="post" id="contactForm" name="contactForm">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="name" class="col-form-label text-dark fs-6">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control custom border-0 border-bottom rounded-0 ps-0" name="name" id="name" placeholder="John Cena" maxlength="100" pattern="[A-Za-z\s]{5,100}" title="The name must have at least 5 characters and only contain alphabet." required style="outline: none; box-shadow: none; border-color: inherit;">
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="email" class="col-form-label text-dark fs-6">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control custom border-0 border-bottom rounded-0 ps-0" name="email" id="email" maxlength="100" placeholder="John@gmail.com" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" title="Please enter a valid email format" required style="outline: none; box-shadow: none; border-color: inherit;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label for="name" class="col-form-label text-dark fs-6">Contact <span class="text-danger">*</span></label>
                                <input type="text" class="form-control custom border-0 border-bottom rounded-0 ps-0" name="contact" id="contact" maxlength="13" pattern="[0-9]{3}-[0-9]{3}[0-9]{4,5}" placeholder = "012-3456789" required title = "Please enter the correct format, example: 012-3456789" style="outline: none; box-shadow: none; border-color: inherit;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label for="questiontype" class="col-form-label text-dark fs-6">Question Type <span class="text-danger">*</span></label>
                                <select class="form-select custom border-0 border-bottom rounded-0 ps-0" id="questiontype" name="questiontype" required style="outline: none; box-shadow: none; border-color: inherit;">
                                    <option value="" hidden>Choose...</option>
                                    <option value="1">Appointment</option>
                                    <option value="2">Billing</option>
                                    <option value="3">Technical Support</option>
                                    <option value="4">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label for="message" class="col-form-label text-dark fs-6">Message <span class="text-danger">*</span></label>
                                <textarea class="form-control custom border-0 border-bottom rounded-0 ps-0" name="message" id="message" cols="30" rows="4" placeholder="Write your message" style="height:auto;outline: none; box-shadow: none; border-color: inherit;" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3 form-group text-center">
                                <input type="submit" name="submit" value="Send Message" class="btn button3 btn-primary rounded-0 py-2 px-4">
                                <span class="submitting"></span>
                            </div>
                        </div>
                        <p class="text-center mt-1 mb-1">or</p>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <a href="https://wa.me/60138340446?text=I%27m%20interested%20in%20scheduling%20a%20dental%20appointment.%20Can%20you%20please%20provide%20more%20information%3F" class="btn button1 d-inline-flex justify-content-center align-items-center">
                                <i class="bi bi-whatsapp" style="margin-right: 0.5rem;"></i> Whatsapp
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $contact = $_POST["contact"];
    $questiontype = $_POST["questiontype"];
    $message = $_POST["message"];
    $Inquire = new Inquire();
    $Inquire->InsertInquire($name, $email, $contact, $questiontype, $message);
}
?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    UpdateDocumentTitle("Contact Us");
</script>
<?php include("footer.php"); ?>

