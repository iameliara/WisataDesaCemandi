<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_pengaduan";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Jika ada request POST, artinya form edit pengaduan dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $email = $_POST['email'];
    $nomorhp = $_POST['nomorhp'];
    $kategori = $_POST['kategori'];
    $pesan = $_POST['pesan'];
    $terima_email = isset($_POST['terima_email']) ? 1 : 0;
    $terima_sms = isset($_POST['terima_sms']) ? 1 : 0;
    $update_status = $_POST['update_status'];

    // Update data pengaduan di database
    $sql = "UPDATE pengaduan 
            SET nama = ?, nik = ?, email = ?, nomorhp = ?, kategori = ?, pesan = ?, terima_email = ?, terima_sms = ?, update_status = ?
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("ssssssiiis", $nama, $nik, $email, $nomorhp, $kategori, $pesan, $terima_email, $terima_sms, $update_status, $id);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Error updating pengaduan: " . $stmt->error;
    }
}

// Ambil data pengaduan berdasarkan id yang dikirim melalui parameter GET
$id = $_GET['id'];
$sql = "SELECT * FROM pengaduan WHERE id = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result === false) {
    die("Error executing statement: " . $stmt->error);
}
$row = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengaduan</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-4">Edit Pengaduan</h2>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($row['nama']); ?>" required>
            </div>
            <div class="form-group">
                <label for="nik">NIK</label>
                <input type="text" class="form-control" id="nik" name="nik" value="<?php echo htmlspecialchars($row['nik']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="nomorhp">Nomor HP</label>
                <input type="text" class="form-control" id="nomorhp" name="nomorhp" value="<?php echo htmlspecialchars($row['nomorhp']); ?>" required>
            </div>
            <div class="form-group">
                <label for="kategori">Kategori</label>
                <select class="form-control" id="kategori" name="kategori" required>
                    <option value="pelayanan" <?php echo $row['kategori'] == 'pelayanan' ? 'selected' : ''; ?>>Pelayanan</option>
                    <option value="produk" <?php echo $row['kategori'] == 'produk' ? 'selected' : ''; ?>>Produk</option>
                    <option value="lainnya" <?php echo $row['kategori'] == 'lainnya' ? 'selected' : ''; ?>>Lainnya</option>
                </select>
            </div>
            <div class="form-group">
                <label for="pesan">Pesan</label>
                <textarea class="form-control" id="pesan" name="pesan" rows="5" required><?php echo htmlspecialchars($row['pesan']); ?></textarea>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="terima_email" name="terima_email" <?php echo $row['terima_email'] ? 'checked' : ''; ?>>
                <label class="form-check-label" for="terima_email">Terima pemberitahuan melalui email</label>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="terima_sms" name="terima_sms" <?php echo $row['terima_sms'] ? 'checked' : ''; ?>>
                <label class="form-check-label" for="terima_sms">Terima pemberitahuan melalui SMS</label>
            </div>
            <div class="form-group">
                <label for="update_status">Update Status</label>
                <input type="text" class="form-control" id="update_status" name="update_status" value="<?php echo htmlspecialchars($row['update_status']); ?>">
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update Pengaduan</button>
        </form>
    </div>
</body>
</html>
