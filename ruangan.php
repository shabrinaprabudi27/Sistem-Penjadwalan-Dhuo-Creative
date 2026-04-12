<?php
$title = "Menu Ruangan - Dhuo Creative";
$pageTitle = "Menu Ruangan";
$active = "ruangan";
require 'inc/db.php';
include 'inc/layout_top.php';

$RUANGAN = db_all("SELECT ruangan_id, nomor_ruangan AS kode FROM ruangan ORDER BY ruangan_id DESC");
?>
<div class="cardx tablecard">
  <div class="toolbar">
    <div class="searchbox">
      <span style="opacity:.65">🔎</span>
      <input placeholder="Cari ruangan..." oninput="filterTable(this.value,'tblRuangan')">
    </div>
    <?php if($ROLE==='superadmin'): ?>
      <button class="btnx" data-bs-toggle="modal" data-bs-target="#modalRuangan">+ Tambah</button>
    <?php endif; ?>
  </div>

  <div class="tablewrap">
    <table class="tablex" id="tblRuangan">
      <thead><tr><th>Kode Ruangan</th><?php if($ROLE==='superadmin'): ?><th style="width:180px">Aksi</th><?php endif; ?></tr></thead>
      <tbody>
        <?php foreach($RUANGAN as $row): ?>
        <tr>
          <td><b><?= htmlspecialchars($row['kode']) ?></b></td>
          <?php if($ROLE==='superadmin'): ?>
          <td>
            <div class="actions">
              <button
                class="iconbtn btnEditRuangan"
                type="button"
                data-bs-toggle="modal"
                data-bs-target="#modalRuangan"
                data-id="<?= (int)$row['ruangan_id'] ?>"
                data-kode="<?= htmlspecialchars($row['kode'], ENT_QUOTES) ?>"
              >Edit</button>

              <form method="post" action="ruangan_action.php" style="display:inline" onsubmit="return confirm('Hapus data ruangan ini?')">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="ruangan_id" value="<?= (int)$row['ruangan_id'] ?>">
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
<div class="modal fade" id="modalRuangan" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ttlRuangan" style="font-weight:950;">Tambah Ruangan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="post" action="ruangan_action.php">
        <div class="modal-body">
          <input type="hidden" name="action" id="actRuangan" value="create">
          <input type="hidden" name="ruangan_id" id="idRuangan" value="">
          <label class="form-label fw-bold">Kode Ruangan</label>
          <input class="form-control" name="nomor_ruangan" id="kodeRuangan" placeholder="contoh: R-05" required>
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
const modalRuangan = document.getElementById('modalRuangan');
modalRuangan.addEventListener('show.bs.modal', (event)=>{
  const btn = event.relatedTarget;
  if(btn && btn.classList.contains('btnEditRuangan')) return;
  document.getElementById('ttlRuangan').innerText = 'Tambah Ruangan';
  document.getElementById('actRuangan').value = 'create';
  document.getElementById('idRuangan').value = '';
  document.getElementById('kodeRuangan').value = '';
});


document.querySelectorAll('.btnEditRuangan').forEach(b=>{
  b.addEventListener('click', ()=>{
    document.getElementById('ttlRuangan').innerText = 'Edit Ruangan';
    document.getElementById('actRuangan').value = 'update';
    document.getElementById('idRuangan').value = b.dataset.id || '';
    document.getElementById('kodeRuangan').value = b.dataset.kode || '';
  });
});
<?php endif; ?>
</script>
<?php include 'inc/layout_bottom.php'; ?>
