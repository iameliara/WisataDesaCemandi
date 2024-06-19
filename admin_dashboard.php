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

// Log kunjungan
$sql = "INSERT INTO kunjungan (timestamp) VALUES (NOW())";
$conn->query($sql);

// Dapatkan data untuk grafik batang (kunjungan)
$sql_kunjungan = "SELECT DATE(timestamp) as date, COUNT(*) as count FROM kunjungan GROUP BY DATE(timestamp)";
$kunjungan_result = $conn->query($sql_kunjungan);
$kunjungan_data = [];
while($row = $kunjungan_result->fetch_assoc()) {
    $kunjungan_data[] = $row;
}

// Dapatkan data untuk grafik donat (pengaduan berdasarkan kategori)
$sql_pengaduan = "SELECT kategori, COUNT(*) as count FROM pengaduan GROUP BY kategori";
$pengaduan_result = $conn->query($sql_pengaduan);
$pengaduan_data = [];
while($row = $pengaduan_result->fetch_assoc()) {
    $pengaduan_data[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
        .chart-title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mt-2">Admin Dashboard</h2>
        <a href="logout.php" class="btn btn-danger mb-3">Logout</a>

        <div class="row">
            <div class="col-md-8">
                <div class="chart-title">Data Kunjungan</div>
                <div class="chart-container">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
            <div class="col-md-4">
                <div class="chart-title">Data Pengaduan</div>
                <div class="chart-container">
                    <canvas id="donutChart"></canvas>
                </div>
            </div>
        </div>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>Email</th>
                    <th>Nomor HP</th>
                    <th>Kategori</th>
                    <th>Pesan</th>
                    <th>Terima Email</th>
                    <th>Terima SMS</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $result = $conn->query("SELECT * FROM pengaduan"); ?>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nama']; ?></td>
                    <td><?php echo $row['nik']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['nomorhp']; ?></td>
                    <td><?php echo $row['kategori']; ?></td>
                    <td><?php echo $row['pesan']; ?></td>
                    <td><?php echo $row['terima_email'] ? 'Yes' : 'No'; ?></td>
                    <td><?php echo $row['terima_sms'] ? 'Yes' : 'No'; ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                    <td>
                        <a href="edit_pengaduan.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_pengaduan.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        var barCtx = document.getElementById('barChart').getContext('2d');
        var colors = [
            'rgba(255, 99, 132, 1)', // Pink
            'rgba(255, 206, 86, 1)', // Yellow
            'rgba(54, 162, 235, 1)', // Blue
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
        ];
        var barChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: [
                    <?php
                    $dates = [];
                    foreach ($kunjungan_data as $data) {
                        $dates[] = $data['date'];
                    }
                    sort($dates);
                    echo '"' . implode('","', $dates) . '"';
                    ?>
                ],
                datasets: [{
                    label: '',
                    data: [
                        <?php
                        $data = [];
                        foreach ($dates as $date) {
                            $count = 0;
                            foreach ($kunjungan_data as $kd) {
                                if ($kd['date'] == $date) {
                                    $count = $kd['count'];
                                    break;
                                }
                            }
                            $data[] = $count;
                        }
                        echo implode(',', $data);
                        ?>
                    ],
                    backgroundColor: colors,
                    borderColor: colors,
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        var donutCtx = document.getElementById('donutChart').getContext('2d');
        var donutChart = new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: [
                    <?php
                    $categories = [];
                    foreach ($pengaduan_data as $data) {
                        $categories[] = '"' . $data['kategori'] . '"';
                    }
                    echo implode(',', $categories);
                    ?>
                ],
                datasets: [{
                    data: [
                        <?php
                        $counts = [];
                        foreach ($pengaduan_data as $data) {
                            $counts[] = $data['count'];
                        }
                        echo implode(',', $counts);
                        ?>
                    ],
                    backgroundColor: [
                        'rgba(255, 206, 86, 1)', // Yellow
                        'rgba(255, 99, 132, 1)', // Pink
                        'rgba(54, 162, 235, 1)'  // Blue
                    ],
                    borderColor: [
                        'rgba(255, 206, 86, 1)', // Yellow
                        'rgba(255, 99, 132, 1)', // Pink
                        'rgba(54, 162, 235, 1)'  // Blue
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
