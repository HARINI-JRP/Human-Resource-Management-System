<?php
session_start();
if (!isset($_SESSION['hr'])) { header("Location: index.php"); exit; }
include 'config.php';

$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $emp_id = intval($_POST['emp_id']);
    $rating = intval($_POST['rating']);
    $review_date = $_POST['review_date'];
    $stmt = $conn->prepare("INSERT INTO perf_review(emp_id, rating, review_date) VALUES (?,?,?)");
    $stmt->bind_param("iis", $emp_id, $rating, $review_date);
    $msg = $stmt->execute() ? "Review saved!" : "Error: ".$conn->error;
}
$emps = $conn->query("SELECT emp_id, name FROM employee ORDER BY name");
$list = $conn->query("SELECT p.*, e.name FROM perf_review p JOIN employee e ON p.emp_id=e.emp_id ORDER BY p.review_id DESC");
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Performance</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<?php include 'partials_nav.php'; ?>
<div class="container grid-2">
  <div class="card">
    <h2>New Performance Review</h2>
    <?php if ($msg) echo "<p class='notice'>$msg</p>"; ?>
    <form method="POST">
      <label>Employee</label>
      <select name="emp_id" required>
        <option value="">--select--</option>
        <?php while($e=$emps->fetch_assoc()): ?>
          <option value="<?= $e['emp_id'] ?>"><?= htmlspecialchars($e['name']) ?></option>
        <?php endwhile; ?>
      </select>
      <input type="number" name="rating" min="1" max="10" placeholder="Rating 1-10" required>
      <input type="date" name="review_date" required>
      <button type="submit">Save</button>
    </form>
  </div>
  <div class="card">
    <h2>All Reviews</h2>
    <table>
      <tr><th>ID</th><th>Employee</th><th>Rating</th><th>Date</th></tr>
      <?php while($r=$list->fetch_assoc()): ?>
      <tr>
        <td><?= $r['review_id'] ?></td>
        <td><?= htmlspecialchars($r['name']) ?></td>
        <td><?= $r['rating'] ?></td>
        <td><?= $r['review_date'] ?></td>
      </tr>
      <?php endwhile; ?>
    </table>
  </div>
</div>
</body></html>
