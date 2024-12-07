<?php
// Redirect user to login if not logged in
session_start();
require_once "includes/conn.php";

if (!isset($_SESSION['logged']) || !($_SESSION['logged'] === true)) {
    header('Location:login.php');
    die();
}

require_once "includes/conn.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sql = "UPDATE `testimonials` SET `FullName`=?, `Job`=?, `Comment`=?, `Published`=?, `image`=? WHERE `id` = ?";

    $stmt = $conn->prepare($sql);

    $FullName = $_POST['FullName'];
    $Comment = $_POST['Comment'];
    $Job = $_POST['Job'];
    $id = $_POST['id'];

    // Published
    $Published = isset($_POST['Published']) ? 1 : 0;

    // Image handling
    $oldImage = $_POST['oldImage'];
    require_once "includes/updateImage.php";

    $stmt->execute([$FullName, $Job, $Comment, $Published, $image_name, $id]);

    echo "done";
}

if (isset($_GET['id'])) {
    $sql = "SELECT * FROM `testimonials` WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $id = $_GET['id'];
    $stmt->execute([$id]);

    $testimonial = $stmt->fetch();

    if ($testimonial === false) {
        header('Location: testimonials.php');
        die();
    }

} else {
    header('Location: testimonials.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/main.min.css" />
    <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
    <main>
        <?php require_once "includes/nav.php"; ?>

        <div class="container my-5">
            <div class="bg-light p-5 rounded">
                <h2 class="fw-bold fs-2 mb-5 pb-2">Edit Testimonial</h2>
                <form action="" method="POST" enctype="multipart/form-data" class="px-md-5">
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <input type="hidden" name="oldImage" value="<?php echo $testimonial['image'] ?>">
                    <div class="form-group mb-3 row">
                        <label for="FullName" class="form-label col-md-2 fw-bold text-md-end">Fullname:</label>
                        <div class="col-md-10">
                            <input name="FullName" value="<?php echo $testimonial['FullName']; ?>" type="text" placeholder="e.g. John Doe" class="form-control py-2" />
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label for="Job" class="form-label col-md-2 fw-bold text-md-end">Job Title:</label>
                        <div class="col-md-10">
                            <input name="Job" value="<?php echo $testimonial['Job']; ?>" type="text" placeholder="e.g. Content Creator" class="form-control py-2" />
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label for="Comment" class="form-label col-md-2 fw-bold text-md-end">Comment:</label>
                        <div class="col-md-10">
                            <textarea name="Comment" cols="30" rows="5" class="form-control py-2"><?php echo trim($testimonial['Comment']); ?></textarea>
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label for="Published" class="form-label col-md-2 fw-bold text-md-end">Published:</label>
                        <div class="col-md-10">
                            <input name="Published" type="checkbox" class="form-check-input" style="padding: 0.7rem" <?php echo ($testimonial['Published'] == 1) ? "checked" : ""; ?> />
                        </div>
                    </div>
                    <hr />
                    <div class="form-group mb-3 row">
                        <label for="image" class="form-label col-md-2 fw-bold text-md-end">Image:</label>
                        <div class="col-md-10">
                            <input type="file" class="form-control" style="padding: 0.7rem" name="image" />
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-md-10">
                            <img src="../img/<?php echo $testimonial['image']; ?>" style="max-width: 150px" alt="">
                        </div>
                    </div>
                    <div class="text-md-end">
                        <button class="btn mt-4 btn-secondary text-white fs-5 fw-bold border-0 py-2 px-md-5">Update Testimonial</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
