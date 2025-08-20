<?php
session_start();
require_once '../includes/db.php';
if(empty($_SESSION['user_id'])){ header('Location: /e-lapfa-complaint-system/'); exit; }
$id = intval($_GET['id'] ?? 0);
$stmt = $mysqli->prepare('DELETE FROM complaints WHERE id=? AND user_id=?');
$stmt->bind_param('ii',$id,$_SESSION['user_id']); $stmt->execute();
header('Location: my_complaints.php'); exit;
?>