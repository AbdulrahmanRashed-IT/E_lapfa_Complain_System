<?php
session_start();
require_once '../includes/db.php';
if(!empty($_SESSION['user_id'])){
    header('Location: dashboard.php'); exit;
}
$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $email = $_POST['email']; $password = $_POST['password'];
    $stmt = $mysqli->prepare('SELECT id,password,role FROM users WHERE email=? AND role="admin"');
    $stmt->bind_param('s',$email); $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    if($res && password_verify($password, $res['password'])){
        $_SESSION['user_id'] = $res['id'];
        header('Location: dashboard.php'); exit;
    } else $err = 'Invalid admin credentials';
}
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin Login - e-LapFa</title><link rel="stylesheet" href="../assets/css/style.css"></head><body class="center">
<div class="card auth">
  <h2>Admin Login</h2>
  <?php if($err) echo '<div class="error">'.htmlspecialchars($err).'</div>'; ?>
  <form method="post"><label>Email<input name="email" type="email" required></label><label>Password<input name="password" type="password" required></label><button class="btn">Login</button></form>
  <p><a href="/e-lapfa-complaint-system/">Back to site</a></p>
</div>
</body></html>
