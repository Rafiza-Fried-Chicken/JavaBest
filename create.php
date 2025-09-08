<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['create'])) {
    $panel_name = trim($_POST['panel_name'] ?? '');

    if ($panel_name === '') {
        $error = "Nama panel tidak boleh kosong!";
    } elseif (!preg_match('/^[a-zA-Z0-9_-]+$/', $panel_name)) {
        $error = "Nama panel hanya boleh berisi huruf, angka, underscore (_) dan strip (-)";
    } else {
        $_SESSION['panel_name'] = $panel_name;

        $folder_panel = __DIR__ . "/$panel_name";
        $folder_panel_javabest = $folder_panel . "/Javabest";

        if (!is_dir($folder_panel)) {
            mkdir($folder_panel, 0777, true);
        }
        if (!is_dir($folder_panel_javabest)) {
            mkdir($folder_panel_javabest, 0777, true);
        }

        // Buat file apiii.php (dummy API)
        $api_file = $folder_panel . "/apiii.php";
        if (!file_exists($api_file)) {
            $api_content = "<?php\n// API panel untuk $panel_name\nheader('Content-Type: application/json');\necho json_encode(['status'=>'success','message'=>'API panel $panel_name aktif']);\n";
            file_put_contents($api_file, $api_content);
        }

        // Buat file index.php di Javabest (panel murni)
        $index_file = $folder_panel_javabest . "/index.php";
        if (!file_exists($index_file)) {
            $index_content = "<?php\n// Panel murni untuk $panel_name\n?>\n<!DOCTYPE html>\n<html><head><title>Panel $panel_name</title></head><body>\n<h2>Selamat datang di Panel $panel_name</h2>\n</body></html>";
            file_put_contents($index_file, $index_content);
        }

        header("Location: setting.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Panel</title>
</head>
<body>
    <h2>Create Panel</h2>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post" action="">
        <label>Nama Panel:</label><br>
        <input type="text" name="panel_name" required placeholder="Contoh: panelku"><br><br>
        <button type="submit" name="create">Create</button>
    </form>
</body>
</html>
