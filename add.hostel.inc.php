<?php

if (isset($_POST['signup-submit'])) {

  require 'config.inc.php';

  $roll = $_POST['student_roll_no'];
  $fname = $_POST['student_fname'];
  $lname = $_POST['student_lname'];
  $mobile = $_POST['mobile_no'];
  $dept = $_POST['department'];
  // $year = $_POST['year_of_study'];
  // $password = $_POST['pwd'];
  // $cnfpassword = $_POST['confirmpwd'];


  if(!preg_match("/^[a-zA-Z0-9]*$/",$roll)){
    header("Location: ../add_hostel.php?error=invalidroll");
    exit();
  }
  // else if($password !== $cnfpassword){
  //   header("Location: ../add_hostel.php?error=passwordcheck");
  //   exit();
  // }
  else {

    $sql = "SELECT Hostel_id FROM Hostel WHERE Hostel_id=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
      header("Location: ../add_hostel.php?error=sqlerror");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt, "s", $roll);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $resultCheck = mysqli_stmt_num_rows($stmt);
      if ($resultCheck > 0) {
        header("Location: ../add_hostel.php?error=userexists");
        exit();
      }
      else {
        $sql = "INSERT INTO Hostel (Hostel_id, Hostel_name,current_no_of_rooms,No_of_rooms, No_of_students) VALUES (?, ?, ?,?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
          header("Location: ../add_hostel.php?error=sqlerror");
          exit();
        }
        else {

          // $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

          mysqli_stmt_bind_param($stmt, "sssssss",$roll, $fname, $lname, $mobile);
          mysqli_stmt_execute($stmt);
          header("Location: ../home_manager.php?add=success");
          exit();
        }
      }
    }

  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);

}
else {
  header("Location: ../add_hostel.php");
  exit();
}