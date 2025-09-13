<?php
session_start();
if (!isset($_SESSION['hr'])) { header("Location: index.php"); exit; }
include 'config.php';

$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dept = $_POST['dept'];
    $job_role = $_POST['job_role'];
    $appl_date = $_POST['appl_date'];
    $status = $_POST['status'];
    $stmt = $conn->prepare("INSERT INTO recruitment(dept,job_role,appl_date,status) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $dept, $job_role, $appl_date, $status);
    $msg = $stmt->execute() ? "Recruitment record added!" : "Error: ".$conn->error;
}
$list = $conn->query("SELECT * FROM recruitment ORDER BY job_id DESC");
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Recruitment</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<?php include 'partials_nav.php'; ?>
<div class="container grid-2">
  <div class="card">
    <h2>New Recruitment</h2>
    <?php if ($msg) echo "<p class='notice'>$msg</p>"; ?>
    <form method="POST">
      <input name="dept" placeholder="Department" required>
      <input name="job_role" placeholder="Job Role" required>
      <input type="date" name="appl_date" required>
      <input name="status" placeholder="Status (open/closed)" required>
      <button type="submit">Save</button>
    </form>
  </div>
  <div class="card">
    <h2>All Jobs</h2>
    <table>
      <tr><th>ID</th><th>Dept</th><th>Role</th><th>Applied Date</th><th>Status</th></tr>
      <?php while($r=$list->fetch_assoc()): ?>
      <tr>
        <td><?= $r['job_id'] ?></td>
        <td><?= htmlspecialchars($r['dept']) ?></td>
        <td><?= htmlspecialchars($r['job_role']) ?></td>
        <td><?= $r['appl_date'] ?></td>
        <td><?= htmlspecialchars($r['status']) ?></td>
      </tr>
      <?php endwhile; ?>
    </table>
  </div>
</div>
</body></html>
