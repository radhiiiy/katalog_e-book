<?php
$koneksi = new mysqli("localhost", "root", "", "askalamedia");

// --- VAR UNTUK NOTIFIKASI ---
$notifikasi = "";

// --- HAPUS DATA ---
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $koneksi->query("DELETE FROM buku WHERE ID_buku = '$id'");
    $notifikasi = "<div class='alert alert-warning text-center fade-alert'>
        Data buku dengan ID <b>$id</b> berhasil dihapus!
    </div>";
}

// --- AMBIL DATA UNTUK EDIT ---
$edit_mode = false;
$edit_id = "";
$edit_judul = "";
$edit_penulis = "";
$edit_cover = "";
$edit_jml = "";

if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $data_edit = $koneksi->query("SELECT * FROM buku WHERE ID_buku = '$edit_id'");
    if ($data_edit->num_rows > 0) {
        $row = $data_edit->fetch_assoc();
        $edit_mode = true;
        $edit_judul = $row['Judul'];
        $edit_penulis = $row['Penulis'];
        $edit_cover = $row['Cover'];
        $edit_jml = $row['Jml_tiruan'];
    }
}

// --- SIMPAN DATA (TAMBAH / UPDATE) ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ID_buku = trim($_POST['ID_buku']);
    $Judul   = trim($_POST['Judul']);
    $Penulis = trim($_POST['Penulis']);
    $Cover   = trim($_POST['Cover']);
    $Jumlah  = intval($_POST['Jumlah_tiruan']);

    if (!empty($ID_buku) && !empty($Judul)) {
        if (isset($_POST['update'])) {
            $old_id = $_POST['old_id'];
            $koneksi->query("UPDATE buku 
                             SET ID_buku='$ID_buku', Judul='$Judul', Penulis='$Penulis', Cover='$Cover', Jml_tiruan='$Jumlah' 
                             WHERE ID_buku='$old_id'");
            $notifikasi = "<div class='alert alert-info text-center fade-alert'>Data buku berhasil diperbarui!</div>";
        } else {
            $cek = $koneksi->query("SELECT * FROM buku WHERE ID_buku='$ID_buku'");
            if ($cek->num_rows > 0) {
                $notifikasi = "<div class='alert alert-danger text-center fade-alert'>
                    ID Buku <b>$ID_buku</b> sudah ada! Gunakan ID lain.
                </div>";
            } else {
                $koneksi->query("INSERT INTO buku (ID_buku, Judul, Penulis, Cover, Jml_tiruan) 
                                 VALUES ('$ID_buku', '$Judul', '$Penulis', '$Cover', '$Jumlah')");
                $notifikasi = "<div class='alert alert-success text-center fade-alert'>
                    Data buku berhasil disimpan!
                </div>";
            }
        }
    }
}

// --- AMBIL SEMUA DATA BUKU ---
$data_buku = $koneksi->query("SELECT * FROM buku ORDER BY ID_buku");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manajemen Buku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .fade-alert { opacity: 1; transition: opacity 1s ease-out; }
    .fade-alert.hide { opacity: 0; }
  </style>
  <script>
    function konfirmasiHapus(id) {
      if (confirm('Yakin ingin menghapus data dengan ID ' + id + '?')) {
        window.location = '?page=form_buku&hapus=' + id;
      }
    }

    document.addEventListener("DOMContentLoaded", () => {
      const alertBox = document.querySelector(".fade-alert");
      if (alertBox) {
        setTimeout(() => {
          alertBox.classList.add("hide");
          setTimeout(() => alertBox.remove(), 800);
        }, 1500);
      }
    });
  </script>
</head>

<body class="bg-light">
  <div class="container mt-4">

    <!-- Notifikasi -->
    <?php if (!empty($notifikasi)) echo $notifikasi; ?>

    <div class="card shadow-lg p-4 rounded-4 mb-4">
      <h3 class="mb-4 text-center"><?= $edit_mode ? 'Edit Data Buku' : 'Tambah Buku' ?></h3>

      <form action="?page=form_buku" method="POST">
        <div class="mb-3">
          <label class="form-label">ID Buku</label>
          <input type="text" name="ID_buku" class="form-control"
                 value="<?= $edit_mode ? htmlspecialchars($edit_id) : '' ?>"
                 placeholder="Masukkan ID buku" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Judul Buku</label>
          <textarea name="Judul" class="form-control" rows="2"
                    placeholder="Tuliskan judul buku" required><?= $edit_mode ? htmlspecialchars($edit_judul) : '' ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Penulis</label>
          <input type="text" name="Penulis" class="form-control"
                 value="<?= $edit_mode ? htmlspecialchars($edit_penulis) : '' ?>"
                 placeholder="Masukkan nama penulis" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Cover (nama file / link)</label>
          <input type="text" name="Cover" class="form-control"
                 value="<?= $edit_mode ? htmlspecialchars($edit_cover) : '' ?>"
                 placeholder="contoh: cover1.jpg atau https://example.com/cover.png" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Jumlah Tiruan</label>
          <input type="number" name="Jumlah_tiruan" class="form-control"
                 value="<?= $edit_mode ? htmlspecialchars($edit_jml) : '' ?>"
                 placeholder="Masukkan jumlah tiruan" required>
        </div>

        <?php if ($edit_mode): ?>
          <input type="hidden" name="old_id" value="<?= htmlspecialchars($edit_id) ?>">
          <button type="submit" name="update" class="btn btn-warning w-100">Update Data</button>
          <a href="?page=form_buku" class="btn btn-secondary w-100 mt-2">Batal Edit</a>
        <?php else: ?>
          <button type="submit" class="btn btn-primary w-100">Simpan</button>
        <?php endif; ?>
      </form>
    </div>

    <div class="card shadow-lg p-4 rounded-4">
      <h4 class="mb-3 text-center">Daftar Buku</h4>
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark text-center">
          <tr>
            <th>No</th>
            <th>ID Buku</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Cover</th>
            <th>Jumlah Tiruan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          if ($data_buku->num_rows > 0) {
              while ($row = $data_buku->fetch_assoc()) {
                  echo "<tr>
                          <td class='text-center'>$no</td>
                          <td class='text-center'>{$row['ID_buku']}</td>
                          <td class='text-center'>{$row['Judul']}</td>
                          <td class='text-center'>{$row['Penulis']}</td>
                          <td class='text-center'>{$row['Cover']}</td>
                          <td class='text-center'>{$row['Jml_tiruan']}</td>
                          <td class='text-center'>
                            <a href='?page=form_buku&edit={$row['ID_buku']}' class='btn btn-warning btn-sm me-1'>Edit</a>
                            <button class='btn btn-danger btn-sm' onclick=\"konfirmasiHapus('{$row['ID_buku']}')\">Hapus</button>
                          </td>
                        </tr>";
                  $no++;
              }
          } else {
              echo "<tr><td colspan='7' class='text-center text-muted'>Belum ada data buku.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
