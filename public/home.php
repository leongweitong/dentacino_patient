<?php
require_once '../app/Class/Service.php';
require_once '../app/Class/Feedback.php';
require_once '../app/Class/Closure.php';
include ("header.php");

$service = new Service();
$dentaldata = $service->getServiceTypeDetail();
$dentaldata1 = array_slice($dentaldata, 0, 2);
$dentaldata2 = array_slice($dentaldata, 2);

$feedback = new Feedback();
$feedbackdata = $feedback->GetFeedback();

$closureDate = new ClosureDate();
$closuredata = $closureDate->getClosureDateDetails();


?>

<section id="heros" class="d-flex align-items-center">
    <div class="container">
        <h1 class="text-uppercase fw-bold text-dark">Welcome to DENTACINO</h1>
        <h2 class="text-dark mt-2">"Making Smiles Shine Brighter"</h2>
        <a href="<?=PUBLIC_API?>/appointment.php" class="button3 btn-get-started scrollto">Appointment Now !</a>
    </div>
</section>
<section id="why">
    <div class="container custom-container py-4">
        <div class="row">
            <div class="col-md-6 image-container img-fluid">
                <img src="src/image/why.webp" alt="Modern Facilities">
            </div>
            <div class="col-md-6 content-container py-4">
                <h5 class="text-muted">Welcome to DENTACINO</h5>
                <h2>Why Choose us? <br>Our Modern Facilities</h2>
                <p>At Dentacino, we blend expertise with a warm, friendly approach. Our reliable and empathetic
                    communication ensures you feel comfortable and confident in your dental care. Trust us for
                    exceptional, engaging, and professional service every step of the way.</p>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-primary"></i> State-of-the-art dental
                        technology</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-primary"></i> Highly skilled and experienced
                        team</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-primary"></i> Personalized and compassionate
                        care</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-primary"></i> Comfortable and welcoming
                        environment</li>
                </ul>

            </div>
        </div>
    </div>
</section>
<section id="about">
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="section-title mb-4">
                        <h5 class="position-relative d-inline-block text-primary text-uppercase">About Us</h5>
                        <h1 class="display-5 mb-0">Dentacino - Making Smiles Shine Brighter</h1>
                    </div>
                    <h4 class="text-body fst-italic mb-4">At Dentacino, we are dedicated to providing exceptional dental
                        care with a warm, friendly touch.</h4>
                    <p class="mb-4">Our brand voice is warm, friendly, and professional. We communicate expertise and
                        reliability while also being approachable and empathetic. This balance ensures that our patients
                        feel comfortable and confident during every interaction with us. Our team of highly skilled
                        professionals is committed to making your dental care experience both informative and engaging.
                        Our state-of-the-art facilities are designed to meet all your dental needs with the highest
                        standards of quality and care.</p>
                    <div class="row g-3">
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.3s">
                            <h5 class="mb-3"><i class="fa fa-check-circle text-primary me-3"></i>Comprehensive Services
                            </h5>
                            <h5 class="mb-3"><i class="fa fa-check-circle text-primary me-3"></i>Cutting-Edge Technology
                            </h5>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.6s">
                            <h5 class="mb-3"><i class="fa fa-check-circle text-primary me-3"></i>Personalized Care Plans
                            </h5>
                            <h5 class="mb-3"><i class="fa fa-check-circle text-primary me-3"></i>Friendly and
                                Professional Staff</h5>
                        </div>
                    </div>
                    <a href="appointment.php" class="btn button3 btn-primary py-3 px-5 mt-4 wow zoomIn"
                        data-wow-delay="0.6s">Make Appointment</a>
                </div>
                <div class="col-lg-5" style="min-height: 500px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute w-100 h-100 rounded wow zoomIn" data-wow-delay="0.9s"
                            src="src/image/about.webp" style="object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="service">
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row g-5 mb-5">
                <div class="col-lg-5 wow zoomIn" data-wow-delay="0.3s" style="min-height: 400px;">
                    <div class="twentytwenty-container position-relative h-100 rounded overflow-hidden">
                        <img class="position-absolute w-100 h-100" src="src/image/before.webp"
                            style="object-fit: cover;">
                        <img class="position-absolute w-100 h-100" src="src/image/after.webp"
                            style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="section-title mb-5">
                        <h5 class="position-relative d-inline-block text-primary text-uppercase">Our Services</h5>
                        <h1 class="display-5 mb-0">We Offer The Best Quality Dental Services</h1>
                    </div>
                    <div class="row g-5">
                        <?php
                        foreach ($dentaldata1 as $row) {
                            ?>
                            <div class="col-md-6 service-item wow zoomIn" data-wow-delay="0.6s">
                                <div class="rounded-top overflow-hidden">
                                    <img class="img-fluid"
                                        src="<?php echo ADMINIMAGEPATH . '/service/' . $row->ServiceType_Picture; ?>" alt="">
                                </div>
                                <div class="position-relative bg-light rounded-bottom text-center p-4">
                                    <h5 class="m-0"><?php echo $row->ServiceType_Name; ?></h5>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="row g-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="col-lg-12">
                    <div class="row g-5">
                        <?php
                        foreach ($dentaldata2 as $row) {
                            ?>
                            <div class="col-md-3 service-item wow zoomIn" data-wow-delay="0.3s">
                                <div class="rounded-top overflow-hidden">
                                    <img class="img-fluid"
                                        src="<?php echo ADMINIMAGEPATH . '/service/' . $row->ServiceType_Picture; ?>" alt="">
                                </div>
                                <div class="position-relative bg-light rounded-bottom text-center p-4">
                                    <h5 class="m-0"><?php echo $row->ServiceType_Name; ?></h5>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
</section>
<?php
if (!empty($feedbackdata)) {
    ?>
    <section class="section-padding pb-0 mb-5" id="reviews">
        <div class="container">
            <div class="row">

                <div class="col-12">
                    <h2 class="text-center mb-lg-5 mb-4" style="font-size: 36px; font-weight: 700;">Testimonial</h2>

                    <div class="owl-carousel reviews-carousel">

                        <?php
                        foreach ($feedbackdata as $row) {
                            ?>
                            <figure class="reviews-thumb d-flex flex-wrap align-items-center rounded">
                                <div class="reviews-stars">
                                    <?php
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $row->Feedback_Star) {
                                            echo '<i class="bi bi-star-fill"></i>';
                                        } else {
                                            echo '<i class="bi bi-star"></i>';
                                        }
                                    }
                                    ?>
                                </div>
                                <p class="text-primary d-block mt-2 mb-0 w-100">
                                    <strong><?php echo $row->Feedback_Title; ?></strong>
                                </p>

                                <p class="reviews-text w-100"><?php echo $row->Feedback_Comment; ?></p>

                                <i class="bi bi-person-circle" style="font-size: 300%;"></i>

                                <figcaption class="ms-4">
                                    <strong><?php echo $row->Patient_Name; ?></strong>
                                </figcaption>
                            </figure>
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>

    </section>
    <?php
}
?>
<?php
if (!empty($closuredata)) {


    ?>
    <section class="section-padding pb-0 mb-5" id="closure">
        <div class="container">
            <h2 class="text-center mb-lg-5 mb-4" style="font-size: 36px; font-weight: 700;">Closure Date</h2>
            <table class="closuretable table table-bordered text-center">
                <thead>
                    <tr class="table-primary">
                        <th scope="col">DATE</th>
                        <th scope="col">REMARKS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($closuredata as $row) {
                        $date = date("d-m-Y", strtotime($row->Date));
                        ?>
                        <tr>
                            <td><?php echo $date; ?>
                            </td>
                            <td class="text-start"><?php echo $row->ClosureDate_Label; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
    <?php
}
?>

<link href="src/css/bootstrap.min.css" rel="stylesheet">
<link href="src/css/fontawesome-free/css/all.min.css" rel="stylesheet">


<link href="src/css/remixicon/remixicon.css" rel="stylesheet">
<link href="src/css/swiper/swiper-bundle.min.css" rel="stylesheet">

<link href="src/css/owl.carousel.min.css" rel="stylesheet">

<link href="src/css/owl.theme.default.min.css" rel="stylesheet">
<style>
    #heros {
        width: 100%;
        height: 90vh;
        background: url("src/image/hero-bg.webp") top center;
        background-size: cover;
        display: flex;
        align-items: center;
    }

    #heros h1 {
        margin: 0;
        font-size: 48px;
        font-weight: 700;
        line-height: 56px;
        text-transform: uppercase;
        color: #2c4964;
    }

    #heros h2 {
        color: #2c4964;
        margin: 10px 0 0 0;
        font-size: 24px;
    }

    #heros .btn-get-started {
        font-family: "Raleway", sans-serif;
        text-transform: uppercase;
        font-weight: 500;
        font-size: 14px;
        letter-spacing: 1px;
        display: inline-block;
        padding: 12px 35px;
        margin-top: 30px;
        border-radius: 50px;
        transition: 0.5s;
        color: #fff;
        background: #1977cc;
    }

    #heros .btn-get-started:hover {
        background: #3291e6;
    }

    .custom-nav {
        position: absolute;
        width: 100%;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        justify-content: space-between;
    }

    .owl-prev,
    .owl-next {
        background: #333;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    .owl-prev:hover,
    .owl-next:hover {
        background: #555;
    }

    .section-title h5::before {
        position: absolute;
        content: "";
        width: 45px;
        height: 3px;
        right: -55px;
        bottom: 11px;
        background: #06A3DA;
    }

    .section-title h5::after {
        position: absolute;
        content: "";
        width: 15px;
        height: 3px;
        right: -75px;
        bottom: 11px;
        background: #F57E57;
    }

    .twentytwenty-wrapper {
        height: 100%;
    }

    .service-item img,
    .service-item .bg-light,
    .service-item .bg-light h5,
    .team-item .team-text {
        transition: .5s;
    }

    .service-item:hover img {
        transform: scale(1.15);
    }

    .team-item .team-text::after,
    .service-item .bg-light::after {
        position: absolute;
        content: "";
        top: 50%;
        bottom: 0;
        left: 15px;
        right: 15px;
        border-radius: 100px / 15px;
        box-shadow: 0 0 15px rgba(0, 0, 0, .7);
        opacity: 0;
        transition: .5s;
        z-index: -1;
    }

    .team-item:hover .team-text::after,
    .service-item:hover .bg-light::after {
        opacity: 1;
    }

    .custom-container {
        padding: 2rem;
    }

    .image-container img {
        width: 100%;
        height: auto;
    }

    .content-container {
        padding: 2rem;
    }

    .reviews-thumb {
        margin-bottom: 0;
        padding: 32px;
    }

    .reviews-text {
        margin-top: 10px;
        margin-bottom: 25px;
    }

    .reviews-image {
        border-radius: 100px;
        width: 70px !important;
        height: 70px !important;
    }

    .reviews-carousel .owl-item {
        opacity: 0.45;
    }

    .reviews-carousel .owl-item.active.center {
        opacity: 1;
    }

    .reviews-carousel .owl-item.active.center .reviews-thumb {
        background: #000000;
    }

    .reviews-carousel .owl-item.active.center .reviews-thumb,
    .reviews-carousel .owl-item.active.center .reviews-text {
        color: #FFFFFF;
    }

    .reviews-carousel .owl-nav {
        display: flex;
        justify-content: space-between;
        position: absolute;
        margin-left: auto;
        margin-right: auto;
        top: 50%;
        left: 0;
        right: 0;
        transform: translateY(-50%);
        width: 50%;
    }

    .reviews-carousel .owl-nav span {
        width: 35px;
        height: 35px;
        line-height: 35px;
        display: block;
    }

    .reviews-carousel .owl-nav .owl-prev {
        position: relative;
        left: -80px;
    }

    .reviews-carousel .owl-nav .owl-next {
        position: relative;
        right: -80px;
    }

    .reviews-carousel .owl-prev span,
    .reviews-carousel .owl-next span {
        color: transparent;
    }

    .reviews-carousel .owl-prev span::before,
    .reviews-carousel .owl-next span::before {
        font-family: bootstrap-icons;
        display: block;
        font-size: 32px;
        color: #717275;
        width: 35px;
        height: 35px;
    }

    .reviews-carousel .owl-prev span::before {
        content: "\f12f";
    }

    .reviews-carousel .owl-next span::before {
        content: "\f138";
    }

    .closuretable tr {
        line-height: 35px !important;
    }

    .closuretable th {
        background-color: var(--primary) !important;
        color: var(--light) !important;
    }


    @media only screen and (max-width: 768px) {
        .reviews-carousel .owl-nav {
            display: none;
        }
    }
</style>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="src/js/bootstrap.bundle.min.js"></script>
<script src="src/lib/wow/wow.min.js"></script>
<script src="src/lib/easing/easing.min.js"></script>
<script src="src/lib/waypoints/waypoints.min.js"></script>
<script src="src/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="src/lib/tempusdominus/js/moment.min.js"></script>
<script src="src/lib/tempusdominus/js/moment-timezone.min.js"></script>
<script src="src/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="src/lib/twentytwenty/jquery.event.move.js"></script>
<script src="src/lib/twentytwenty/jquery.twentytwenty.js"></script>

<script src="src/js/header.js"></script>

<script>
    UpdateDocumentTitle("Home");

    $(document).ready(function () {
        $(".reviews-carousel").owlCarousel({
            items: 1,
            loop: true,
            nav: true,
            navText: [$('.owl-prev'), $('.owl-next')],
            dots: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            autoWidth: false
        });

        // Function to handle window resize event
        function handleWindowResize() {
            // Get the .owl-nav element
            var owlNav = $('.owl-nav');

            // Check if the window width is less than a certain threshold
            if ($(window).width() < 768) { // Adjust the threshold as needed
                // Remove the inline style if present
                owlNav.css('width', '');
            } else {
                // Add the inline style if not present
                owlNav.css('width', ''); // Or any other desired width
            }
        }

        // Add event listener for window resize
        $(window).on('resize', handleWindowResize);

        // Call the function on page load to handle initial window size
        handleWindowResize();
    });


</script>
<?php include ("footer.php"); ?>