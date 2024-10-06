<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Facilities</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .thumb-holder {
            height: 29vh; /* Adjust height as needed */
            width: 100%;
            overflow: hidden; /* Prevent overflow */
        }

        img.img-fluid.facility-thumbnail {
            width: 100%;
            height: auto; /* Maintain aspect ratio */
            max-height: 100%; /* Ensure it fits within the container */
            object-fit: cover; /* Cover the area without distorting */
            object-position: center;
            transition: transform .3s ease-in;
        }

        .book_facility:hover .facility-thumbnail {
            transform: scale(1.2);
        }
    </style>
</head>

<body>
    <!-- Header-->
    <header class="bg-dark py-5" id="main-header">
        <div class="container h-100 d-flex align-items-center justify-content-center w-100">
            <div class="text-center text-white w-100">
                <h1 class="display-4 fw-bolder">Available Facilities</h1>
            </div>
        </div>
    </header>

    <!-- Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <input type="search" id="search" class="form-control" placeholder="Search Here" aria-label="Search Here" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <span class="input-group-text bg-primary" id="basic-addon2"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-xl-2" id="facility_list">
                        <?php 
                        // Assuming you have a valid database connection in $conn
                        $facilities = $conn->query("SELECT f.*, c.name as category FROM `facility_list` f inner join category_list c on f.category_id = c.id where f.delete_flag = 0  order by f.`facility_code`");
                        while($row= $facilities->fetch_assoc()):
                        ?>
                        <a class="col item text-decoration-none text-dark book_facility" href="./?p=view_facility&id=<?php echo $row['id'] ?>" data-id="<?php echo $row['id'] ?>">
                            <div class="callout callout-primary border-primary rounded-0">
                                <dl>
                                    <dt class="h3">
                                        <center>
                                            <div class="position-relative overflow-hidden thumb-holder">
                                                <img src="<?= validate_image($row['image_path']) ?>" alt="" class="img-fluid facility-thumbnail">
                                            </div>
                                        </center>
                                    </dt>
                                    <dd class="lh-1">
                                        <div class="h4"><?php echo $row['category'] ?></div>
                                        <div><?php echo $row['name'] ?></div>
                                        <div class="clear-fix py-2"></div>
                                        <p class="truncate-3 m-0"><?= strip_tags(html_entity_decode($row['description'])) ?></p>
                                    </dd>
                                </dl>
                            </div>
                        </a>
                        <?php endwhile; ?>
                    </div>
                    <div id="noResult" style="display:none" class="text-center"><b>No Result</b></div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(function () {
            $('#search').on('input', function () {
                var _search = $(this).val().toLowerCase().trim();
                $('#facility_list .item').each(function () {
                    var _text = $(this).text().toLowerCase().trim();
                    _text = _text.replace(/\s+/g, ' ');
                    $(this).toggle(_text.includes(_search));
                });
                $('#noResult').toggle($('#facility_list .item:visible').length === 0);
            });

            $('#facility_list .item').hover(function () {
                $(this).find('.callout').addClass('shadow');
            });

            $(document).scroll(function () {
                $('#topNavBar').removeClass('bg-transparent navbar-light navbar-dark bg-gradient-light');
                if ($(window).scrollTop() === 0) {
                    $('#topNavBar').addClass('navbar-dark bg-transparent text-light');
                } else {
                    $('#topNavBar').addClass('navbar-light bg-gradient-light');
                }
            });
            $(document).trigger('scroll');
        });
    </script>
</body>

</html>
