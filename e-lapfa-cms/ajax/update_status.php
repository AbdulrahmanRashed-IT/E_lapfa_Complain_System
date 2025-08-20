<?php
session_start();
header('Content-Type: application/json');
require_once '../includes/db.php';
require_once '../includes/functions.php';
if(empty($_SESSION['user_id']) || !is_admin()){ echo json_encode(['success'=>false,'msg'=>'unauth']); exit; }
$id = intval($_POST['id'] ?? 0);
$status = $_POST['status'] ?? '';
if(!in_array($status, ['Pending','In Progress','Resolved'])){ echo json_encode(['success'=>false]); exit; }
$stmt = $mysqli->prepare('UPDATE complaints SET status=?, updated_at=NOW() WHERE id=?');
$stmt->bind_param('si',$status,$id); $ok = $stmt->execute();
if($ok){
    // notify users could be implemented (here simple)
    echo json_encode(['success'=>true]);
}else echo json_encode(['success'=>false]);
?>