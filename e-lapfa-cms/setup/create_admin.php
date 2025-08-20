<?php
require_once __DIR__ . '/../includes/db.php';
// create admin if missing
$exists = $mysqli->query("SELECT id FROM users WHERE email='admin@example.com'")->fetch_assoc();
if($exists){ echo 'Admin already exists.'; exit; }
$pass = password_hash('admin123', PASSWORD_BCRYPT);
$stmt = $mysqli->prepare('INSERT INTO users (name,email,password,role) VALUES (?,?,?,"admin")');
$name='Default Admin'; $email='admin@example.com';
$stmt->bind_param('sss',$name,$email,$pass);
if($stmt->execute()) echo 'Admin created: admin@example.com / admin123';
else echo 'Error: '.$mysqli->error;
?>