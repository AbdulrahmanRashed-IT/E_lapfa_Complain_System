<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';
if(empty($_SESSION['user_id'])){ http_response_code(403); exit; }
$user = current_user();
$message = trim($_POST['message'] ?? '');
$sender = ($_POST['sender'] ?? 'user');
if($message === ''){ echo json_encode(['success'=>false]); exit; }
$stmt = $mysqli->prepare('INSERT INTO messages (user_id,sender,message) VALUES (?,?,?)');
$uid = $user['id'];
$stmt->bind_param('iss',$uid,$sender,$message);
$ok = $stmt->execute();
echo json_encode(['success'=>(bool)$ok]);
?>