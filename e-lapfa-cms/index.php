<?php
session_start();
require_once 'includes/db.php';
require_once 'includes/functions.php';

$err = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['action']) && $_POST['action'] === 'login'){
        $email = $_POST['email']; $password = $_POST['password'];
        $stmt = $mysqli->prepare('SELECT id,password,role FROM users WHERE email=?');
        $stmt->bind_param('s',$email); $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        if($res && password_verify($password, $res['password'])){
            $_SESSION['user_id'] = $res['id'];
            if($res['role'] === 'admin') header('Location: admin/dashboard.php');
            else header('Location: user/dashboard.php');
            exit;
        } else $err = 'Invalid credentials';
    } elseif(isset($_POST['action']) && $_POST['action'] === 'register'){
        $name = $_POST['name']; $email = $_POST['email']; $password = $_POST['password'];
        // simple validation
        if(empty($name) || empty($email) || empty($password)){ $err = 'Fill all fields'; }
        else {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $mysqli->prepare('INSERT INTO users (name,email,password) VALUES (?,?,?)');
            $stmt->bind_param('sss',$name,$email,$hash);
            if($stmt->execute()){
                $_SESSION['user_id'] = $mysqli->insert_id;
                header('Location: user/dashboard.php'); exit;
            } else {
                $err = 'Could not register (email may exist)';
            }
        }
    }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>e-LapFa — Login or Register</title>
<link rel="stylesheet" href="assets/css/style.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<main class="center">
  <div class="card auth">
    <h1>e-LapFa</h1>
    <?php if($err): ?><div class="error"><?php echo esc($err); ?></div><?php endif; ?>
    <div class="tabs">
      <button id="btnLogin" class="active">Login</button>
      <button id="btnReg">Register</button>
    </div>
    <form id="loginForm" method="post">
      <input type="hidden" name="action" value="login">
      <label>Email <input name="email" type="email" required></label>
      <label>Password <input name="password" type="password" required></label>
      <button class="btn">Login</button>
    </form>

    <form id="regForm" method="post" style="display:none;">
      <input type="hidden" name="action" value="register">
      <label>Name <input name="name" required></label>
      <label>Email <input name="email" type="email" required></label>
      <label>Password <input name="password" type="password" required></label>
      <button class="btn">Register</button>
    </form>
  </div>
</main>
<script src="assets/js/app.js"></script>
</body>
</html>
