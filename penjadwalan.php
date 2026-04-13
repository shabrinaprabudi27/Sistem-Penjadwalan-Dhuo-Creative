<?php
$title = "Menu Jadwal - Dhuo Creative";
$pageTitle = "Menu Penjadwalan";
$active = "jadwal";
require 'inc/db.php';
include 'inc/layout_top.php';

$JADWAL = db_all("
SELECT j.*, 
s.nama AS siswa, 
st.nama AS staff,
m.nomor_meja, 
r.nomor_ruangan
FROM jadwal j
JOIN siswa s ON j.siswa_id = s.siswa_id
JOIN staff st ON j.staff_id = st.staff_id
JOIN meja m ON j.meja_id = m.meja_id
JOIN ruangan r ON j.ruangan_id = r.ruangan_id
ORDER BY j.tanggal DESC, j.jam_mulai ASC
");

$SISWA = db_all("SELECT siswa_id, nama FROM siswa");
$STAFF = db_all("SELECT staff_id, nama FROM staff");
$MEJA = db_all("SELECT meja_id, nomor_meja FROM meja");
$RUANGAN = db_all("SELECT ruangan_id, nomor_ruangan FROM ruangan");
?>

<div class="cardx tablecard">
  <div class="toolbar">
    <div class="searchbox">
      <span style="opacity:.65">🔎</span>
      <input placeholder="Cari jadwal..." oninput="filterTable(this.value,'tblJadwal')">
    </div>
    <?php if($ROLE==='superadmin'): ?>
      <button class="btnx" data-bs-toggle="modal" data-bs-target="#modalJadwal">+ Tambah</button>
    <?php endif; ?>
  </div>

  <div class="tablewrap">
    <table class="tablex" id="tblJadwal">
      <thead>
        <tr>
          <th>Hari</th>
          <th>Jam</th>
          <th>Siswa</th>
          <th>Staff</th>
          <th>Meja</th>
          <th>Ruangan</th>
          <?php if($ROLE==='superadmin'): ?><th>Aksi</th><?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach($JADWAL as $row): ?>
        <tr>
          <td><?= htmlspecialchars($row['hari']) ?></td>
          <td><?= $row['jam_mulai'] ?> - <?= $row['jam_selesai'] ?></td>
          <td><?= htmlspecialchars($row['siswa']) ?></td>
          <td><?= htmlspecialchars($row['staff']) ?></td>
          <td><?= htmlspecialchars($row['nomor_meja']) ?></td>
          <td><?= htmlspecialchars($row['nomor_ruangan']) ?></td>

          <?php if($ROLE==='superadmin'): ?>
          <td>
            <div class="actions">
              <button
                class="iconbtn btnEditJadwal"
                data-bs-toggle="modal"
                data-bs-target="#modalJadwal"
                data-id="<?= $row['jadwal_id'] ?>"
                data-hari="<?= $row['hari'] ?>"
                data-jam_mulai="<?= $row['jam_mulai'] ?>"
                data-jam_selesai="<?= $row['jam_selesai'] ?>"
                data-siswa="<?= $row['siswa_id'] ?>"
                data-staff="<?= $row['staff_id'] ?>"
                data-meja="<?= $row['meja_id'] ?>"
                data-ruangan="<?= $row['ruangan_id'] ?>"
              >Edit</button>

              <form method="post" action="jadwal_action.php" onsubmit="return confirm('Hapus jadwal ini?')" style="display:inline">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="jadwal_id" value="<?= $row['jadwal_id'] ?>">
                <button class="iconbtn danger">Hapus</button>
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
<!-- MODAL -->
<div class="modal fade" id="modalJadwal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="ttlJadwal">Tambah Jadwal</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form method="post" action="jadwal_action.php">
        <div class="modal-body">

          <input type="hidden" name="action" id="actJadwal" value="create">
          <input type="hidden" name="jadwal_id" id="idJadwal">

          <label>Hari</label>
          <select name="hari" id="hariJadwal" class="form-control">
            <option>Senin</option><option>Selasa</option>
            <option>Rabu</option><option>Kamis</option><option>Jumat</option>
          </select>

          <label>Jam Mulai</label>
          <input type="time" name="jam_mulai" id="jamMulai" class="form-control">

          <label>Jam Selesai</label>
          <input type="time" name="jam_selesai" id="jamSelesai" class="form-control">

          <label>Siswa</label>
          <select name="siswa_id" id="siswaJadwal" class="form-control">
            <?php foreach($SISWA as $s): ?>
              <option value="<?= $s['siswa_id'] ?>"><?= $s['nama'] ?></option>
            <?php endforeach; ?>
          </select>

          <label>Staff</label>
          <select name="staff_id" id="staffJadwal" class="form-control">
            <?php foreach($STAFF as $s): ?>
              <option value="<?= $s['staff_id'] ?>"><?= $s['nama'] ?></option>
            <?php endforeach; ?>
          </select>

          <label>Meja</label>
          <select name="meja_id" id="mejaJadwal" class="form-control">
            <?php foreach($MEJA as $m): ?>
              <option value="<?= $m['meja_id'] ?>"><?= $m['nomor_meja'] ?></option>
            <?php endforeach; ?>
          </select>

          <label>Ruangan</label>
          <select name="ruangan_id" id="ruanganJadwal" class="form-control">
            <?php foreach($RUANGAN as $r): ?>
              <option value="<?= $r['ruangan_id'] ?>"><?= $r['nomor_ruangan'] ?></option>
            <?php endforeach; ?>
          </select>

        </div>

        <div class="modal-footer">
          <button class="btnx secondary" data-bs-dismiss="modal">Batal</button>
          <button class="btnx">Simpan</button>
        </div>
      </form>

    </div>
  </div>
</div>
<?php endif; ?>

<script>
function filterTable(q, id){
  q = q.toLowerCase();
  document.querySelectorAll('#'+id+' tbody tr').forEach(r=>{
    r.style.display = r.innerText.toLowerCase().includes(q) ? '' : 'none';
  });
}

<?php if($ROLE==='superadmin'): ?>
document.querySelectorAll('.btnEditJadwal').forEach(b=>{
  b.addEventListener('click', ()=>{
    document.getElementById('ttlJadwal').innerText = 'Edit Jadwal';
    document.getElementById('actJadwal').value = 'update';
    document.getElementById('idJadwal').value = b.dataset.id;
    document.getElementById('hariJadwal').value = b.dataset.hari;
    document.getElementById('jamMulai').value = b.dataset.jam_mulai;
    document.getElementById('jamSelesai').value = b.dataset.jam_selesai;
    document.getElementById('siswaJadwal').value = b.dataset.siswa;
    document.getElementById('staffJadwal').value = b.dataset.staff;
    document.getElementById('mejaJadwal').value = b.dataset.meja;
    document.getElementById('ruanganJadwal').value = b.dataset.ruangan;
  });
});
<?php endif; ?>
</script>

<?php include 'inc/layout_bottom.php'; ?>