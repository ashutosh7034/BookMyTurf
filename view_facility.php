<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT f.*, c.name as category from `facility_list` f inner join category_list c on f.category_id = c.id where f.id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=stripslashes($v);
        }
    }
}

if(isset($_FILES['image'])) {
    $target_dir = "uploads/"; // adjust the upload directory as needed
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<style>
    .facility-img{
        width:100%;
        object-fit:scale-down;
        object-position:center center;
    }
</style>

<section class="py-5">
    <div class="container pt-4">
        <div class="card rounded-0 card-outline card-primary shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <img src="<?= validate_image(isset($image_path) ? $image_path : "") ?>" alt="facility Image <?= isset($name) ? $name : "" ?>" class="img-thumbnail facility-img">
                    </div>
                </div>
                <fieldset>
                    <div class="row">
                        <div class="col-md-12">
                            <small class="mx-2 text-muted">Name</small>
                            <div class="pl-4"><?= isset($name) ? $name : '' ?></div>
                        </div>
                        <div class="col-md-12">
                            <small class="mx-2 text-muted">Description</small>
                            <div class="pl-4"><?= isset($description) ? $description : '' ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <small class="mx-2 text-muted">Price</small>
                            <div class="pl-4"><?= isset($price) ? number_format($price,2) : '' ?></div>
                        </div>
                    </div>
                </fieldset>
                <center>
                    <button class="btn btn-large btn-primary rounded-pill w-25" id="book_now" type="button">Book Now</button>
                </center>
                <div class="row">
                    <div class="col-md-12">
                        <form action="" id="facility-form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="facility-image" class="control-label">Facility Image</label>
                                <input type="file" class="custom-file-input" id="facility-image" name="image">
                                <label class="custom-file-label" for="facility-image">Choose file</label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
  $(function(){
    $('#book_now').click(function(){
        if("<?= $_settings->userdata('id') && $_settings->userdata('login_type') == 2 ?>" == 1)
            uni_modal("Book Facility","booking.php?fid=<?= $id ?>",'modal-sm');
        else
        location.href = './login.php';
    })
  })
</script>