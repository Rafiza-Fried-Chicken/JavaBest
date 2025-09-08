<?php
session_start();
if (!isset($_SESSION['logged_in']) || !isset($_SESSION['panel_name'])) {
    header("Location: login.php");
    exit;
}

$panel_name = $_SESSION['panel_name'];

// Inisialisasi data panel di session
if (!isset($_SESSION['panel_data'])) {
    $_SESSION['panel_data'] = [
        'nama_ress' => '',
        'panel_murni' => "https://javabest.my.id/$panel_name/Javabest",
        'emails' => [], // array ['email'=>..., 'ress'=>...]
        'total_ress' => 0,
    ];
}

$data = &$_SESSION['panel_data'];
$message = '';

// Fungsi dummy add API ke pusat, misal dapat 100 ress
function addApiToPusat($api_url) {
    // Contoh curl ke pusat.php bisa ditambahkan di sini
    return 100;
}

// Handle ganti nama ress
if (isset($_POST['ganti_data'])) {
    $nama_ress = trim($_POST['nama_ress'] ?? '');
    if ($nama_ress !== '') {
        $data['nama_ress'] = $nama_ress;
        $message = "Nama ress berhasil diganti.";
    } else {
        $message = "Nama ress tidak boleh kosong.";
    }
}

// Handle tambah email
if (isset($_POST['tambah_email'])) {
    $email = trim($_POST['email_tujuan'] ?? '');
    $jumlah_ress = intval($_POST['jumlah_ress'] ?? 0);

    if (filter_var($email, FILTER_VALIDATE_EMAIL) && $jumlah_ress > 0) {
        if ($jumlah_ress <= $data['total_ress']) {
            $data['total_ress'] -= $jumlah_ress;
            $data['emails'][] = [
                'email' => $email,
                'ress' => $jumlah_ress,
            ];
            $message = "Email berhasil ditambahkan ke riwayat.";
        } else {
            $message = "Jumlah ress melebihi total ress yang tersedia.";
        }
    } else {
        $message = "Email tidak valid atau jumlah ress tidak valid.";
    }
}

// Handle hapus email
if (isset($_POST['hapus_email'])) {
    $index = intval($_POST['hapus_index']);
    if (isset($data['emails'][$index])) {
        $data['total_ress'] += $data['emails'][$index]['ress'];
        unset($data['emails'][$index]);
        $data['emails'] = array_values($data['emails']);
        $message = "Email berhasil dihapus dari riwayat.";
    }
}

// Handle add API ke pusat
if (isset($_POST['add_api'])) {
    $api_url = "https://javabest.my.id/$panel_name/apiii.php";
    $ress_didapat = addApiToPusat($api_url);
    $data['total_ress'] += $ress_didapat;
    $message = "API berhasil ditambahkan, ress bertambah $ress_didapat.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel <?php echo htmlspecialchars($panel_name); ?></title>
</head>
<body>
    <h2>Panel <?php echo htmlspecialchars($panel_name); ?></h2>

    <!-- Logo -->
    <div>
        <img src="image/logonya/logo.png" alt="Logo" style="width:100px;height:100px;">
    </div>

    <!-- Form ganti nama ress -->
    <form method="post" action="">
        <label>Nama Ress (akan masuk ke Gmail):</label><br>
        <input type="text" name="nama_ress" value="<?php echo htmlspecialchars($data['nama_ress']); ?>" required><br><br>

        <label>Panel Murni (tidak bisa diubah):</label><br>
        <input type="text" value="<?php echo htmlspecialchars($data['panel_murni']); ?>" readonly style="width: 100%;"><br><br>

        <button type="submit" name="ganti_data">Ganti Data</button>
    </form>

    <hr>

    <!-- Form tambah email -->
    <form method="post" action="">
        <label>Tambah Email:</label><br>
        <input type="email" name="email_tujuan" placeholder="Masukkan email tujuan" required><br><br>

        <label>Jumlah Ressult:</label><br>
        <input type="number" name="jumlah_ress" min="1" max="<?php echo $data['total_ress']; ?>" required><br><br>

        <button type="submit" name="tambah_email">Tambah Email</button>
    </form>

    <p>Total Ress tersedia: <?php echo $data['total_ress']; ?></p>

    <hr>

    <!-- Riwayat email -->
    <h3>Riwayat Email</h3>
    <?php if (count($data['emails']) === 0): ?>
        <p>Belum ada riwayat email.</p>
    <?php else: ?>
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>Email</th>
                <th>Jumlah Ress</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($data['emails'] as $i => $email_data): ?>
                <tr>
                    <td><?php echo htmlspecialchars($email_data['email']); ?></td>
                    <td><?php echo $email_data['ress']; ?></td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="hapus_index" value="<?php echo $i; ?>">
                            <button type="submit" name="hapus_email" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <hr>

    <!-- Tombol add API -->
    <form method="post" action="">
        <button type="submit" name="add_api">Add API ke pusat</button>
    </form>

    <?php if ($message !== ''): ?>
        <p style="color:green;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
</body>
</html>
