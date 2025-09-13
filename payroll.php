<?php
session_start();
if (!isset($_SESSION['hr'])) { header("Location: index.php"); exit; }
include 'config.php';

$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $emp_id = intval($_POST['emp_id']);
    $pay_month = $_POST['pay_month'];
    $salary = floatval($_POST['salary']);
    $bonus = floatval($_POST['bonus']);
    $stmt = $conn->prepare("INSERT INTO payroll(emp_id,pay_month,salary,bonus) VALUES (?,?,?,?)");
    $stmt->bind_param("issd", $emp_id, $pay_month, $salary, $bonus);
    $msg = $stmt->execute() ? "Payroll saved!" : "Error: ".$conn->error;
}
$emps = $conn->query("SELECT emp_id, name FROM employee ORDER BY name");
$list = $conn->query("SELECT p.*, e.name FROM payroll p JOIN employee e ON p.emp_id=e.emp_id ORDER BY p.payroll_id DESC");
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Payroll</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<?php include 'partials_nav.php'; ?>
<div class="container grid-2">
  <div class="card">
    <h2>New Payroll Entry</h2>
    <?php if ($msg) echo "<p class='notice'>$msg</p>"; ?>
    <form method="POST">
      <label>Employee</label>
      <select name="emp_id" required>
        <option value="">--select--</option>
        <?php while($e=$emps->fetch_assoc()): ?>
          <option value="<?= $e['emp_id'] ?>"><?= htmlspecialchars($e['name']) ?></option>
        <?php endwhile; ?>
      </select>
      <input name="pay_month" placeholder="YYYY-MM" required>
      <input type="number" step="0.01" name="salary" placeholder="Salary" required>
      <input type="number" step="0.01" name="bonus" placeholder="Bonus" value="0">
      <button type="submit">Save</button>
    </form>
  </div>
  <div class="card">
    <h2>Payroll Records</h2>
    <table>
      <tr><th>ID</th><th>Employee</th><th>Month</th><th>Salary</th><th>Bonus</th></tr>
      <?php while($r=$list->fetch_assoc()): ?>
      <tr>
        <td><?= $r['payroll_id'] ?></td>
        <td><?= htmlspecialchars($r['name']) ?></td>
        <td><?= htmlspecialchars($r['pay_month']) ?></td>
        <td><?= number_format($r['salary'], 2) ?></td>
        <td><?= number_format($r['bonus'], 2) ?></td>
      </tr>
      <?php endwhile; ?>
    </table>
  </div>
</div>
</body></html>
