<?php
// Redirect user to login if not logged in
session_start();
require_once "includes/conn.php";

if (!isset($_SESSION['logged']) || !($_SESSION['logged'] === true)) {
    header('Location: login.php');
    die();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $sql = "INSERT INTO `classes`(`className`, `teacherName`, `price`, `Published`, `image`, `ageFrom`, `ageTo`, `timeFrom`, `timeTo`, `Capacity`) VALUES (?,?,?,?,?,?,?,?,?,?)";
        
        $stmt = $conn->prepare($sql);
        
        $className = $_POST['className'];
        $teacherName = $_POST['teacherName'];
        $price = $_POST['price'];
        $Published = isset($_POST['Published']) ? 1 : 0; // Handle checkbox
        $ageFrom = $_POST['ageFrom'];
        $ageTo = $_POST['ageTo'];
        $timeFrom = $_POST['timeFrom'];
        $timeTo = $_POST['timeTo'];
        $Capacity = $_POST['Capacity'];
        
        require_once "includes/addimage.php";
        
        $stmt->execute([$className, $teacherName, $price, $Published, $image_name, $ageFrom, $ageTo, $timeFrom, $timeTo, $Capacity]);
        
        echo "Data Stored Successfully!";
        header('Location: classes.php');
        die();
    } catch (PDOException $e) {
        $error = "Connection failed: " . $e->getMessage();
    }
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
                <h2 class="fw-bold fs-2 mb-5 pb-2">Add Class</h2>
                <form action="" method="POST" enctype="multipart/form-data" class="px-md-5">
                    <div class="form-group mb-3 row">
                        <label for="className" class="form-label col-md-2 fw-bold text-md-end">Class Name:</label>
                        <div class="col-md-10">
                            <input name="className" type="text" placeholder="e.g. Art & Design" class="form-control py-2" />
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label for="teacherName" class="form-label col-md-2 fw-bold text-md-end">Teacher:</label>
                        <div class="col-md-10">
                            <select name="teacherName" id="teacherName" class="form-control py-1">
                                <option value="">Select teacher</option>
                                <option value="Mark Henry">Maysaa</option>
                                <option value="John Doe">Marwan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label for="price" class="form-label col-md-2 fw-bold text-md-end">Price:</label>
                        <div class="col-md-10">
                            <input name="price" type="number" step="0.1" placeholder="Enter price" class="form-control py-2" />
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label for="Capacity" class="form-label col-md-2 fw-bold text-md-end">Capacity:</label>
                        <div class="col-md-10">
                            <input name="Capacity" type="number" step="1" placeholder="Enter capacity" class="form-control py-2" />
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label for="ageFrom" class="form-label col-md-2 fw-bold text-md-end">Age:</label>
                        <div class="col-md-10">
                            <label for="ageFrom" class="form-label">From <input name="ageFrom" type="number" class="form-control"></label>
                            <label for="ageTo" class="form-label">To <input name="ageTo" type="number" class="form-control"></label>
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label for="timeFrom" class="form-label col-md-2 fw-bold text-md-end">Time:</label>
                        <div class="col-md-10">
                            <label for="timeFrom" class="form-label">From <input name="timeFrom" type="time" class="form-control"></label>
                            <label for="timeTo" class="form-label">To <input name="timeTo" type="time" class="form-control"></label>
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label for="Published" class="form-label col-md-2 fw-bold text-md-end">Published:</label>
                        <div class="col-md-10">
                            <input name="Published" type="checkbox" class="form-check-input" style="padding: 0.7rem;" />
                        </div>
                    </div>
                    <hr>
                    <div class="form-group mb-3 row">
                        <label for="image" class="form-label col-md-2 fw-bold text-md-end">Image:</label>
                        <div class="col-md-10">
                            <input name="image" type="file" class="form-control" style="padding: 0.7rem;" />
                        </div>
                    </div>
                    <div class="text-md-end">
                        <button class="btn mt-4 btn-secondary text-white fs-5 fw-bold border-0 py-2 px-md-5">Add Class</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
