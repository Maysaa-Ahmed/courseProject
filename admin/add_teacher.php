
<?php
//redirect user to login if he is not logged in
session_start();
require_once "includes/conn.php";

if(!isset($_SESSION['logged']) || !($_SESSION['logged'] === true)){
  header('Location:login.php');
     die();
}


if ($_SERVER["REQUEST_METHOD"] === "POST"){

    try{
    $sql = "INSERT INTO `teachers`(`FullName`, `Job`, `Published`, `image`) VALUES (?,?,?,?)";
   
	$stmt = $conn->prepare($sql);
	
    $FullName = $_POST['FullName'];
    $Job = $_POST['Job'];
	$Published = $_POST['Published'];

	
	//$image = 'image';
	

	require_once "includes/addimage.php";

	
    $stmt->execute([$FullName, $Job, $Published, $image_name]);

  Echo "Data Stored Successfuly!";
   header('Location: teachers.php');
   die();
  }catch(PDOException $e){
    $erorr = "Connection failed: " . $e->getMessage();
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
          <h2 class="fw-bold fs-2 mb-5 pb-2">Add Teacher</h2>
          <form action="" method="POST" enctype="multipart/form-data" class="px-md-5">
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-md-end"
                >Fullname:</label
              >
              <div class="col-md-10">
                <input
                name="FullName"
                  type="text"
                  placeholder="e.g. John Doe"
                  class="form-control py-2"
                />
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-md-end"
                >Job Title:</label
              >
              <div class="col-md-10">
                <input
                name="Job"
                  type="text"
                  placeholder="e.g. Content Creator"
                  class="form-control py-2"
                />
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-md-end"
                >Published:</label
              >
              <div class="col-md-10">
                <input
                name="Published"
                  type="checkbox"
                  class="form-check-input"
                  style="padding: 0.7rem;"
                />
              </div>
            </div>
            <hr>
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-md-end"
                >Image:</label
              >
              <div class="col-md-10">
                <input
                name="image"
                  type="file"
                  class="form-control"
                  style="padding: 0.7rem;"
                />
              </div>
            </div>
            <div class="text-md-end">
            <button
              class="btn mt-4 btn-secondary text-white fs-5 fw-bold border-0 py-2 px-md-5"
            >
              Add Teacher
            </button>
          </div>
          </form>
        </div>
      </div>
    </main>
    <script src="js/bootstrap.bundle.min.js"></script>
  </body>
</html>
