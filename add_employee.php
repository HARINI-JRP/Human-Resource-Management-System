<?php
session_start();
if (!isset($_SESSION['hr'])) { header("Location: index.php"); exit; }
include 'config.php';

$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $join_date = $_POST['join_date'];
    $dept = $_POST['dept'];
    $designation = $_POST['designation'];
    $stmt = $conn->prepare("INSERT INTO employee(name,email,join_date,dept,designation) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sssss", $name, $email, $join_date, $dept, $designation);
    $msg = $stmt->execute() ? "Employee added!" : "Error: ".$conn->error;
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Add Employee</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<?php include 'partials_nav.php'; ?>
<div class="container">
  <div class="card">
    <h2>Add Employee</h2>
    <?php if ($msg) echo "<p class='notice'>$msg</p>"; ?>
    <form method="POST">
      <input name="name" placeholder="Employee Name" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="date" name="join_date" required>
      <input name="dept" placeholder="Department" required>
      <input name="designation" placeholder="Designation" required>
      <button type="submit">Save</button>
    </form>
  </div>
</div>
</body></html>
