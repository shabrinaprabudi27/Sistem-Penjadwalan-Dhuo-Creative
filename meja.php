<?php
$title = "Menu Meja - Dhuo Creative";
$pageTitle = "Menu Meja";
$active = "meja";
require 'inc/db.php';
include 'inc/layout_top.php';

$MEJA = db_all("SELECT meja_id, nomor_meja AS kode FROM meja ORDER BY meja_id DESC");
?>
<div class="cardx tablecard">
  <div class="toolbar">
    <div class="searchbox">
      <span style="opacity:.65">🔎</span>
      <input placeholder="Cari meja..." oninput="filterTable(this.value,'tblMeja')">
    </div>
    <?php if($ROLE==='superadmin'): ?>
      <button class="btnx" data-bs-toggle="modal" data-bs-target="#modalMeja">+ Tambah</button>
    <?php endif; ?>
  </div>

  <div class="tablewrap">
    <table class="tablex" id="tblMeja">
      <thead><tr><th>Kode Meja</th><?php if($ROLE==='superadmin'): ?><th style="width:180px">Aksi</th><?php endif; ?></tr></thead>
      <tbody>
        <?php foreach($MEJA as $row): ?>
        <tr>
          <td><b><?= htmlspecialchars($row['kode']) ?></b></td>
          <?php if($ROLE==='superadmin'): ?>
          <td>
            <div class="actions">
              <button
                class="iconbtn btnEditMeja"
                type="button"
                data-bs-toggle="modal"
                data-bs-target="#modalMeja"
                data-id="<?= (int)$row['meja_id'] ?>"
                data-kode="<?= htmlspecialchars($row['kode'], ENT_QUOTES) ?>"
              >Edit</button>

              <form method="post" action="meja_action.php" style="display:inline" onsubmit="return confirm('Hapus data meja ini?')">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="meja_id" value="<?= (int)$row['meja_id'] ?>">
                <button class="iconbtn danger" type="submit">Hapus</button>
              </form>
            </div>
          </td>
          <?php endif; ?>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php if($ROLE==='superadmin'): ?>
<div class="modal fade" id="modalMeja" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ttlMeja" style="font-weight:950;">Tambah Meja</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="post" action="meja_action.php">
        <div class="modal-body">
          <input type="hidden" name="action" id="actMeja" value="create">
          <input type="hidden" name="meja_id" id="idMeja" value="">
          <label class="form-label fw-bold">Kode Meja</label>
          <input class="form-control" name="nomor_meja" id="kodeMeja" placeholder="contoh: M-06" required>
        </div>
        <div class="modal-footer">
          <button class="btnx secondary" type="button" data-bs-dismiss="modal">Batal</button>
          <button class="btnx" type="submit">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>

<script>
function filterTable(q, id){
  q = (q||'').toLowerCase();
  const rows = document.querySelectorAll('#'+id+' tbody tr');
  rows.forEach(r=>{
    const t = r.innerText.toLowerCase();
    r.style.display = t.includes(q) ? '' : 'none';
  });
}

<?php if($ROLE==='superadmin'): ?>
const modalMeja = document.getElementById('modalMeja');
modalMeja.addEventListener('show.bs.modal', (event)=>{
  const btn = event.relatedTarget;
  if(btn && btn.classList.contains('btnEditMeja')) return;
  document.getElementById('ttlMeja').innerText = 'Tambah Meja';
  document.getElementById('actMeja').value = 'create';
  document.getElementById('idMeja').value = '';
  document.getElementById('kodeMeja').value = '';
});

document.querySelectorAll('.btnEditMeja').forEach(b=>{
  b.addEventListener('click', ()=>{
    document.getElementById('ttlMeja').innerText = 'Edit Meja';
    document.getElementById('actMeja').value = 'update';
    document.getElementById('idMeja').value = b.dataset.id || '';
    document.getElementById('kodeMeja').value = b.dataset.kode || '';
  });
});
<?php endif; ?>
</script>
<?php include 'inc/layout_bottom.php'; ?>
