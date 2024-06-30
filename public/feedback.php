<?php
require_once '../app/Class/Feedback.php';
include ("header.php");
$Feedback = new Feedback();
if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    ?>
    <script>
        window.location = 'home.php';
    </script>
    <?php
}

$Feedback->CheckValidFeedback($id);
?>

<div class="content py-5">
    <div class="container">
        <div class="row align-items-stretch no-gutters contact-wrap p-4 rounded-3 shadow bg-white">
            <div class="col-md-12">
                <div class="form p-4 h-100">
                    <h3 class="text-center fw-bold">Feedback</h3>
                    <form class="mb-2" method="post" id="contactForm" name="contactForm">
                        <input type="hidden" name="ID" id="ID" value="<?php echo $id; ?>">
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label for="title" class="col-form-label text-dark fs-6">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control custom border-0 border-bottom rounded-0 ps-0"
                                    name="title" id="title" placeholder="Title" pattern="[A-Za-z\s]{5,}"
                                    title="The title must have at least 5 characters and only contain alphabets."
                                    maxlength="100" required
                                    style="outline: none; box-shadow: none; border-color: inherit;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label for="rating" class="col-form-label text-dark fs-6">Rating <span class="text-danger">*</span></label>
                                <ul class="rating" data-mdb-toggle="rating">
                                    <li data-value="1">&#9733;</li>
                                    <li data-value="2">&#9733;</li>
                                    <li data-value="3">&#9733;</li>
                                    <li data-value="4">&#9733;</li>
                                    <li data-value="5">&#9733;</li>
                                </ul>
                                <input type="hidden" name="rating" id="ratingValue" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label for="comment" class="col-form-label text-dark fs-6">Comment</label>
                                <textarea class="form-control custom border-0 border-bottom rounded-0 ps-0"
                                    name="comment" id="comment" cols="30" rows="4" placeholder="Write your comment"
                                    style="height:auto;outline: none; box-shadow: none; border-color: inherit;"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3 form-group text-center">
                                <input type="submit" name="submit" value="Submit"
                                    class="btn button3 btn-primary rounded-0 py-2 px-4">
                                <span class="submitting"></span>
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
    $title = $_POST["title"];
    $rating = $_POST["rating"];
    $comment = $_POST["comment"];
    $id = $_POST["ID"];
    ?>
    <?php
    $Feedback->InsertFeedback($title, $rating, $comment, $id);
}
?>
<style>
    .rating {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .rating li {
        display: inline-block;
        cursor: pointer;
        font-size: 2rem;
        color: #ccc;
        transition: color 0.2s;
    }

    .rating li.selected {
        color: gold;
    }

    .rating li.hover {
        color: gold;
    }
</style>
<script src="src/js/bootstrap.bundle.min.js"></script>
<script>
    UpdateDocumentTitle("Feedback");

    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('.rating li');

        stars.forEach(star => {
            star.addEventListener('click', function () {
                const ratingValue = this.getAttribute('data-value');

                // Remove selected class from all stars
                stars.forEach(s => {
                    s.classList.remove('selected');
                });

                // Add selected class to the clicked star and all previous stars
                for (let i = 0; i < ratingValue; i++) {
                    stars[i].classList.add('selected');
                }

                // Store the rating value in the hidden input field
                document.getElementById('ratingValue').value = ratingValue;
            });

            star.addEventListener('mouseover', function () {
                // Remove hover class from all stars
                stars.forEach(s => {
                    s.classList.remove('hover');
                });

                // Add hover class to the hovered star and all previous stars
                for (let i = 0; i < this.getAttribute('data-value'); i++) {
                    stars[i].classList.add('hover');
                }
            });

            star.addEventListener('mouseout', function () {
                // Remove hover class from all stars
                stars.forEach(s => {
                    s.classList.remove('hover');
                });

                // Add selected class back to the selected stars
                const ratingValue = document.getElementById('ratingValue').value;
                for (let i = 0; i < ratingValue; i++) {
                    stars[i].classList.add('selected');
                }
            });
        });
        const form = document.getElementById('contactForm'); // Get the form element

        stars.forEach(star => {
            star.addEventListener('click', function () {
                const ratingValue = this.getAttribute('data-value');
                document.getElementById('ratingValue').value = ratingValue; // Set the rating value in the hidden input field
            });
        });

        // Form submission validation
        form.addEventListener('submit', function (event) {
            const ratingInput = document.getElementById('ratingValue').value;
            if (!ratingInput) {
                event.preventDefault();
                Swal.fire({
                    title: "Please provide a rating.",
                    icon: "error"
                });
            }
        });
    });
</script>
<?php include ("footer.php"); ?>