<?php
session_start();
if (!isset($_SESSION['uang_dibayar']) || !isset($_SESSION['kembalian'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pembayaran</title>
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
        h2 {
            text-align: center;
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
    <h2 class="mb-3 text-center">Bukti Pembayaran</h2>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th colspan="2" class="text-center">Bukti Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>No. Transaksi</td>
                    <td>#<?php echo rand(10000000, 99999999); ?></td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td><?php echo date('F - j - Y'); ?></td>
                </tr>
                <?php foreach ($_SESSION['items'] as $key => $item): ?>
                <tr>
                    <td><?php echo $item['nama_barang']; ?></td>
                    <td>Rp. <?php echo number_format($item['harga_barang'], 2); ?> x <?php echo $item['jumlah_barang']; ?></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td>Uang Yang Dibayarkan</td>
                    <td>Rp. <?php echo number_format($_SESSION['uang_dibayar'], 2); ?></td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td>Rp. <?php echo number_format($_SESSION['total'], 2); ?></td>
                </tr>
                <tr>
                    <td>Kembalian</td>
                    <td>Rp. <?php echo number_format($_SESSION['kembalian'], 2); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <p class="mt-3 text-center">Terimakasih telah berbelanja di minimarket By #MafiaBasreng</p>
    <div class="text-center">
        <button class="btn btn-primary" onclick="window.location.href='index.php'">Kembali ke Beranda</button>
    </div>
</div>
</body>
</html>
<?php
// Clear session data after payment
session_unset();
session_destroy();
?>
