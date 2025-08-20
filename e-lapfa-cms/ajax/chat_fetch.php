<?php
session_start();
require_once '../includes/db.php';
if(empty($_SESSION['user_id'])){ echo json_encode([]); exit; }
$res = $mysqli->query('SELECT sender,message,created_at FROM messages ORDER BY id ASC LIMIT 500');
$out = [];
while($r = $res->fetch_assoc()) $out[] = $r;
header('Content-Type: application/json'); echo json_encode($out);
?>