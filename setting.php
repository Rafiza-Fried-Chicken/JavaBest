<?php
session_start();
if (!isset($_SESSION['logged_in']) || !isset($_SESSION['panel_name'])) {
    header("Location: login.php");
    exit;
}

$panel_name = $_SESSION['panel_name'];
$api_url = "https://javabest.my.id/$panel_name/apiii.php";
$panel_url = "https://javabest.my.id/$panel_name/Javabest";

if (isset($_POST['lihat'])) {
    header("Location: $panel_url");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Setting Panel</title>
</head>
<body>
    <h2>Setting Panel "<?php echo htmlspecialchars($panel_name); ?>"</h2>
    <form method="post" action="">
        <label>API URL Panel:</label><br>
        <input type="text" value="<?php echo htmlspecialchars($api_url); ?>" readonly style="width: 100%;"><br><br>

        <label>Link ke Panel:</label><br>
        <input type="text" value="<?php echo htmlspecialchars($panel_url); ?>" readonly style="width: 100%;"><br><br>

        <button type="submit" name="lihat">Lihat Panel</button>
    </form>
</body>
</html>
