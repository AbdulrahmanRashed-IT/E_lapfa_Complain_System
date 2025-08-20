<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';
if(empty($_SESSION['user_id'])){ header('Location: /e-lapfa-complaint-system/'); exit; }
$user = current_user();
$msg = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $title = $_POST['title']; $desc = $_POST['description'];
    $file = upload_file($_FILES['file']);
    $stmt = $mysqli->prepare('INSERT INTO complaints (user_id,title,description,file) VALUES (?,?,?,?)');
    $stmt->bind_param('isss', $user['id'],$title,$desc,$file);
    if($stmt->execute()) $msg = 'Complaint submitted';
    else $msg = 'Error';
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Submit</title><link rel="stylesheet" href="../assets/css/style.css"></head><body class="layout">
<aside class="sidenav"><div class="brand">e-LapFa</div><nav><a href="dashboard.php">Dashboard</a><a href="my_complaints.php">My Complaints</a></nav></aside>
<main class="content">
  <section class="card">
    <h2>New Complaint</h2>
    <?php if($msg) echo '<div class="success">'.esc($msg).'</div>'; ?>
    <form method="post" enctype="multipart/form-data">
      <label>Title<input name="title" required></label>
      <label>Description<textarea name="description" required></textarea></label>
      <label>File (PNG/JPEG/PDF max 2MB)<input type="file" name="file"></label>
      <button class="btn">Submit</button>
    </form>
  </section>
</main>
</body></html>
