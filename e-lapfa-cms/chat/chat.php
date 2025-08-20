<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';
if(empty($_SESSION['user_id'])){ header('Location: /e-lapfa-complaint-system/'); exit; }
$user = current_user();
?>
<!doctype html><html><head><meta charset="utf-8"><title>Chat</title><link rel="stylesheet" href="../assets/css/style.css"></head><body class="layout">
<aside class="sidenav"><div class="brand">e-LapFa</div></aside>
<main class="content">
  <section class="card">
    <h2>Chat with Admin</h2>
    <div id="messages" class="chatbox"></div>
    <form id="msgForm">
      <input id="msg" placeholder="Type a message">
      <button>Send</button>
    </form>
  </section>
</main>
<script>
async function fetchMsgs(){
  const r = await fetch('../ajax/chat_fetch.php');
  const j = await r.json();
  const box = document.getElementById('messages');
  box.innerHTML = j.map(m => '<div class="msg '+m.sender+'"><strong>'+m.sender+':</strong> '+m.message+'</div>').join('');
  box.scrollTop = box.scrollHeight;
}
document.getElementById('msgForm').addEventListener('submit', async function(e){
  e.preventDefault();
  const t = document.getElementById('msg').value;
  if(!t) return;
  await fetch('../ajax/chat_send.php',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:'message='+encodeURIComponent(t)});
  document.getElementById('msg').value = '';
  fetchMsgs();
});
fetchMsgs();
setInterval(fetchMsgs, 3000);
</script>
</body></html>
