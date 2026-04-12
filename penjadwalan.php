<?php
$title = "Menu Penjadwalan - Dhuo Creative";
$pageTitle = "Menu Penjadwalan";
$active = "penjadwalan";
require 'inc/db.php';
include 'inc/layout_top.php';

$SISWA = db_all("SELECT siswa_id, nama FROM siswa ORDER BY nama ASC");
$STAFF = db_all("SELECT staff_id, nama FROM staff ORDER BY nama ASC");
$MEJA = db_all("SELECT meja_id, nomor_meja AS kode FROM meja ORDER BY nomor_meja ASC");
$RUANGAN = db_all("SELECT ruangan_id, nomor_ruangan AS kode FROM ruangan ORDER BY nomor_ruangan ASC");

$JADWAL = db_all(
  "SELECT j.jadwal_id,
          j.siswa_id, j.staff_id, j.meja_id, j.ruangan_id,
          s.nama AS siswa,
          st.nama AS staff,
          m.nomor_meja AS meja,
          r.nomor_ruangan AS ruangan,
          j.hari, j.jam
   FROM jadwal j
   JOIN siswa s ON s.siswa_id = j.siswa_id
   JOIN staff st ON st.staff_id = j.staff_id
   JOIN meja m ON m.meja_id = j.meja_id
   JOIN ruangan r ON r.ruangan_id = j.ruangan_id
   ORDER BY j.jadwal_id DESC"
);

$conflict = isset($_GET['conflict']);
?>

<?php if($conflict): ?>
  <div class="notice">Jadwal bentrok. Sistem menolak penyimpanan karena ruangan/meja/staff sudah terpakai pada hari dan jam yang sama.</div>
<?php endif; ?>
<div class="cardx tablecard">
  <div class="toolbar">
    <div class="searchbox">
      <span style="opacity:.65">🔎</span>
      <input placeholder="Cari jadwal..." oninput="filterTable(this.value,'tblJadwal')">
    </div>
    <?php if($ROLE==='superadmin'): ?>
      <button class="btnx" data-bs-toggle="modal" data-bs-target="#modalJadwal">+ Tambah Jadwal</button>
    <?php endif; ?>
  </div>

  <div class="tablewrap">
    <table class="tablex" id="tblJadwal">
      <thead>
        <tr>
          <th>Siswa</th><th>Staff</th><th>Meja</th><th>Ruangan</th><th>Hari</th><th>Jam</th><th>Status</th>
          <?php if($ROLE==='superadmin'): ?><th style="width:180px">Aksi</th><?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach($JADWAL as $row): ?>
        <tr>
          <td><b><?= htmlspecialchars($row['siswa']) ?></b></td>
          <td><?= htmlspecialchars($row['staff']) ?></td>
          <td><span class="pill"><?= htmlspecialchars($row['meja']) ?></span></td>
          <td><span class="pill"><?= htmlspecialchars($row['ruangan']) ?></span></td>
          <td><?= htmlspecialchars($row['hari']) ?></td>
          <td><?= htmlspecialchars($row['jam']) ?></td>
          <td><span class="pill">Tersimpan</span></td>
          <?php if($ROLE==='superadmin'): ?>
          <td>
            <div class="actions">
              <button
                class="iconbtn btnEditJadwal"
                type="button"
                data-bs-toggle="modal"
                data-bs-target="#modalJadwal"
                data-id="<?= (int)$row['jadwal_id'] ?>"
                data-siswa="<?= (int)$row['siswa_id'] ?>"
                data-staff="<?= (int)$row['staff_id'] ?>"
                data-meja="<?= (int)$row['meja_id'] ?>"
                data-ruangan="<?= (int)$row['ruangan_id'] ?>"
                data-hari="<?= htmlspecialchars($row['hari'], ENT_QUOTES) ?>"
                data-jam="<?= htmlspecialchars($row['jam'], ENT_QUOTES) ?>"
              >Edit</button>

              <form method="post" action="penjadwalan_action.php" style="display:inline" onsubmit="return confirm('Hapus jadwal ini?')">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="jadwal_id" value="<?= (int)$row['jadwal_id'] ?>">
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
<div class="modal fade" id="modalJadwal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ttlJadwal" style="font-weight:950;">Tambah Jadwal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="post" action="penjadwalan_action.php">
      <div class="modal-body">
        <input type="hidden" name="action" id="actJadwal" value="create">
        <input type="hidden" name="jadwal_id" id="idJadwal" value="">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-bold">Siswa</label>
            <select class="form-select" name="siswa_id" id="siswaJadwal" required>
              <?php foreach($SISWA as $s): ?><option value="<?= (int)$s['siswa_id'] ?>"><?= htmlspecialchars($s['nama']) ?></option><?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Staff</label>
            <select class="form-select" name="staff_id" id="staffJadwal" required>
              <?php foreach($STAFF as $s): ?><option value="<?= (int)$s['staff_id'] ?>"><?= htmlspecialchars($s['nama']) ?></option><?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Meja</label>
            <select class="form-select" name="meja_id" id="mejaJadwal" required>
              <?php foreach($MEJA as $m): ?><option value="<?= (int)$m['meja_id'] ?>"><?= htmlspecialchars($m['kode']) ?></option><?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Ruangan</label>
            <select class="form-select" name="ruangan_id" id="ruanganJadwal" required>
              <?php foreach($RUANGAN as $r): ?><option value="<?= (int)$r['ruangan_id'] ?>"><?= htmlspecialchars($r['kode']) ?></option><?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Hari</label>
            <select class="form-select" name="hari" id="hariJadwal" required>
              <option>Senin</option><option>Selasa</option><option>Rabu</option><option>Kamis</option><option>Jumat</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Jam</label>
            <input class="form-control" name="jam" id="jamJadwal" placeholder="contoh: 09.00-11.00" required>
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
const modalJadwal = document.getElementById('modalJadwal');
modalJadwal.addEventListener('show.bs.modal', (event)=>{
  const btn = event.relatedTarget;
  if(btn && btn.classList.contains('btnEditJadwal')) return;
  document.getElementById('ttlJadwal').innerText = 'Tambah Jadwal';
  document.getElementById('actJadwal').value = 'create';
  document.getElementById('idJadwal').value = '';
  if(document.getElementById('hariJadwal')) document.getElementById('hariJadwal').value = 'Senin';
  document.getElementById('jamJadwal').value = '';
});


document.querySelectorAll('.btnEditJadwal').forEach(b=>{
  b.addEventListener('click', ()=>{
    document.getElementById('ttlJadwal').innerText = 'Edit Jadwal';
    document.getElementById('actJadwal').value = 'update';
    document.getElementById('idJadwal').value = b.dataset.id || '';
    document.getElementById('siswaJadwal').value = b.dataset.siswa || '';
    document.getElementById('staffJadwal').value = b.dataset.staff || '';
    document.getElementById('mejaJadwal').value = b.dataset.meja || '';
    document.getElementById('ruanganJadwal').value = b.dataset.ruangan || '';
    document.getElementById('hariJadwal').value = b.dataset.hari || 'Senin';
    document.getElementById('jamJadwal').value = b.dataset.jam || '';
  });
});
<?php endif; ?>
</script>
<?php include 'inc/layout_bottom.php'; ?>
