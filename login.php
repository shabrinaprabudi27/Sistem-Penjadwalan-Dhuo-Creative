<?php
session_start();
if(isset($_SESSION['role'])){ header('Location: dashboard.php'); exit; }
$err = $_GET['err'] ?? '';
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login - Dhuo Creative</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
:root{
  --bg:#f4f6f8; --card:#fff; --line:#e5e7eb; --text:#111827; --muted:#6b7280;
  --brand:#0f3f3e; --brand2:#22c55e;
  --shadow: 0 14px 34px rgba(17,24,39,.12);
  --radius:18px;
}
body{
  margin:0; min-height:100vh; display:flex; align-items:center; justify-content:center;
  background:
    radial-gradient(900px 600px at 12% 10%, rgba(34,197,94,.10), transparent 55%),
    radial-gradient(900px 600px at 88% 18%, rgba(249,115,22,.10), transparent 55%),
    linear-gradient(180deg, #f8fbfa, var(--bg));
  font-family:system-ui,-apple-system,Segoe UI,Roboto,sans-serif;
  color:var(--text);
  padding:22px;
}
.login-card{
  width:100%; max-width:440px;
  background:var(--card);
  border:1px solid var(--line);
  border-radius:var(--radius);
  box-shadow:var(--shadow);
  overflow:hidden;
}
.header{
  padding:18px 18px 14px 18px;
  border-bottom:1px solid var(--line);
  display:flex; align-items:center; gap:12px;
}
.header img{ width:42px; height:42px; object-fit:contain; }
.header .t{ font-weight:950; line-height:1.1; }
.header .t small{ display:block; margin-top:4px; font-weight:800; color:var(--muted); }
.body{ padding:18px; }
.field{ position:relative; margin-bottom:12px; }
.field input{
  width:100%;
  border-radius:14px;
  border:1px solid var(--line);
  padding:12px 44px 12px 44px;
  background:#fbfdfc;
  font-weight:700;
}
.field input:focus{
  outline:none;
  border-color: rgba(34,197,94,.35);
  box-shadow:0 0 0 .2rem rgba(34,197,94,.12);
  background:#fff;
}
.iconL{ position:absolute; left:14px; top:50%; transform:translateY(-50%); opacity:.65; }
.eye{
  position:absolute; right:10px; top:50%; transform:translateY(-50%);
  border:0; background:transparent; padding:6px 10px;
  border-radius:12px; color:var(--muted); font-weight:900;
}
.eye:hover{ background: rgba(17,24,39,.05); }
.btn-login{
  width:100%; border:0; border-radius:14px; padding:12px 14px;
  background: linear-gradient(135deg, var(--brand), var(--brand2));
  color:#fff; font-weight:950;
  box-shadow: 0 12px 22px rgba(15,63,62,.18);
}
.foot{ text-align:center; margin-top:12px; color:var(--muted); font-size:.86rem; }
</style>
</head>
<body>
  <div class="login-card">
    <div class="header">
      <img src="assets/logo.svg" alt="Dhuo Creative">
      <div class="t">
        Sistem Penjadwalan Kelas
        <small>Dhuo Creative</small>
      </div>
    </div>

    <div class="body">
      <?php if($err): ?>
        <div class="alert alert-danger py-2 text-center">Username atau password salah.</div>
      <?php endif; ?>

      <form method="post" action="proses_login.php">
        <div class="field">
          <span class="iconL">👤</span>
          <input name="username" placeholder="Username" required>
        </div>

        <div class="field">
          <span class="iconL">🔒</span>
          <input id="pw" name="password" type="password" placeholder="Password" required>
          <button class="eye" type="button" onclick="togglePw()" aria-label="Lihat password">👁️</button>
        </div>

        <button class="btn-login" type="submit">Masuk</button>
      </form>

      <div class="foot">© <?= date('Y') ?> Dhuo Creative</div>
    </div>
  </div>

<script>
function togglePw(){
  const pw = document.getElementById('pw');
  pw.type = (pw.type === 'password') ? 'text' : 'password';
}
</script>
</body>
</html>
