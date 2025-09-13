<?php if (!isset($_SESSION)) { session_start(); } ?>
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
