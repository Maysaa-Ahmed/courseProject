<?php
// Redirect user to login if not logged in
session_start();
require_once "includes/conn.php";

if (!isset($_SESSION['logged']) || !($_SESSION['logged'] === true)) {
    header('Location: login.php');
    die();
}

require_once "includes/conn.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sql = "UPDATE `classes` SET `className`=?,`teacherName`=?,`price`=?,`Published`=?,`image`=?,`ageFrom`=?,`ageTo`=?,`timeFrom`=?,`timeTo`=?,`Capacity`=? WHERE `id` = ?";
    
    $stmt = $conn->prepare($sql);
    
    $className = $_POST['className'];
    $teacherName = $_POST['teacherName'];
    $price = $_POST['price'];
    $ageFrom = $_POST['ageFrom'];
    $ageTo = $_POST['ageTo'];
    $timeFrom = $_POST['timeFrom'];
    $timeTo = $_POST['timeTo'];
    $Capacity = $_POST['Capacity'];
    $id = $_POST['id'];
    
    // Handle Published checkbox
    $Published = isset($_POST['Published']) ? 1 : 0;
    
    $oldImage = $_POST['oldImage'];
    require_once "includes/updateImage.php";
    
    $stmt->execute([$className, $teacherName, $price, $Published, $image_name, $ageFrom, $ageTo, $timeFrom, $timeTo, $Capacity, $id]);
    
    echo "Data updated successfully!";
}

if (isset($_GET['id'])) {
    $sql = "SELECT * FROM `classes` WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    
    $id = $_GET['id'];
    $stmt->execute([$id]);
    
    $class = $stmt->fetch();

    if ($class === false) {
        header('Location: classes.php');
        die();
    }
} else {
    header('Location: classes.php');
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
      <h2 class="fw-bold fs-2 mb-5 pb-2">Edit Class</h2>
      <form action="" method="POST" enctype="multipart/form-data" class="px-md-5">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <input type="hidden" name="oldImage" value="<?php echo $class['image'] ?>">
        <div class="form-group mb-3 row">
          <label for="" class="form-label col-md-2 fw-bold text-md-end">Class Name:</label>
          <div class="col-md-10">
            <input name="className" value="<?php echo $class['className']; ?>" type="text" placeholder="e.g. Art & Design" class="form-control py-2" />
          </div>
        </div>
        <div class="form-group mb-3 row">
          <label for="" class="form-label col-md-2 fw-bold text-md-end">Teacher:</label>
          <div class="col-md-10">
            <select name="teacherName" id="" class="form-control py-1">
              <option value="">Select teacher</option>
              <option value="Mark Henry" <?php echo ($class['teacherName'] == 'Mark Henry') ? 'selected' : '' ?>>Mark Henry</option>
              <option value="John Doe" <?php echo ($class['teacherName'] == 'John Doe') ? 'selected' : '' ?>>John Doe</option>
            </select>
          </div>
        </div>
        <div class="form-group mb-3 row">
          <label for="" class="form-label col-md-2 fw-bold text-md-end">Price:</label>
          <div class="col-md-10">
            <input name="price" value="<?php echo $class['price']; ?>" type="number" step="0.1" placeholder="Enter price" class="form-control py-2" />
          </div>
        </div>
        <div class="form-group mb-3 row">
          <label for="" class="form-label col-md-2 fw-bold text-md-end">Capacity:</label>
          <div class="col-md-10">
            <input name="Capacity" value="<?php echo $class['Capacity']; ?>" type="number" step="1" placeholder="Enter capacity" class="form-control py-2" />
          </div>
        </div>
        <div class="form-group mb-3 row">
          <label for="" class="form-label col-md-2 fw-bold text-md-end">Age:</label>
          <div class="col-md-10">
            <label for="" class="form-label">From <input name="ageFrom" value="<?php echo $class['ageFrom']; ?>" type="number" class="form-control"></label>
            <label for="" class="form-label">To <input name="ageTo" value="<?php echo $class['ageTo']; ?>" type="number" class="form-control"></label>
          </div>
        </div>
        <div class="form-group mb-3 row">
          <label for="" class="form-label col-md-2 fw-bold text-md-end">Time:</label>
          <div class="col-md-10">
            <label for="" class="form-label">From <input name="timeFrom" value="<?php echo $class['timeFrom']; ?>" type="time" class="form-control"></label>
            <label for="" class="form-label">To <input name="timeTo" value="<?php echo $class['timeTo']; ?>" type="time" class="form-control"></label>
          </div>
        </div>
        <div class="form-group mb-3 row">
          <label for="Published" class="form-label col-md-2 fw-bold text-md-end">Published:</label>
          <div class="col-md-10">
            <input <?php echo ($class['Published'] == 1) ? "checked" : "" ?> name="Published" type="checkbox" class="form-check-input" style="padding: 0.7rem;" />
          </div>
        </div>
        <hr>
        <div class="form-group mb-3 row">
          <label for="" class="form-label col-md-2 fw-bold text-md-end">Image:</label>
          <div class="col-md-10">
            <input type="file" class="form-control" style="padding: 0.7rem;" name="image" />
          </div>
        </div>
        <div class="row justify-content-end">
          <div class="col-md-10">
            <img src="../img/<?php echo $class['image'] ?>" alt="class-image" style="max-width: 150px" />
          </div>
        </div>
        <div class="text-md-end">
          <button class="btn mt-4 btn-secondary text-white fs-5 fw-bold border-0 py-2 px-md-5">Edit Class</button>
        </div>
      </form>
    </div>
  </div>
</main>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
