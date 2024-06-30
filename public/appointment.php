<?php
include("header.php"); 
require_once '../app/Class/Appointment.php';
$appointment = new Appointment();
?>

<div class="my-4 px-4">
    <div class="d-flex justify-content-center">
        <div id="calendar-container" class="d-flex flex-column flex-md-row justify-content-center shadow bg-body rounded">
            <div id="calendar-section-1" class="border-end fb-40">
                <div class="fs-5 m-4 text-muted">Dentacino Systems</div>
                <div class="fw-bold fs-4 m-4">60 Minute Meeting</div>
                <div class="m-4">
                    <i class="far fa-clock"></i> 60 Minute
                </div>
            </div>
            <div id="calendar-section-2" class="fb-60">
                <div class="fs-5 p-4 fw-bold">Select a Date & Time</div>
                <div id="calendar" class="w-100 p-4"></div>
            </div>
            <div id="calendar-section-3" class="d-flex flex-column fb-25 d-none">
                <div class="spinner-container d-flex justify-content-center align-items-center h-100">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    UpdateDocumentTitle("Appointment");

    const tomorrowDate = new Date();
    const afterOneYearDate = new Date();

    tomorrowDate.setDate(tomorrowDate.getDate() + 1)
    const minDate = tomorrowDate.toISOString().split('T')[0]
    console.log(tomorrowDate, minDate);

    afterOneYearDate.setDate(afterOneYearDate.getDate() + 360)
    const maxDate = afterOneYearDate.toISOString().split('T')[0]

    const calendarContainer = document.querySelector('#calendar-container');
    const calendarSectionOne = document.querySelector('#calendar-section-1')
    const calendarSectionTwo = document.querySelector('#calendar-section-2')
    const calendarSectionThree = document.querySelector('#calendar-section-3')

    const showSpinner = function() {
        calendarSectionThree.classList.remove('d-none');
        calendarSectionThree.innerHTML = `
            <div class="spinner-container d-flex justify-content-center align-items-center h-100">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;
    };

    const hideSpinner = function() {
        const spinnerContainer = document.querySelector('.spinner-container');
        if (spinnerContainer) {
            spinnerContainer.remove();
        }
    };

    const getTimeSlots = async function (date) {
        showSpinner()
        try {
            const response = await fetch(`<?=SYSTEM_API?>/available_timeslots.php?date=${date}`);
            if (!response.ok) {
                throw new Error('Failed to fetch time slots');
            }
            const timeSlots = await response.json();
            return timeSlots;
        } catch (error) {
            console.error('Error fetching time slots:', error);
            throw error;
        } finally {
            hideSpinner();
        }
    }

    const addTimeSlotSection = function (date, timeSlots) {

        updateTimeSlotButton(date, timeSlots)

        // Adjust widths of existing sections
        calendarSectionOne.classList.remove('fb-40');
        calendarSectionOne.classList.add('fb-25');
        calendarSectionTwo.classList.remove('fb-60');
        calendarSectionTwo.classList.add('fb-50');

        calendarContainer.style.width = '1180px';

        attachRadioEventListeners();
    }

    const updateTimeSlotSection = function (date, timeSlots) {
        updateTimeSlotButton(date, timeSlots)
        attachRadioEventListeners()
    }

    const formatTime = function (timeString) {
        const [hours, minutes] = timeString.split(':');
        const hour = parseInt(hours, 10);
        const suffix = hour >= 12 ? 'pm' : 'am';
        const formattedHour = (hour % 12) || 12;
        return `${formattedHour}:${minutes} ${suffix}`;
    }

    const updateTimeSlotButton = function (date, timeSlots) {
        calendarSectionThree.innerHTML = `
            <div class="fs-5 pt-4 px-4 text-muted">${date}</div>
            <form method="post" class="timeslots-container overflow-auto p-4">
                ${timeSlots.map(time => `
                    <div class="d-flex align-items-center mb-2 gap-2">
                        <input type="radio" class="btn-check" name="operating-hour-${time.Operatinghours_ID}" id="operating-hour-${time.Operatinghours_ID}" value="${time.Operatinghours_ID}" autocomplete="off">
                        <label class="button-outline-1 fb-100" for="operating-hour-${time.Operatinghours_ID}">${formatTime(time.Start_Time)}</label>
                    </div>
                `).join('')}
            </form>
        `;
    }

    const removeTimeSlotSection = function () {
        calendarSectionThree.innerHTML = ""
        calendarSectionThree.classList.add('d-none');
        calendarSectionOne.classList.remove('fb-25');
        calendarSectionOne.classList.add('fb-40');
        calendarSectionTwo.classList.remove('fb-50');
        calendarSectionTwo.classList.add('fb-60');
        calendarContainer.style.width = '850px';
    }

    // Calendar function
    document.addEventListener('DOMContentLoaded', () => {
        const calendar = new VanillaCalendar('#calendar', {
            settings: {
                range: {
                    disablePast: true,
                    disableWeekday: [0, 6],
                    disabled: [<?=$appointment->getClosureDateString()?>],
                },
                selection: {
                    year: true,
                },
                visibility: {
                    weekend: false,
                    today: true,
                    theme: 'light',
                },
            },
            date: {
                min: minDate,
                max: maxDate,
            },
            actions: {
                clickDay(event, self) {
                    if(!self.selectedDates[0]) {
                        removeTimeSlotSection()
                        return 
                    }

                    getTimeSlots(self.selectedDates[0])
                        .then((timeSlots) => {
                            if (document.querySelector('.timeslots-container')) 
                                updateTimeSlotSection(self.selectedDates[0], timeSlots)
                            else
                                addTimeSlotSection(self.selectedDates[0], timeSlots)

                            attachFormSubmitEventListeners(self.selectedDates[0])
                        })
                        .catch((error) => {
                            console.error('Failed to fetch time slots:', error);
                            // Handle the error
                        });
                },
            },
        });
        calendar.init();
    });


    const attachRadioEventListeners = function () {
        const timeslotsContainer = document.querySelector('.timeslots-container');

        timeslotsContainer.addEventListener('click', function (event) {
            if (event.target.classList.contains('btn-check')) {
                // Remove active class and submit button from all labels
                document.querySelectorAll('.button-outline-1').forEach((label) => {
                    label.classList.remove('fb-50');
                    label.classList.add('fb-100');
                    const submitBtn = label.nextElementSibling;
                    if (submitBtn && submitBtn.classList.contains('submit-btn')) {
                        submitBtn.remove();
                    }
                });

                // Add active class to the selected label
                const selectedLabel = document.querySelector(`label[for="${event.target.id}"]`);
                selectedLabel.classList.remove('fb-100');
                selectedLabel.classList.add('fb-50');

                // Create and insert the submit button
                const submitBtn = document.createElement('button');
                submitBtn.type = 'submit';
                submitBtn.className = 'button3 submit-btn fb-50';
                submitBtn.textContent = 'Next';

                selectedLabel.parentNode.insertBefore(submitBtn, selectedLabel.nextSibling);
            }
        });
    };

    const attachFormSubmitEventListeners = function(date) {
        const form = document.querySelector('.timeslots-container')
        form.addEventListener('submit', function(e){
            e.preventDefault()
            const radioButtons = form.querySelectorAll('input[type="radio"]');
            let selectedValue = null;

            radioButtons.forEach(function(radioButton) {
                if (radioButton.checked) {
                    selectedValue = radioButton.value;
                }
            });

            const params = new URLSearchParams({
                date: date,
                operating_hour: selectedValue
            });

            window.location.href = `<?= PUBLIC_API ?>/addAppointment.php?${params.toString()}`;
        })
    }

</script>

<style>
    .timeslots-container::-webkit-scrollbar {
        width: 8px;
    }
    .timeslots-container::-webkit-scrollbar-thumb {
        background: #888; 
        border-radius: 5px; 
    }
    .timeslots-container::-webkit-scrollbar-thumb:hover {
        background: #777; 
    }
    #calendar-container{
        width: 850px; 
        height: 420px;
    }

    @media (max-width: 768px) {
        #calendar-container{
            height: auto;
        }
    }
</style>

<?php
    include("footer.php"); 
?>