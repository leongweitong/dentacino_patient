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
        <div class="m-4" style="width: 500px;">
            <form id="search-form">
                <div class="input-group">
                    <input type="text" id="search-value" class="form-control p-3" placeholder="Appointment Id / Email" required>
                    <button class="btn btn-primary text-white" type="submit">
                        <i class="fas fa-search mr-2"></i>
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="appointment-table" class="container mb-4 pb-4" style="min-height: 200px;"></div>

<script>

    UpdateDocumentTitle("Track an Appointment");

    const spinnerOverlay = document.querySelector('.spinner-overlay')
    const appointmentTable = document.querySelector('#appointment-table')

    const updateSearchResult = function(results) {
        if (!Array.isArray(results))  results = [results];

        const resultRows = results.map((appointment, index) => {
            let statusText = '';
            switch (appointment.Appointment_Status) {
                case "0":
                    statusText = "Cancelled";
                    break;
                case "1":
                    statusText = "Pending";
                    break;
                case "2":
                    statusText = "Completed";
                    break;
                case "9":
                    statusText = "Verified";
                    break;
            }
            
            return `
                <tr>
                    <td>${index + 1}.</td>
                    <td class="text-center">
                        <p class="my-1">${appointment.Appointment_ID}</p>
                    </td>
                    <td class="text-center">
                        <p class="my-1">${appointment.Patient_Name}
                            <span class="text-muted">
                                (${appointment.Patient_Contact})
                            </span>
                        </p>
                        <p class="text-muted mb-0 text-center">${appointment.Patient_Email}</p>
                    </td>
                    <td class="text-center">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="ms-3">
                                <p class="mb-0">${appointment.Appointment_Date}</p>
                                <p class="mb-0">${appointment.Start_Time} - ${appointment.End_Time}</p>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <p class="my-1">${appointment.ServiceType_Name}</p>
                    </td>
                    <td class="text-center">
                        <div class="d-flex align-items-center justify-content-center">
                            ${appointment.Appointment_Status !== '1' && appointment.Appointment_Status !== '9' ? 
                                `<span>${statusText}</span>` 
                                : 
                                `<button class="button2" onclick="requestCancel('${appointment.Appointment_ID}', '${appointment.Patient_Email}', '${appointment.Patient_Name}')">Cancel</button>`
                            }
                        </div>
                    </td>
                </tr>
            `;
        }).join('');

        const tableHTML = `
            <div class="card-body shadow rounded table-responsive">
                <table class="table table-borderless align-middle mb-0" width="100%">
                    <tbody>
                        ${resultRows}
                    </tbody>
                </table>
            </div>
        `;

        appointmentTable.innerHTML = tableHTML;
    };

    const getSearchAppointment = async function (value, type) {
        try {
            const response = await fetch(`<?=SYSTEM_API?>/search_appointments.php?${type}=${value}`);
            if (!response.ok) {
                throw new Error('Failed to fetch appointment');
            }
            const results = await response.json();
            return results;
        } catch (error) {
            console.error('Error fetching appointment:', error);
            throw error;
        }
    }

    const sendCancellationRequest = async function(id, email, name) {
        try {
            const response = await fetch(`<?=SYSTEM_API?>/request_cancel_appointment.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({id, email, name})
            });

            if (!response.ok) {
                throw new Error('Failed to request cancellation');
            }

            const result = await response.json();
            return result;
        } catch (error) {
            console.error('Error add cancel appointment:', error);
            throw error;
        }
    }

    const requestCancel = async function(id, email, name) {
        console.log({id, email, name});
        try {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: false,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, cancel it!"
            }) 
            .then((res) => {
                if(!res.isConfirmed) return 

                spinnerOverlay.classList.remove('d-none');
                sendCancellationRequest(id, email, name)
                    .then(result => {
                        spinnerOverlay.classList.add('d-none');
                        if (result.success) {
                            Swal.fire({
                                title: "Cancel Appointment",
                                html: "Please check your <a href='https://mail.google.com/' target='_blank'>Gmail</a> to cancel your appointment.",
                                icon: "success",
                                confirmButtonText: "OK"

                            }).then(() => {
                                window.location.href = 'trackAppointment.php';
                            });
                        } else {
                            Swal.fire({
                                title: "Failed to request cancellation",
                                text: result.message,
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        }
                    }) .catch(error => {
                        throw error;
                    })
            })
            
        } catch (error) {
            console.error('Error requesting cancellation:', error);
        }
    };

    const searchValue = document.querySelector('#search-value')
    const searchForm = document.querySelector('#search-form')

    searchForm.addEventListener('submit', function(e){
        e.preventDefault()
    
        const value = searchValue.value.trim();

        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        let type = 'id';
        if (emailPattern.test(value)) {
            type = 'email';
        }

        if(!value) return

        spinnerOverlay.classList.remove('d-none');
        getSearchAppointment(value, type)
            .then (results => {
                console.log(results);
                spinnerOverlay.classList.add('d-none');
                if (results.success && results.type === 'email') {
                    console.log('email');
                    console.log('Appointment Details:', results.data);
                    updateSearchResult(results.data)
                } 
                else if (results.success && results.type === 'id') {
                    console.log('Appointment Details:', results.data);
                    updateSearchResult(results.data)
                } 
                else {
                    appointmentTable.innerHTML = '<div class="text-center shadow rounded p-3">No Record</div>'
                }
            })
            .catch(err => {
                console.error(err);
            })
    })
    

</script>

<style>

</style>

<?php
    include("footer.php"); 
?>