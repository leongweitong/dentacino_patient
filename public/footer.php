</main>
<!-- main section end  -->

<footer class="site-footer section-padding" id="contact" style="background: #F9F9F9;">
    <div class="container">
        <div class="row">

            <div class="col-lg-5 me-auto col-12">
                <h5 class="mb-lg-4 mb-3">Opening Hours</h5>

                <ul class="list-group list-group-flush">
                    <?php 
                    $operatestart = date("g:i A", strtotime($opendata->start_time));
                    $operateend = date("g:i A", strtotime($opendata->end_time));
                    ?>
                    <li class="list-group-item bg-transparent text-muted py-3 d-flex" style="font-size: 18px; ">
                        Monday - Friday
                        <span class="fw-semibold" style="margin-left: auto;"><?php echo "$operatestart - $operateend"; ?></span>
                    </li>

                    <li class="list-group-item bg-transparent text-muted py-3 d-flex" style="font-size: 18px; ">
                        Lunch Time
                        <span class="fw-semibold" style="margin-left: auto;">
                        <?php 
                            $lunchstart = date("g:i A", strtotime($lunchdata->start_time));
                            $lunchend = date("g:i A", strtotime($lunchdata->end_time));
                            echo "$lunchstart - $lunchend";
                        ?>
                     </span>
                    </li>

                    <li class="list-group-item bg-transparent text-muted py-3 d-flex ml-auto" style="font-size: 18px; ">
                        Saturday - Sunday
                        <span class="fw-semibold" style="margin-left: auto;">Closed</span>
                    </li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-6 col-12 my-4 my-lg-0">
                <h5 class="mb-lg-4 mb-3">Our Clinic</h5>

                <p><a href="mailto:dentacino@gmail.com" class="text-decoration-none text-reset">dentacino@gmail.com</a><p>

                <p>Jalan Ayer Keroh Lama, 75450 Bukit Beruang, Melaka</p>
            </div>

            <div class="col-lg-3 col-md-6 col-12 ms-auto">
                <h5 class="mb-lg-4 mb-2">Socials</h5>

                <ul class="social-icon">
                    <li><a href="#" class="social-icon-link bi-facebook text-decoration-none text-reset"></a></li>

                    <li><a href="#" class="social-icon-link bi-twitter text-decoration-none text-reset"></a></li>

                    <li><a href="#" class="social-icon-link bi-instagram text-decoration-none text-reset"></a></li>

                    <li><a href="#" class="social-icon-link bi-youtube text-decoration-none text-reset"></a></li>
                </ul>

                <div>
                    <p class="copyright-text" style="font-size: 16px;">Copyright © DENTACINO 2024
                    
                </div>
            </div>

            

        </div>
    </section>
</footer>
</body>
</html>

<link href="src/css/bootstrap.min.css" rel="stylesheet">

<link href="src/css/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

<link href="src/css/owl.carousel.min.css" rel="stylesheet">

<link href="src/css/owl.theme.default.min.css" rel="stylesheet">

<style>
    footer {
        padding: 20px;
        margin-top: auto;
        width: 100%;
    }
    .social-icon {
        margin: 0;
        padding: 0;
    }

    .social-icon li {
    list-style: none;
    display: inline-block;
    vertical-align: top;
    transition: all 0.3s;
    }

    .social-icon:hover li:not(:hover) {
    opacity: 0.65;
    }

    .social-icon-link {
    font-size: 18px; 
    display: inline-block;
    vertical-align: top;
    margin-top: 4px;
    margin-bottom: 4px;
    margin-right: 15px;
    }

    .social-icon-link:hover {
    color: #247cff; 
    }
    a, button {
    touch-action: manipulation;
    transition: all 0.3s;
    }

    a:hover {
    color: #247cff; 
    }

    .list-group-item:first-child {
    padding-top: 0;
    }
</style>

<script src="src/js/jquery.min.js"></script>
<script src="src/js/bootstrap.bundle.min.js"></script>
<script src="src/js/owl.carousel.min.js"></script>
<script src="src/js/scrollspy.min.js"></script>
<script src="src/js/header.js"></script>
<script>
    (function ($) {

        "use strict";

        // REVIEWS CAROUSEL
        $('.reviews-carousel').owlCarousel({
            center: true,
            loop: true,
            nav: true,
            dots: false,
            autoplay: true,
            autoplaySpeed: 300,
            smartSpeed: 500,
            responsive:{
            0:{
                items:1,
            },
            768:{
                items:2,
                margin: 100,
            },
            1280:{
                items:2,
                margin: 100,
            }
            }
        });


        // REVIEWS NAVIGATION
        function ReviewsNavResize(){
        $(".navbar").scrollspy({ offset: -94 });

        var ReviewsOwlItem = $('.reviews-carousel .owl-item').width();

        $('.reviews-carousel .owl-nav').css({'width' : (ReviewsOwlItem) + 'px'});
        }

        $(window).on("resize", ReviewsNavResize);
        $(document).on("ready", ReviewsNavResize);
        
    })(window.jQuery);
</script>
</body>
</html>