<?php
// Redirect user to login if they are not logged in
session_start();
require_once "includes/conn.php";

if (!isset($_SESSION['logged']) || !($_SESSION['logged'] === true)) {
    header('Location: login.php');
    die();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sql = "UPDATE `users` SET `Fullname`=?,`Username`=?,`Email`=?,`Password`=?,`Phone`=?,`active`=? WHERE `id` = ?";
    $stmt = $conn->prepare($sql);

    $Fullname = $_POST['Fullname'];
    $Username = $_POST['Username'];
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];
    $Phone = $_POST['Phone'];
    $id = $_POST['id'];

    // Check if the active checkbox is set
    $active = isset($_POST['active']) ? 1 : 0;

    $stmt->execute([$Fullname, $Username, $Email, $Password, $Phone, $active, $id]);

    echo "done";
}

if (isset($_GET['id'])) {
    $sql = "SELECT * FROM `users` WHERE id = ?";
    $stmt = $conn->prepare($sql);

    $id = $_GET['id'];
    $stmt->execute([$id]);

    $user = $stmt->fetch();

    if ($user === false) {
        header('Location: users.php');
        die();
    }
} else {
    header('Location: users.php');
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
                <h2 class="fw-bold fs-2 mb-5 pb-2">Edit User</h2>
                <form action="" method="POST" class="px-5">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">

                    <div class="form-group mb-3 row">
                        <label for="Fullname" class="form-label col-md-2 fw-bold text-end">Fullname:</label>
                        <div class="col-md-10">
                            <input name="Fullname" value="<?php echo $user['Fullname']; ?>" type="text" placeholder="e.g. John Doe" class="form-control py-2" />
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label for="Username" class="form-label col-md-2 fw-bold text-end">Username:</label>
                        <div class="col-md-10">
                            <input name="Username" value="<?php echo $user['Username']; ?>" type="text" placeholder="Username" class="form-control py-2" />
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label for="Email" class="form-label col-md-2 fw-bold text-end">Email:</label>
                        <div class="col-md-10">
                            <input name="Email" value="<?php echo $user['Email']; ?>" type="email" placeholder="email@example.com" class="form-control py-2" />
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label for="Password" class="form-label col-md-2 fw-bold text-end">Password:</label>
                        <div class="col-md-10">
                            <input name="Password" value="<?php echo $user['Password']; ?>" type="password" placeholder="Password" class="form-control py-2" />
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label for="Phone" class="form-label col-md-2 fw-bold text-end">Phone:</label>
                        <div class="col-md-10">
                            <input name="Phone" value="<?php echo $user['Phone']; ?>" type="text" placeholder="+20133332323" class="form-control py-2" />
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label for="active" class="form-label col-md-2 fw-bold text-end">Active:</label>
                        <div class="col-md-10">
                            <input <?php echo ($user['active'] == 1) ? "checked" : ""; ?> name="active" type="checkbox" class="form-check-input" style="padding: 0.7rem;" />
                        </div>
                    </div>
                    <div class="text-end">
                        <button class="btn mt-4 btn-secondary text-white fs-5 fw-bold border-0 py-2 px-md-5">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
