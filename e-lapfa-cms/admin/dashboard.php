<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';
if(empty($_SESSION['user_id'])){ header('Location: login.php'); exit; }
if(!is_admin()){ echo 'Access denied'; exit; }
$user = current_user();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin Dashboard - e-LapFa</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="layout">
  <aside class="sidenav">
    <div class="brand">e-LapFa Admin</div>
    <nav>
      <a href="dashboard.php" class="active">Dashboard</a>
      <a href="manage_users.php">Manage Users</a>
      <a href="manage_complaints.php">Manage Complaints</a>
      <a href="manage_admins.php">Manage Admins</a>
      <a href="../chat/chat_admin.php">Chat</a>
      <a href="../logout.php">Logout</a>
    </nav>
  </aside>
  <main class="content">
    <header class="topbar">
      <div>Admin: <?php echo esc($user['name']); ?></div>
      <div><button id="themeToggle" class="btn">Toggle Theme</button></div>
    </header>

    <section class="grid">
      <div class="card">
        <h3>Total Complaints</h3>
        <?php
        $stmt = $mysqli->prepare('SELECT status, COUNT(*) as c FROM complaints GROUP BY status');
        $stmt->execute();
        $res = $stmt->get_result();
        while($row = $res->fetch_assoc()){
            echo '<p>'.esc($row['status']).': '.(int)$row['c'].'</p>';
        }
        ?>
        <a class="btn" href="manage_complaints.php">Manage</a>
      </div>
      <div class="card">
        <h3>Users</h3>
        <?php $r = $mysqli->query('SELECT COUNT(*) as c FROM users')->fetch_assoc()['c']; echo '<p>Total Users: '.(int)$r.'</p>'; ?>
        <a class="btn" href="manage_users.php">Manage Users</a>
      </div>
      <div class="card">
        <h3>Recent Complaints</h3>
        <?php
        $rs = $mysqli->query('SELECT c.title,u.name,c.status FROM complaints c JOIN users u ON u.id=c.user_id ORDER BY c.created_at DESC LIMIT 5');
        while($ro = $rs->fetch_assoc()) echo '<p>'.esc($ro['title']).' <small>by '.esc($ro['name']).' ('.esc($ro['status']).')</small></p>';
        ?>
      </div>
    </section>
  </main>

  <a class="whatsapp-fab" href="https://wa.me/6287840273282" target="_blank" title="WhatsApp Chat">WA</a>

<script>
document.getElementById('themeToggle').addEventListener('click', function(){
  const t = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
  document.documentElement.setAttribute('data-theme', t);
  localStorage.setItem('e_lapfa_theme', t);
});
</script>
</body>
</html>
