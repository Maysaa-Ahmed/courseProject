<?php
//redirect user to login if he is not logged in
session_start();
require_once "includes/conn.php";

// if(!isset($_SESSION['logged']) || !($_SESSION['logged'] === true)){
//   header('Location:login.php');
//      die();
// }

$sql = "SELECT * FROM `teachers`";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $teachers = $stmt->fetchAll();

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
          <h2 class="fw-bold fs-2 mb-5 pb-2">All Teachers</h2>
          <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">Registration Date</th>
                <th scope="col">FullName</th>
                <th scope="col">Job Title</th>
                <th scope="col">Published</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
              </tr>
            </thead>
            <tbody>

            <?php
            foreach($teachers as $teacher){
              // Format the registration date
              $regDate = new DateTime($teacher['regDate']);
              $formattedDate = $regDate->format('d M Y');
            ?>

              <tr>
                <th scope="row"><?php echo $formattedDate; ?></th>
                <td><?php echo $teacher['FullName']; ?></td>
                <td><?php echo $teacher['Job']; ?></td>
                <td><?php echo $teacher['Published']; ?></td>
                <td><a href="edit_teacher.php?id=<?php  echo $teacher['id']; ?>" class="text-decoration-none" ><i>✒️</i></a></td>
                <td><a href="delete_teacher.php?id=<?php  echo $teacher['id']; ?>" class="text-decoration-none" onclick="return confirm('Are You Sure You Want to Delete?')" ><img src="../img/trash-bin.png" alt="" style="max-width: 35px"></a> </td>
              </tr>
              <?php
            }
            ?>
            </tbody>
          </table>
        </div>
        </div>
      </div>
    </main>
    <script src="js/bootstrap.bundle.min.js"></script>
  </body>
</html>
