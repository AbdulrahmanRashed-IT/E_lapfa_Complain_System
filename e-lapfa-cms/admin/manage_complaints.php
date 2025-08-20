<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';
if(empty($_SESSION['user_id']) || !is_admin()){ header('Location: /e-lapfa-complaint-system/'); exit; }
$stmt = $mysqli->prepare('SELECT c.*, u.name as user_name FROM complaints c JOIN users u ON u.id=c.user_id ORDER BY c.created_at DESC');
$stmt->execute(); $res = $stmt->get_result();
?>
<!doctype html><html><head><meta charset="utf-8"><title>Manage Complaints</title><link rel="stylesheet" href="../assets/css/style.css"></head><body class="layout">
<aside class="sidenav"><div class="brand">e-LapFa Admin</div></aside>
<main class="content"><section class="card"><h2>Complaints</h2>
<table class="table"><tr><th>User</th><th>Title</th><th>Status</th><th>Action</th></tr>
<?php while($r = $res->fetch_assoc()): ?>
<tr>
<td><?php echo esc($r['user_name']); ?></td>
<td><?php echo esc($r['title']); ?></td>
<td id="st-<?php echo $r['id']; ?>"><?php echo esc($r['status']); ?></td>
<td>
<select onchange="updateStatus(<?php echo $r['id']; ?>, this.value)">
  <option value="Pending" <?php if($r['status']=='Pending') echo 'selected'; ?>>Pending</option>
  <option value="In Progress" <?php if($r['status']=='In Progress') echo 'selected'; ?>>In Progress</option>
  <option value="Resolved" <?php if($r['status']=='Resolved') echo 'selected'; ?>>Resolved</option>
</select>
</td>
</tr>
<?php endwhile; ?>
</table>
</section></main>
<script>
function updateStatus(id, status){
  fetch('../ajax/update_status.php', {
    method:'POST',
    headers:{'Content-Type':'application/x-www-form-urlencoded'},
    body:'id='+encodeURIComponent(id)+'&status='+encodeURIComponent(status)
  }).then(r=>r.json()).then(j=>{
    if(j.success){
      document.getElementById('st-'+id).innerText = status;
      Swal.fire({icon:'success',title:'Updated'});
    } else {
      Swal.fire({icon:'error',title:'Error'});
    }
  });
}
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body></html>
