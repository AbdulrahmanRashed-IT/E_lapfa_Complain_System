<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';
if(empty($_SESSION['user_id'])){ header('Location: /e-lapfa-complaint-system/'); exit; }
$id = intval($_GET['id'] ?? 0);
$stmt = $mysqli->prepare('SELECT * FROM complaints WHERE id=? AND user_id=?');
$stmt->bind_param('ii',$id,$_SESSION['user_id']); $stmt->execute(); $c = $stmt->get_result()->fetch_assoc();
if(!$c){ echo 'Not found'; exit; }
if($c['status'] !== 'Pending'){ echo 'Cannot edit processed complaint'; exit; }
$msg='';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $title = $_POST['title']; $desc = $_POST['description'];
    $file = upload_file($_FILES['file']) ?: $c['file'];
    $stmt = $mysqli->prepare('UPDATE complaints SET title=?,description=?,file=?,updated_at=NOW() WHERE id=?');
    $stmt->bind_param('sssi',$title,$desc,$file,$id);
    if($stmt->execute()) $msg='Updated';
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Edit</title><link rel="stylesheet" href="../assets/css/style.css"></head><body class="layout">
<aside class="sidenav"><div class="brand">e-LapFa</div></aside>
<main class="content"><section class="card"><h2>Edit Complaint</h2><?php if($msg) echo '<div class="success">'.esc($msg).'</div>'; ?>
<form method="post" enctype="multipart/form-data">
<label>Title<input name="title" required value="<?php echo esc($c['title']); ?>"></label>
<label>Description<textarea name="description" required><?php echo esc($c['description']); ?></textarea></label>
<label>File<input type="file" name="file"></label>
<button class="btn">Save</button>
</form>
</section></main></body></html>
