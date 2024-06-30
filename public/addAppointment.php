<?php
include("header.php"); 
require_once '../app/Class/Appointment.php';
require_once '../app/Class/Service.php';
$service = new Service();
$appointment = new Appointment();
?>

<div class="spinner-overlay d-none">
    <div class="spinner-container">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>

<div class="my-4 px-4">
    <div class="d-flex justify-content-center">
        <div id="calendar-container" class="d-flex flex-column flex-md-row justify-content-center shadow bg-body rounded">
            <div id="calendar-section-1" class="border-end fb-40">
                <div class="fs-5 m-4 text-muted">Dentacino Systems</div>
                <div class="fw-bold fs-4 m-4">60 Minute Meeting</div>
                <div class="mx-4 mb-2">
                    <i class="far fa-calendar-alt"></i> <?=$appointment->getAppointmentTimeString($_GET['date'], $_GET['operating_hour'])?>
                </div>
                <div class="mx-4 mb-2">
                    <i class="far fa-clock"></i> 60 Minute With Our Professiaol Team
                </div>
            </div>
            <div id="calendar-section-2" class="fb-60">
                <div class="fs-5 p-4 fw-bold">Make an Appointment</div>
                <form method="POST" class="px-4 pb-4">
                    <div class="mb-3">
                        <div class="form-label">Service Type</div>
                        <select class="form-select" id="service" name="service" required>
                            <option value="" selected disabled>Please select your service</option>
                            <?php foreach ($service->getServiceTypeDetail() as $s): ?>
                                <option value="<?= htmlspecialchars($s->ServiceType_ID) ?>"><?= htmlspecialchars($s->ServiceType_Name) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Patient Name</label>
                        <input type="text" class="form-control" id="name" name="name" pattern="[A-Za-z\s]{2,}" 
                            title="Name should contain only letters and spaces, with a minimum length of 2 characters." 
                            placeholder="John Doe" required
                        >
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="john@gmail.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="contact" class="form-label">Contact Number</label>
                        <input type="tel" class="form-control" id="contact" name="contact" pattern="[0-9]{3}-[0-9]{3}[0-9]{4,5}" 
                            title="Contact number must be 10 or 11 digits and start with a 0. XXX-XXXXXXXX" placeholder="011-2334679" required
                        >
                    </div>

                    <button type="submit" class="button3 w-100">Schedule Event</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    UpdateDocumentTitle("Make an Appointment");

    const spinnerOverlay = document.querySelector('.spinner-overlay')
    const name = document.querySelector('#name')
    const email = document.querySelector('#email')
    const contact = document.querySelector('#contact')
    const service = document.querySelector('#service')

    function getUrlParams() {
        const params = new URLSearchParams(window.location.search);
        const date = params.get('date');
        const operatingHour = params.get('operating_hour');

        return { date, operatingHour };
    }

    const { date, operatingHour } = getUrlParams();

    if(!date || !operatingHour) window.location.href = 'appointment.php';

    const addAppointment = async function (data) {
        try {
            const response = await fetch(`<?=SYSTEM_API?>/add_appointment.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json; charset=UTF-8'
                },
                body: JSON.stringify(data),
            });
            if (!response.ok) {
                throw new Error('Failed to add appointment');
            }
            const result = await response.json();
            return result;
        } catch (error) {
            console.error('Error add appointment:', error);
            throw error;
        }
    }

    document.querySelector('form').addEventListener('submit', function(e){
        e.preventDefault();

        const data = {
            "name": name.value,
            "email": email.value,
            "contact": contact.value,
            "service": Number(service.value),
            "date": date,
            "operatingHour": Number(operatingHour)
        }

        console.log(data);

        spinnerOverlay.classList.remove('d-none');
        
        addAppointment(data)
            .then(result => {
                console.log(result);
                spinnerOverlay.classList.add('d-none');
                if (result.success) {
                    Swal.fire({
                        title: "Appointment Scheduled",
                        html: "Please check your <a href='https://mail.google.com/' target='_blank'>Gmail</a> to confirm your appointment.",
                        icon: "success",
                        confirmButtonText: "OK"

                    }).then(() => {
                        window.location.href = 'appointment.php';
                    });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: result.message,
                        icon: "error",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = 'appointment.php';
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: "Error",
                    text: result.message,
                    icon: "error",
                    confirmButtonText: "OK"
                });
            });
    })

    document.addEventListener("DOMContentLoaded", function() {
        // Select all the required input fields
        const requiredFields = document.querySelectorAll('input[required], select[required], textarea[required]');

        // Loop through each required field and add a red asterisk to the label
        requiredFields.forEach(field => {
            const label = field.closest('.mb-3').querySelector('.form-label');
            if (label) {
                const asterisk = document.createElement('span');
                asterisk.classList.add('text-danger');
                asterisk.textContent = ' *';
                label.appendChild(asterisk);
            }
        });
    });
    
</script>

<style>
    #calendar-container{
        width: 1000px; 
        height: auto;
    }
</style>

<?php
    include("footer.php");
?>