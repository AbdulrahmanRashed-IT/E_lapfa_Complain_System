<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';
if(empty($_SESSION['user_id']) || !is_admin()){ header('Location: /e-lapfa-complaint-system/'); exit; }
$res = $mysqli->query('SELECT id,name,email,role,created_at FROM users ORDER BY id DESC');
?>
<!doctype html><html><head><meta charset="utf-8"><title>Manage Users</title><link rel="stylesheet" href="../assets/css/style.css"></head><body class="layout">
<aside class="sidenav"><div class="brand">e-LapFa Admin</div></aside>
<main class="content"><section class="card"><h2>Users</h2>
<table class="table"><tr><th>Name</th><th>Email</th><th>Role</th></tr>
<?php while($r = $res->fetch_assoc()): ?>
<tr><td><?php echo esc($r['name']); ?></td><td><?php echo esc($r['email']); ?></td><td><?php echo esc($r['role']); ?></td></tr>
<?php endwhile; ?>
</table>
</section></main></body></html>
