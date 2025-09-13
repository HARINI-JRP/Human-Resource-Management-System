<?php
session_start();
if (!isset($_SESSION['hr'])) { header("Location: index.php"); exit; }
include 'config.php';

$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $emp_id = intval($_POST['emp_id']);
    $date = $_POST['date'];
    $time_in = $_POST['time_in'];
    $time_out = $_POST['time_out'];
    $stmt = $conn->prepare("INSERT INTO attendance(emp_id,date,time_in,time_out) VALUES (?,?,?,?)");
    $stmt->bind_param("isss", $emp_id, $date, $time_in, $time_out);
    $msg = $stmt->execute() ? "Attendance saved!" : "Error: ".$conn->error;
}
$emps = $conn->query("SELECT emp_id, name FROM employee ORDER BY name");
$rows = $conn->query("SELECT a.*, e.name FROM attendance a JOIN employee e ON a.emp_id=e.emp_id ORDER BY a.date DESC, a.att_id DESC");
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Attendance</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<?php include 'partials_nav.php'; ?>
<div class="container grid-2">
  <div class="card">
    <h2>Mark Attendance</h2>
    <?php if ($msg) echo "<p class='notice'>$msg</p>"; ?>
    <form method="POST">
      <label>Employee</label>
      <select name="emp_id" required>
        <option value="">--select--</option>
        <?php while($e=$emps->fetch_assoc()): ?>
          <option value="<?= $e['emp_id'] ?>"><?= htmlspecialchars($e['name']) ?></option>
        <?php endwhile; ?>
      </select>
      <input type="date" name="date" required>
      <input type="time" name="time_in" required>
      <input type="time" name="time_out" required>
      <button type="submit">Save</button>
    </form>
  </div>
  <div class="card">
    <h2>Recent Attendance</h2>
    <table>
      <tr><th>Date</th><th>Employee</th><th>In</th><th>Out</th></tr>
      <?php while($r=$rows->fetch_assoc()): ?>
      <tr>
        <td><?= $r['date'] ?></td>
        <td><?= htmlspecialchars($r['name']) ?></td>
        <td><?= $r['time_in'] ?></td>
        <td><?= $r['time_out'] ?></td>
      </tr>
      <?php endwhile; ?>
    </table>
  </div>
</div>
</body></html>
