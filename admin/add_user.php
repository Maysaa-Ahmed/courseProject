<?php
// Redirect user to login if they are not logged in
session_start();
require_once "includes/conn.php";

if (!isset($_SESSION['logged']) || !($_SESSION['logged'] === true)) {
    header('Location: login.php');
    die();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $sql = "INSERT INTO `users`(`Fullname`, `Username`, `Email`, `Password`, `Phone`, `active`) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        $Fullname = $_POST['Fullname'];
        $Username = $_POST['Username'];
        $Email = $_POST['Email'];
        $Password = $_POST['Password'];
        $Phone = $_POST['Phone'];
        $active = isset($_POST['active']) ? 1 : 0; // Set to 1 if checked, otherwise 0

        $stmt->execute([$Fullname, $Username, $Email, $Password, $Phone, $active]);

        echo "Data Stored Successfully!";
        header('Location: users.php');
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
                <h2 class="fw-bold fs-2 mb-5 pb-2">Add User</h2>
                <form action="" method="POST" class="px-md-5">
                    <div class="form-group mb-3 row">
                        <label for="Fullname" class="form-label col-md-2 fw-bold text-md-end">Fullname:</label>
                        <div class="col-md-10">
                            <input name="Fullname" type="text" placeholder="e.g. John Doe" class="form-control py-2" />
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label for="Username" class="form-label col-md-2 fw-bold text-md-end">Username:</label>
                        <div class="col-md-10">
                            <input name="Username" type="text" placeholder="Username" class="form-control py-2" />
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label for="Email" class="form-label col-md-2 fw-bold text-md-end">Email:</label>
                        <div class="col-md-10">
                            <input name="Email" type="email" placeholder="email@example.com" class="form-control py-2" />
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label for="Password" class="form-label col-md-2 fw-bold text-md-end">Password:</label>
                        <div class="col-md-10">
                            <input name="Password" type="password" placeholder="Password" class="form-control py-2" />
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label for="Phone" class="form-label col-md-2 fw-bold text-md-end">Phone:</label>
                        <div class="col-md-10">
                            <input name="Phone" type="text" placeholder="+20133332323" class="form-control py-2" />
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label for="active" class="form-label col-md-2 fw-bold text-md-end">Active:</label>
                        <div class="col-md-10">
                            <input name="active" type="checkbox" class="form-check-input" style="padding: 0.7rem;" />
                        </div>
                    </div>
                    <div class="text-md-end">
                        <button class="btn mt-4 btn-secondary text-white fs-5 fw-bold border-0 py-2 px-md-5">
                            Add User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
