<?php
session_start();
if (!isset($_SESSION['hr'])) { header("Location: index.php"); exit; }
include 'config.php';

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM employee WHERE emp_id=$id");
    header("Location: view_employee.php");
    exit;
}

$res = $conn->query("SELECT * FROM employee ORDER BY emp_id DESC");
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Employees</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<?php include 'partials_nav.php'; ?>
<div class="container">
  <h2>Employees</h2>
  <table>
    <tr><th>ID</th><th>Name</th><th>Email</th><th>Join Date</th><th>Dept</th><th>Designation</th><th>Actions</th></tr>
    <?php while($row=$res->fetch_assoc()): ?>
    <tr>
      <td><?= $row['emp_id'] ?></td>
      <td><?= htmlspecialchars($row['name']) ?></td>
      <td><?= htmlspecialchars($row['email']) ?></td>
      <td><?= $row['join_date'] ?></td>
      <td><?= htmlspecialchars($row['dept']) ?></td>
      <td><?= htmlspecialchars($row['designation']) ?></td>
      <td><a class="btn danger" href="?delete=<?= $row['emp_id'] ?>" onclick="return confirm('Delete this employee?')">Delete</a></td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>
</body></html>
