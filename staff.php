<?php
$title = "Menu Staff - Dhuo Creative";
$pageTitle = "Menu Staff";
$active = "staff";
require 'inc/db.php';
include 'inc/layout_top.php';
?>
<?php if($ROLE!=='superadmin'): ?>
  <div class="notice">Akses staff hanya untuk <b>superadmin</b>.</div>
<?php else: ?>

<?php
$STAFF = db_all("SELECT staff_id, nama, no_hp AS kontak FROM staff ORDER BY staff_id DESC");
?>
<div class="cardx tablecard">
  <div class="toolbar">
    <div class="searchbox">
      <span style="opacity:.65">🔎</span>
      <input placeholder="Cari staff..." oninput="filterTable(this.value,'tblStaff')">
    </div>
    <button class="btnx" data-bs-toggle="modal" data-bs-target="#modalStaff">+ Tambah</button>
  </div>

  <div class="tablewrap">
    <table class="tablex" id="tblStaff">
      <thead><tr><th>Nama</th><th>Kontak</th><th style="width:180px">Aksi</th></tr></thead>
      <tbody>
        <?php foreach($STAFF as $row): ?>
        <tr>
          <td><b><?= htmlspecialchars($row['nama']) ?></b></td>
          <td><?= htmlspecialchars($row['kontak']) ?></td>
          <td>
            <div class="actions">
              <button
                class="iconbtn btnEditStaff"
                type="button"
                data-bs-toggle="modal"
                data-bs-target="#modalStaff"
                data-id="<?= (int)$row['staff_id'] ?>"
                data-nama="<?= htmlspecialchars($row['nama'], ENT_QUOTES) ?>"
                data-kontak="<?= htmlspecialchars($row['kontak'], ENT_QUOTES) ?>"
              >Edit</button>

              <form method="post" action="staff_action.php" style="display:inline" onsubmit="return confirm('Hapus data staff ini?')">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="staff_id" value="<?= (int)$row['staff_id'] ?>">
                <button class="iconbtn danger" type="submit">Hapus</button>
              </form>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="modalStaff" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ttlStaff" style="font-weight:950;">Tambah Data Staff</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="post" action="staff_action.php">
        <div class="modal-body">
          <input type="hidden" name="action" id="actStaff" value="create">
          <input type="hidden" name="staff_id" id="idStaff" value="">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-bold">Nama</label>
              <input class="form-control" name="nama" id="namaStaff" placeholder="Nama staff" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Kontak</label>
              <input class="form-control" name="no_hp" id="hpStaff" placeholder="Nomor HP">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btnx secondary" type="button" data-bs-dismiss="modal">Batal</button>
          <button class="btnx" type="submit">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function filterTable(q, id){
  q = (q||'').toLowerCase();
  const rows = document.querySelectorAll('#'+id+' tbody tr');
  rows.forEach(r=>{
    const t = r.innerText.toLowerCase();
    r.style.display = t.includes(q) ? '' : 'none';
  });
}


const modalStaff = document.getElementById('modalStaff');
modalStaff.addEventListener('show.bs.modal', (event)=>{
  const btn = event.relatedTarget;
  if(btn && btn.classList.contains('btnEditStaff')) return;
  document.getElementById('ttlStaff').innerText = 'Tambah Data Staff';
  document.getElementById('actStaff').value = 'create';
  document.getElementById('idStaff').value = '';
  document.getElementById('namaStaff').value = '';
  document.getElementById('hpStaff').value = '';
});


document.querySelectorAll('.btnEditStaff').forEach(b=>{
  b.addEventListener('click', ()=>{
    document.getElementById('ttlStaff').innerText = 'Edit Data Staff';
    document.getElementById('actStaff').value = 'update';
    document.getElementById('idStaff').value = b.dataset.id || '';
    document.getElementById('namaStaff').value = b.dataset.nama || '';
    document.getElementById('hpStaff').value = b.dataset.kontak || '';
  });
});
</script>
<?php endif; ?>
<?php include 'inc/layout_bottom.php'; ?>
