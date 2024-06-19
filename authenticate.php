<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_pengaduan";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mengambil data dari form
$form_username = $_POST['username'];
$form_password = $_POST['password'];

// Mencari pengguna di basis data
$sql = "SELECT * FROM admin WHERE username = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}
$stmt->bind_param("s", $form_username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Username ditemukan, cek password
    $row = $result->fetch_assoc();
    if ($form_password === $row['password']) { // Bandingkan password teks biasa
        // Password benar, set session
        $_SESSION['admin'] = $row['username'];
        header("Location: admin_dashboard.php");
        exit();
    } else {
        // Password salah
        echo "Password salah";
    }
} else {
    // Username tidak ditemukan
    echo "Username tidak ditemukan";
}

$stmt->close();
$conn->close();
?>
