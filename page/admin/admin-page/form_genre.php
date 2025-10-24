<?php
$koneksi = new mysqli("localhost", "root", "", "askalamedia");

// --- VAR UNTUK NOTIFIKASI ---
$notifikasi = "";

// --- HAPUS DATA ---
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $koneksi->query("DELETE FROM genre WHERE ID_Genre = '$id'");
    $notifikasi = "<div class='alert alert-warning text-center fade-alert'>
        Data genre dengan ID <b>$id</b> berhasil dihapus!
    </div>";
}

// --- AMBIL DATA UNTUK EDIT ---
$edit_mode = false;
$edit_id = "";
$edit_genre = "";

if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $data_edit = $koneksi->query("SELECT * FROM genre WHERE ID_Genre = '$edit_id'");
    if ($data_edit->num_rows > 0) {
        $row = $data_edit->fetch_assoc();
        $edit_mode = true;
        $edit_genre = $row['Nama_Genre'];
    }
}

// --- SIMPAN DATA (TAMBAH / UPDATE) ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ID_Genre = trim($_POST['ID_Genre']);
    $Nama_Genre = trim($_POST['Nama_Genre']);

    if (!empty($ID_Genre) && !empty($Nama_Genre)) {
        if (isset($_POST['update'])) {
            $old_id = $_POST['old_id'];
            $koneksi->query("UPDATE genre 
                             SET ID_Genre='$ID_Genre', Nama_Genre='$Nama_Genre' 
                             WHERE ID_Genre='$old_id'");
            $notifikasi = "<div class='alert alert-info text-center fade-alert'>
                Data genre berhasil diperbarui!
            </div>";
        } else {
            $cek = $koneksi->query("SELECT * FROM genre WHERE ID_Genre='$ID_Genre'");
            if ($cek->num_rows > 0) {
                $notifikasi = "<div class='alert alert-danger text-center fade-alert'>
                    ID Genre <b>$ID_Genre</b> sudah ada! Gunakan ID lain.
                </div>";
            } else {
                $koneksi->query("INSERT INTO genre (ID_Genre, Nama_Genre) VALUES ('$ID_Genre', '$Nama_Genre')");
                $notifikasi = "<div class='alert alert-success text-center fade-alert'>
                    Data genre berhasil disimpan!
                </div>";
            }
        }
    } else {
        $notifikasi = "<div class='alert alert-danger text-center fade-alert'>
            Harap isi semua field dengan benar!
        </div>";
    }
}

// --- AMBIL SEMUA DATA GENRE ---
$data_genre = $koneksi->query("SELECT * FROM genre ORDER BY ID_Genre");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manajemen Genre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .fade-alert {
            opacity: 1;
            transition: opacity 1s ease-out;
        }

        .fade-alert.hide {
            opacity: 0;
        }
    </style>
    <script>
        function konfirmasiHapus(id) {
            if (confirm('Yakin ingin menghapus data dengan ID ' + id + '?')) {
                window.location = '?page=form_genre&hapus=' + id;
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
            <h3 class="mb-4 text-center"><?= $edit_mode ? 'Edit Data Genre' : 'Tambah Genre' ?></h3>

            <form action="?page=form_genre" method="POST">
                <div class="mb-3">
                    <label class="form-label">ID Genre</label>
                    <input type="text" name="ID_Genre" class="form-control"
                        value="<?= $edit_mode ? htmlspecialchars($edit_id) : '' ?>" placeholder="Masukkan ID genre"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Genre</label>
                    <textarea name="Nama_Genre" class="form-control" rows="2" placeholder="Tuliskan nama genre"
                        required><?= $edit_mode ? htmlspecialchars($edit_genre) : '' ?></textarea>
                </div>

                <?php if ($edit_mode): ?>
                    <input type="hidden" name="old_id" value="<?= htmlspecialchars($edit_id) ?>">
                    <button type="submit" name="update" class="btn btn-warning w-100">Update Data</button>
                    <a href="?page=form_genre" class="btn btn-secondary w-100 mt-2">Batal Edit</a>
                <?php else: ?>
                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                <?php endif; ?>
            </form>
        </div>

        <div class="card shadow-lg p-4 rounded-4">
            <h4 class="mb-3 text-center">Daftar Genre</h4>
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>ID Genre</th>
                        <th>Nama Genre</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    if ($data_genre->num_rows > 0) {
                        while ($row = $data_genre->fetch_assoc()) {
                            echo "<tr>
                                <td class='text-center'>$no</td>
                                <td class='text-center'>{$row['ID_Genre']}</td>
                                <td class='text-center'>{$row['Nama_Genre']}</td>
                                <td class='text-center'>
                                    <a href='?page=form_genre&edit={$row['ID_Genre']}' class='btn btn-warning btn-sm me-1'>Edit</a>
                                    <button class='btn btn-danger btn-sm' onclick=\"konfirmasiHapus('{$row['ID_Genre']}')\">Hapus</button>
                                </td>
                            </tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center text-muted'>Belum ada data genre.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
