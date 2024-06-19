<?php
// Detail koneksi database
$servername = "localhost";
$username = "root"; // Sesuaikan dengan username database Anda
$password = ""; // Sesuaikan dengan password database Anda
$dbname = "db_pengaduan";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = "admin";
$password_plain = "admin123"; // Password dalam bentuk teks biasa

$sql = "INSERT INTO admin (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password_plain);

if ($stmt->execute()) {
    echo "Admin user created successfully";
} else {
    echo "Error: " . $stmt->error;
}

// Menutup koneksi
$stmt->close();
$conn->close();
?>
