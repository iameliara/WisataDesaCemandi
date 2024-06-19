<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Sesuaikan dengan username database Anda
$password = ""; // Sesuaikan dengan password database Anda
$dbname = "db_pengaduan";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$nama = $_POST['nama'];
$nik = $_POST['nik'];
$email = $_POST['email'];
$nomorhp = $_POST['nomorhp'];
$kategori = $_POST['kategori'];
$pesan = $_POST['pesan'];
$terima_email = isset($_POST['emailCheckbox']) ? 1 : 0;
$terima_sms = isset($_POST['smsCheckbox']) ? 1 : 0;

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO pengaduan (nama, nik, email, nomorhp, kategori, pesan, terima_email, terima_sms) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssii", $nama, $nik, $email, $nomorhp, $kategori, $pesan, $terima_email, $terima_sms);

// Execute the statement
if ($stmt->execute()) {
    echo "Pengaduan berhasil disimpan.";
} else {
    echo "Error: " . $stmt->error;
}
// Close connections
$stmt->close();
$conn->close();
?>
