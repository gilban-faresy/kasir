<?php
session_start();

if (!isset($_SESSION['items'])) {
    $_SESSION['items'] = [];
    $_SESSION['total'] = 0;
}

if (isset($_POST['tambah'])) {
    if (!empty($_POST['nama_barang']) && !empty($_POST['harga_barang']) && !empty($_POST['jumlah_barang'])) {
        $nama_barang = $_POST['nama_barang'];
        $harga_barang = $_POST['harga_barang'];
        $jumlah_barang = $_POST['jumlah_barang'];
        $total_harga = $harga_barang * $jumlah_barang;

        $item = [
            'nama_barang' => $nama_barang,
            'harga_barang' => $harga_barang,
            'jumlah_barang' => $jumlah_barang,
            'total_harga' => $total_harga
        ];

        array_push($_SESSION['items'], $item);
        $_SESSION['total'] += $total_harga;
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

if (isset($_GET['hapus'])) {
    $key = $_GET['hapus'];
    unset($_SESSION['items'][$key]);
    $_SESSION['items'] = array_values($_SESSION['items']); // Reindex the array
    $_SESSION['total'] = array_sum(array_column($_SESSION['items'], 'total_harga')); // Recalculate total
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f2f2f2;
        }
        .container {
            width: 90%;
            max-width: 800px;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2, h3 {
            text-align: center;
        }
        form {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .form-group {
            width: 48%;
            margin-bottom: 10px;
        }
        .form-group input, .form-group button, .form-group select {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            text-align: center;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="add">  
        <h2 class="mb-3">Masukkan Data Barang!</h2>
        <form action="" method="post">
            <div class="form-group">
                <input type="text" name="nama_barang" id="nama_barang" placeholder="Nama Barang" required>
            </div>
            <div class="form-group">
                <input type="number" name="harga_barang" id="harga_barang" placeholder="Harga Barang" required>
            </div>
            <div class="form-group">
                <input type="number" name="jumlah_barang" id="jumlah_barang" placeholder="Jumlah Barang" required>
            </div>
            <div class="form-group">
                <button type="submit" name="tambah" class="btn">Tambah</button>
                <?php if (!empty($_SESSION['items'])): ?>
                    <a href="payment.php" class="btn btn-secondary">Bayar</a>
                <?php endif; ?>
            </div>
        </form>
        <hr>
    </div>
    <?php 
    if (!empty($_SESSION['items'])) {
        echo "<div class='items'>";
        echo '<h3 class="text-center mb-4">STRUK PEMBELIAN</h3>';
        echo '<table class="table">';
        echo "<thead><tr><th>No</th><th>Nama Barang</th><th>Harga</th><th>Jumlah</th><th>Total Harga</th><th>Action</th></tr></thead><tbody>";
        foreach ($_SESSION['items'] as $key => $item) {
            echo "<tr>";
            echo "<td>" . ($key + 1) . "</td>";
            echo "<td>" . $item['nama_barang'] . "</td>";
            echo "<td>Rp. " . number_format($item['harga_barang'], 2) . "</td>";
            echo "<td>" . $item['jumlah_barang'] . "</td>";
            echo "<td>Rp. " . number_format($item['total_harga'], 2) . "</td>";
            echo '<td><a href="?hapus=' . $key . '" class="btn btn-danger">Hapus</a></td>';
            echo "</tr>";
        }
        echo '<tr><td colspan="5" class="text-center">Total Pembayaran :</td><td>Rp. ' . number_format($_SESSION['total'], 2) . '</td></tr>';
        echo "</tbody></table>";
        echo "</div>"; // Close div here
    } else {
        echo "<div class='items'>"; // Open div here for empty case
        echo '<table class="table">';
        echo "<thead><tr><th>No</th><th>Nama Barang</th><th>Harga</th><th>Jumlah</th><th>Action</th></tr></thead>";
        echo "<tbody><tr><td colspan='5' class='text-center text-danger py-4'>Tidak Ada Data</td></tr></tbody>";
        echo "</table>";
        echo "</div>"; // Close div here for empty case
    }
    ?>
</div>
</body>
</html>
