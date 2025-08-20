<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';
if(empty($_SESSION['user_id'])){ header('Location: /e-lapfa-complaint-system/'); exit; }
$user = current_user();
$msg='';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    // handle profile pic upload
    $pic = upload_file($_FILES['profile_pic']) ?: $user['profile_pic'];
    // change password if provided
    if(!empty($_POST['password'])){
        $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $stmt = $mysqli->prepare('UPDATE users SET name=?, email=?, profile_pic=?, password=? WHERE id=?');
        $stmt->bind_param('ssssi',$name,$email,$pic,$pass,$_SESSION['user_id']);
    } else {
        $stmt = $mysqli->prepare('UPDATE users SET name=?, email=?, profile_pic=? WHERE id=?');
        $stmt->bind_param('sssi',$name,$email,$pic,$_SESSION['user_id']);
    }
    if($stmt->execute()) $msg='Profile updated';
    else $msg='Error updating';
    // refresh user data
    $user = current_user();
}
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Profile - e-LapFa</title><link rel="stylesheet" href="../assets/css/style.css"></head><body class="layout">
<aside class="sidenav"><div class="brand">e-LapFa</div><nav><a href="dashboard.php">Dashboard</a><a href="profile.php" class="active">Profile</a><a href="complaint_submit.php">Submit</a><a href="my_complaints.php">My Complaints</a><a href="../chat/chat.php">Chat</a><a href="../logout.php">Logout</a></nav></aside>
<main class="content">
  <header class="topbar"><div>Profile</div></header>
  <section class="card" style="max-width:700px">
    <?php if($msg) echo '<div class="success">'.htmlspecialchars($msg).'</div>'; ?>
    <form method="post" enctype="multipart/form-data">
      <label>Name<input name="name" required value="<?php echo htmlspecialchars($user['name']); ?>"></label>
      <label>Email<input name="email" type="email" required value="<?php echo htmlspecialchars($user['email']); ?>"></label>
      <label>Profile Picture<input type="file" name="profile_pic"></label>
      <label>New Password (leave blank to keep current)<input type="password" name="password"></label>
      <button class="btn">Save</button>
    </form>
  </section>
</main>
<script src="../assets/js/app.js"></script>
</body></html>
