<?php
// Start the session
session_start();
require_once "includes/conn.php";

// Check if the user is logged in
if(!isset($_SESSION['logged']) || !($_SESSION['logged'] === true)){
  header('Location:login.php');
  die();
}

$sql = "SELECT * FROM `users`";
$stmt = $conn->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll();
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
<?php require_once "includes/nav.php"; ?>

<div class="container my-5">
    <div class="bg-light p-5 rounded">
        <h2 class="fw-bold fs-2 mb-5 pb-2">All Users</h2>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">Registration Date</th>
                    <th scope="col">FullName</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Active</th>
                    <th scope="col">Edit</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($users as $user) {
                    // Format the registration date
                    $regDate = new DateTime($user['regDate']);
                    $formattedDate = $regDate->format('d M Y');
                    // Debug output for active field
                    // echo 'Active field value: ' . $user['active']; 
                    ?>
                    <tr>
                        <th scope="row"><?php echo $formattedDate; ?></th>
                        <td><?php echo $user['Fullname']; ?></td>
                        <td><?php echo $user['Username']; ?></td>
                        <td><?php echo $user['Email']; ?></td>
                        <td><?php echo $user['Phone']; ?></td>
                        <td>
                            <?php
                            // Display Active or Inactive based on the active field value
                            if ($user['active'] == 1) {
                                echo "Yes";
                            } else {
                                echo "No";
                            }
                            ?>
                        </td>
                        <td><a href="edit_user.php?id=<?php echo $user['id']; ?>" class="text-decoration-none"><i>✒️</i></a></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
