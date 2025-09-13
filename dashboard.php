<?php
session_start();
if (!isset($_SESSION['hr'])) { header("Location: index.php"); exit; }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>HRMS Dashboard</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="topbar">
  <h1>HRMS</h1>
  <nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="add_employee.php">Add Employee</a>
    <a href="view_employee.php">Employees</a>
    <a href="recruitment.php">Recruitment</a>
    <a href="attendance.php">Attendance</a>
    <a href="performance.php">Performance</a>
    <a href="payroll.php">Payroll</a>
    <a href="logout.php">Logout</a>
  </nav>
</header>
<main class="container">
  <div class="grid">
    <a class="card link" href="add_employee.php"><h3>Add Employee</h3><p>Create new employee record.</p></a>
    <a class="card link" href="view_employee.php"><h3>View Employees</h3><p>List, edit & delete employees.</p></a>
    <a class="card link" href="recruitment.php"><h3>Recruitment</h3><p>Track job posts & applications.</p></a>
    <a class="card link" href="attendance.php"><h3>Attendance</h3><p>Mark and view attendance.</p></a>
    <a class="card link" href="performance.php"><h3>Performance</h3><p>Record performance reviews.</p></a>
    <a class="card link" href="payroll.php"><h3>Payroll</h3><p>Manage salaries & bonuses.</p></a>
  </div>
</main>
</body>
</html>
