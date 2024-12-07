<?php
  require_once "includes/conn.php";

  if ($_SERVER["REQUEST_METHOD"] === "POST"){
    try{
    $sql = "INSERT INTO `users`(`Fullname`, `Username`, `Email`, `Password`, `Phone`) VALUES (?,?,?,?,?)";
   
    $stmt = $conn->prepare($sql);
    $Fullname = $_POST['Fullname'];
    $Username = $_POST['Username'];
    $Email = $_POST['Email'];
    $Password = password_hash($_POST['Password'], PASSWORD_DEFAULT);
    $Phone = $_POST['Phone'];
    $stmt->execute([$Fullname, $Username, $Email, $Password, $Phone]);

   // Echo "Data Stored Successfuly!";
   header('Location: login.php');
   die();
  }catch(PDOException $e){
    $erorr = "Connection failed: " . $e->getMessage();
  }
  }

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login/Registeration</title>
  <link rel="stylesheet" href="css/main.min.css">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body class="bg-dark">
  <div class="container" >
    <div class="row justify-content-center mt-5">
      <div class="col-lg-5 main position-relative mt-5 d-flex flex-column align-items-center">
        <h2 class="text-white mt-5 fw-bold">Registeration Form</h2>

        <form action="" method="POST" class="mt-3 w-100 px-3">
          <div class="form-group mb-3">
            <label for="" class="text-white form-label">Fullname*</label>
            <input name="Fullname" type="text" placeholder="e.g. John Doe" class="form-control form-control-input py-2" required>
          </div>
          <div class="form-group mb-3">
            <label for="" class="text-white form-label">Username*</label>
            <input name="Username" type="text" placeholder="Username" class="form-control form-control-input py-2" required>
          </div>
          <div class="form-group mb-3">
            <label for="" class="text-white form-label">Email*</label>
            <input name="Email" type="email" placeholder="Email" class="form-control form-control-input py-2" required>
          </div>
          <div class="form-group mb-3">
            <label for="" class="text-white form-label">Password*</label>
            <input name="Password" type="password" placeholder="Password" class="form-control form-control-input py-2" required>
          </div>
          <div class="form-group mb-3">
            <label for="" class="text-white form-label">Phone</label>
            <input name="Phone" type="text" placeholder="e.g. +2011423253" class="form-control form-control-input py-2">
          </div>
          <button class="btn my-4 bg-light fs-5 fw-bold w-100 border-0 py-2">Register</button>
          <a href="login.html" class="text-center d-block fs-4 text-white mb-5">Already have account?</a>
        </form>
        <?php
        //for erorr:
          if(isset($erorr)){
      ?>
          <div style="background-color: #ddd; padding:10px; color:red;">
              <?php echo $erorr; ?>
          </div>  
      <?php  
          }
      ?>
      </div>
    </div>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>