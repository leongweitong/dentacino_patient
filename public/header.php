<?php
require_once ("index.php");
require_once '../app/Class/Operatinghours.php';

$operating = new Operatinghours();
$opendata = $operating->getoperatinghours();
$lunchdata = $operating->getlunchtime();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?=IMAGEPATH?>/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=IMAGEPATH?>/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=IMAGEPATH?>/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?=IMAGEPATH?>/favicon/site.webmanifest">
    <link rel="mask-icon" href="<?=IMAGEPATH?>/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- Calendar Lib -->
    <link href="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro/build/vanilla-calendar.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro/build/vanilla-calendar.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css"
        integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?=BOOTSTRAP_CSS_PATH?>/bootstrap.min.css" rel="stylesheet">
    <script defer src="<?=BOOTSTRAP_JS_PATH?>/bootstrap.min.js"></script>
    <link href="<?=BOOTSTRAP_ICON_PATH?>/bootstrap-icons.css" rel="stylesheet">
    <link href="src/css/style.css" rel="stylesheet">

    <style>
        .navbar-light .navbar-nav .nav-link {
            padding: 35px 15px;
            font-size: 18px;
            color: #091E3E;
            outline: none;
            transition: .5s;
        }

        .sticky-top.navbar-light .navbar-nav .nav-link {
            padding: 20px 15px;
        }

        .navbar-light .container .navbar-nav .nav-link:hover {
            color: #06A3DA;
        }
    </style>

</head>

<body style="background-color: white;">

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm px-5 py-3 py-lg-0">
        <div class="container">
            <a href="home.php" class="navbar-brand p-0">
                <h1 class="m-0 text-primary">
                    <img width="400" src="src/logo/logo2.jpg" title="Home">
                </h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarCollapse">
                <div class="navbar-nav py-0">
                    <a href="home.php" class="nav-item nav-link text-center">Home</a>
                    <a href="<?= PUBLIC_API ?>/home.php#about" class="nav-item nav-link text-center">About Us</a>
                    <a href="<?= PUBLIC_API ?>/home.php#service" class="nav-item nav-link text-center">Services</a>
                    <a href="<?= PUBLIC_API ?>/appointment.php" class="nav-item nav-link text-center">Appointment</a>
                    <a href="<?= PUBLIC_API ?>/trackAppointment.php" class="nav-item nav-link text-center">Appointment
                        Track</a>
                    <a href="<?= PUBLIC_API ?>/contactus.php" class="btnheader button3 btn btn-primary ms-3 text-center"
                        style="height: auto; padding-top: 0.375rem; padding-bottom: 0.375rem; align-self: center;">Contact
                        Us</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const offset = document.querySelector('nav').offsetHeight;

            function smoothScroll(targetId) {
                const targetElement = document.getElementById(targetId);
                if (targetElement) {
                    const offsetPosition = targetElement.offsetTop - offset;
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: "smooth"
                    });
                }
            }

            function handleLinkClick(event) {
                const href = this.getAttribute('href');
                const url = new URL(href, window.location.href);

                if (url.origin === window.location.origin) {
                    if (url.pathname === window.location.pathname) {
                        // Same page
                        event.preventDefault();
                        smoothScroll(url.hash.substring(1));
                    } else {
                        // Different page
                        event.preventDefault();
                        window.location.href = url.href;
                    }
                }
            }

            // Handle initial load with hash (different page navigation)
            if (window.location.hash) {
                setTimeout(() => {
                    smoothScroll(window.location.hash.substring(1));
                }, 100); // Slight delay to ensure the DOM is fully loaded
            }

            // Add event listeners to links
            const links = document.querySelectorAll('a[href^="#"], a[href*="#"]');
            links.forEach(link => {
                link.addEventListener('click', handleLinkClick);
            });

            // Listen for popstate event to handle back/forward navigation
            window.addEventListener('popstate', function () {
                if (window.location.hash) {
                    smoothScroll(window.location.hash.substring(1));
                }
            });
        });
    </script>