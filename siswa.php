<?php
$title = "Menu Siswa - Dhuo Creative";
$pageTitle = "Menu Siswa";
$active = "siswa";
require 'inc/db.php';
include 'inc/layout_top.php';

$SISWA = db_all("SELECT siswa_id, nama, no_hp AS kontak, alamat, kursus FROM siswa ORDER BY siswa_id DESC");
?>
<div class="cardx tablecard">
  <div class="toolbar">
    <div class="searchbox">
      <span style="opacity:.65">🔎</span>
      <input placeholder="Cari nama/kontak/alamat/kursus..." oninput="filterTable(this.value,'tblSiswa')">
    </div>
    <?php if($ROLE==='superadmin' || $ROLE==='admin'): ?>
      <button class="btnx" data-bs-toggle="modal" data-bs-target="#modalSiswa">+ Tambah</button>
    <?php endif; ?>
  </div>

  <div class="tablewrap">
    <table class="tablex" id="tblSiswa">
      <thead>
        <tr><th>Nama</th><th>Kontak</th><th>Alamat</th><th>Kursus</th><?php if($ROLE==='superadmin'): ?><th style="width:180px">Aksi</th><?php endif; ?></tr>
      </thead>
      <tbody>
        <?php foreach($SISWA as $row): ?>
        <tr>
          <td><b><?= htmlspecialchars($row['nama']) ?></b></td>
          <td><?= htmlspecialchars($row['kontak']) ?></td>
          <td><?= htmlspecialchars($row['alamat']) ?></td>
          <td><span class="pill"><?= htmlspecialchars($row['kursus']) ?></span></td>
          <?php if($ROLE==='superadmin'): ?>
          <td>
            <div class="actions">
              <button
                class="iconbtn btnEditSiswa"
                type="button"
                data-bs-toggle="modal"
                data-bs-target="#modalSiswa"
                data-id="<?= (int)$row['siswa_id'] ?>"
                data-nama="<?= htmlspecialchars($row['nama'], ENT_QUOTES) ?>"
                data-kontak="<?= htmlspecialchars($row['kontak'], ENT_QUOTES) ?>"
                data-alamat="<?= htmlspecialchars($row['alamat'], ENT_QUOTES) ?>"
                data-kursus="<?= htmlspecialchars($row['kursus'], ENT_QUOTES) ?>"
              >Edit</button>

              <form method="post" action="siswa_action.php" style="display:inline" onsubmit="return confirm('Hapus data siswa ini?')">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="siswa_id" value="<?= (int)$row['siswa_id'] ?>">
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


<div class="modal fade" id="modalSiswa" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ttlSiswa" style="font-weight:950;">Tambah Data Siswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="post" action="siswa_action.php">
        <div class="modal-body">
          <input type="hidden" name="action" id="actSiswa" value="create">
          <input type="hidden" name="siswa_id" id="idSiswa" value="">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-bold">Nama</label>
              <input class="form-control" name="nama" id="namaSiswa" placeholder="Nama siswa" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Kontak</label>
              <input class="form-control" name="no_hp" id="hpSiswa" placeholder="Nomor HP">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Alamat</label>
              <input class="form-control" name="alamat" id="alamatSiswa" placeholder="Alamat">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Kursus</label>
              <select class="form-select" name="kursus" id="kursusSiswa" required>
                <option>Design</option><option>Programming</option><option>Ms Office</option>
              </select>
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


const modalSiswa = document.getElementById('modalSiswa');
modalSiswa.addEventListener('show.bs.modal', (event)=>{
  const btn = event.relatedTarget;
  if(btn && btn.classList.contains('btnEditSiswa')) return;
  document.getElementById('ttlSiswa').innerText = 'Tambah Data Siswa';
  document.getElementById('actSiswa').value = 'create';
  document.getElementById('idSiswa').value = '';
  document.getElementById('namaSiswa').value = '';
  document.getElementById('hpSiswa').value = '';
  document.getElementById('alamatSiswa').value = '';
  document.getElementById('kursusSiswa').value = 'Design';
});

document.querySelectorAll('.btnEditSiswa').forEach(b=>{
  b.addEventListener('click', ()=>{
    document.getElementById('ttlSiswa').innerText = 'Edit Data Siswa';
    document.getElementById('actSiswa').value = 'update';
    document.getElementById('idSiswa').value = b.dataset.id || '';
    document.getElementById('namaSiswa').value = b.dataset.nama || '';
    document.getElementById('hpSiswa').value = b.dataset.kontak || '';
    document.getElementById('alamatSiswa').value = b.dataset.alamat || '';
    document.getElementById('kursusSiswa').value = b.dataset.kursus || 'Design';
  });
});
</script>
<?php include 'inc/layout_bottom.php'; ?>
