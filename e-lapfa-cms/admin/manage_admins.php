<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';
if(empty($_SESSION['user_id']) || !is_admin()){ header('Location: login.php'); exit; }
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['action'])){
    $act = $_POST['action'];
    if($act==='add'){
        $name=$_POST['name']; $email=$_POST['email']; $pass=password_hash($_POST['password'], PASSWORD_BCRYPT);
        $stmt = $mysqli->prepare('INSERT INTO users (name,email,password,role) VALUES (?,?,?,"admin")');
        $stmt->bind_param('sss',$name,$email,$pass); $stmt->execute();
    } elseif($act==='delete'){
        $id = intval($_POST['id']); $mysqli->query('DELETE FROM users WHERE id=' . $id . ' AND role="admin"');
    }
}
$res = $mysqli->query('SELECT id,name,email,created_at FROM users WHERE role="admin" ORDER BY id DESC');
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Manage Admins</title><link rel="stylesheet" href="../assets/css/style.css"></head><body class="layout">
<aside class="sidenav"><div class="brand">e-LapFa Admin</div><nav><a href="dashboard.php">Dashboard</a><a href="manage_users.php">Manage Users</a><a href="manage_complaints.php">Manage Complaints</a><a href="manage_admins.php" class="active">Manage Admins</a><a href="../logout.php">Logout</a></nav></aside>
<main class="content"><section class="card"><h2>Admins</h2>
<form method="post" style="display:flex;gap:.5rem;margin-bottom:1rem"><input name="name" placeholder="Name" required><input name="email" placeholder="Email" required><input name="password" placeholder="Password" required><input type="hidden" name="action" value="add"><button class="btn">Add Admin</button></form>
<table class="table"><tr><th>Name</th><th>Email</th><th>Created</th><th>Action</th></tr>
<?php while($r = $res->fetch_assoc()): ?>
<tr><td><?php echo esc($r['name']); ?></td><td><?php echo esc($r['email']); ?></td><td><?php echo esc($r['created_at']); ?></td><td>
<form method="post" style="display:inline"><input type="hidden" name="id" value="<?php echo $r['id']; ?>"><input type="hidden" name="action" value="delete"><button class="btn">Delete</button></form></td></tr>
<?php endwhile; ?>
</table></section></main>
</body></html>
