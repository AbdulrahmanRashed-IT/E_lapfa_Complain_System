<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';
if(empty($_SESSION['user_id'])){ header('Location: /e-lapfa-complaint-system/'); exit; }
$user = current_user();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>User Dashboard - e-LapFa</title>
<link rel="stylesheet" href="../assets/css/style.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="layout">
  <aside class="sidenav">
    <div class="brand">e-LapFa</div>
    <nav>
      <a href="dashboard.php" class="active">Dashboard</a>
      <a href="profile.php">Profile</a>
      <a href="complaint_submit.php">Submit Complaint</a>
      <a href="my_complaints.php">My Complaints</a>
      <a href="../chat/chat.php">Chat</a>
      <a href="../logout.php">Logout</a>
    </nav>
  </aside>
  <main class="content">
    <header class="topbar">
      <div>Welcome, <?php echo esc($user['name']); ?></div>
      <div class="theme-switch">Theme: <select id="themeSelect"><option value="light">Light</option><option value="dark">Dark</option><option value="custom">Custom</option></select></div>
    </header>

    <section class="grid">
      <div class="card">
        <h3>Submit a new complaint</h3>
        <p>Use the menu to create a complaint with optional file upload (PNG/JPEG/PDF, max 2MB).</p>
        <a class="btn" href="complaint_submit.php">Create</a>
      </div>
      <div class="card">
        <h3>My Complaints</h3>
        <?php
        $stmt = $mysqli->prepare('SELECT COUNT(*) as c FROM complaints WHERE user_id=?');
        $stmt->bind_param('i', $user['id']); $stmt->execute();
        $cnt = $stmt->get_result()->fetch_assoc()['c'];
        echo '<p>Total: '.(int)$cnt.'</p>';
        ?>
        <a class="btn" href="my_complaints.php">View</a>
      </div>
    </section>
  </main>

  <a class="whatsapp-fab" href="https://wa.me/6287840273282" target="_blank" title="WhatsApp Chat">WA</a>

<script src="../assets/js/app.js"></script>
</body>
</html>
