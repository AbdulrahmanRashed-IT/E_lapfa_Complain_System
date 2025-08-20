<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';
if(empty($_SESSION['user_id'])){ header('Location: /e-lapfa-complaint-system/'); exit; }
$id = intval($_GET['id'] ?? 0);
$stmt = $mysqli->prepare('SELECT * FROM complaints WHERE id=?');
$stmt->bind_param('i',$id); $stmt->execute(); $c = $stmt->get_result()->fetch_assoc();
?>
<!doctype html><html><head><meta charset="utf-8"><title>View Complaint</title><link rel="stylesheet" href="../assets/css/style.css"></head><body class="layout">
<aside class="sidenav"><div class="brand">e-LapFa</div></aside>
<main class="content">
  <section class="card">
    <h2><?php echo esc($c['title']); ?></h2>
    <p><?php echo nl2br(esc($c['description'])); ?></p>
    <p>Status: <span id="status"><?php echo esc($c['status']); ?></span></p>
    <?php if($c['file']): ?>
      <p>Attachment: <a href="../<?php echo esc($c['file']); ?>" target="_blank">Download</a></p>
    <?php endif; ?>
  </section>
</main>
</body></html>
