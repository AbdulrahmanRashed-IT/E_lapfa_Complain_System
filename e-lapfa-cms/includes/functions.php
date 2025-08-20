<?php
require_once __DIR__ . '/db.php';

function esc($v){
    return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
}

function current_user(){
    if(session_status() === PHP_SESSION_NONE) session_start();
    if(!empty($_SESSION['user_id'])){
        global $mysqli;
        $stmt = $mysqli->prepare("SELECT id,name,email,role,profile_pic FROM users WHERE id=?");
        $stmt->bind_param('i', $_SESSION['user_id']);
        $stmt->execute();
        $res = $stmt->get_result();
        $u = $res->fetch_assoc();
        if($u && empty($u['profile_pic'])) $u['profile_pic'] = 'assets/images/default-profile.png';
        return $u;
    }
    return null;
}

function is_admin(){
    $u = current_user();
    return $u && $u['role'] === 'admin';
}

function upload_file($file, $dest_dir='uploads'){
    if(!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) return null;
    $allowed = ['image/png','image/jpeg','application/pdf'];
    if($file['size'] > 2*1024*1024) return null;
    if(!in_array($file['type'], $allowed)) return null;
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $name = uniqid().".".$ext;
    if(!is_dir($dest_dir)) mkdir($dest_dir, 0755, true);
    $path = $dest_dir . '/' . $name;
    if(move_uploaded_file($file['tmp_name'], $path)) return $path;
    return null;
}
?>