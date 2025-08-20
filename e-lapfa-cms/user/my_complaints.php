<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';
if(empty($_SESSION['user_id'])){ header('Location: /e-lapfa-complaint-system/'); exit; }
$user = current_user();
$stmt = $mysqli->prepare('SELECT * FROM complaints WHERE user_id=? ORDER BY created_at DESC');
$stmt->bind_param('i',$user['id']); $stmt->execute();
$res = $stmt->get_result();
?>
<!doctype html><html><head><meta charset="utf-8"><title>My Complaints</title><link rel="stylesheet" href="../assets/css/style.css"></head><body class="layout">
<aside class="sidenav"><div class="brand">e-LapFa</div><nav><a href="dashboard.php">Dashboard</a><a href="complaint_submit.php">Submit</a></nav></aside>
<main class="content">
  <section class="card">
    <h2>My Complaints</h2>
    <table class="table">
      <tr><th>Title</th><th>Status</th><th>Action</th></tr>
      <?php while($row = $res->fetch_assoc()): ?>
      <tr>
        <td><?php echo esc($row['title']); ?></td>
        <td id="status-<?php echo $row['id']; ?>"><?php echo esc($row['status']); ?></td>
        <td>
          <a href="complaint_view.php?id=<?php echo $row['id']; ?>">View</a>
          <?php if($row['status'] === 'Pending'): ?>
            <a href="complaint_edit.php?id=<?php echo $row['id']; ?>">Edit</a>
            <a href="complaint_delete.php?id=<?php echo $row['id']; ?>">Delete</a>
          <?php endif; ?>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>
  </section>
</main>
</body></html>
