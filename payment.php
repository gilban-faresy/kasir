<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
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
        h1 {
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
        .form-group input, .form-group button {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
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
    <h1 class="mb-3 text-center">Pembayaran</h1>
    <form action="" method="post">
        <?php 
        session_start();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $uang_dibayar = $_POST['uang_dibayar'];
            $total = $_SESSION['total'];
            if ($uang_dibayar < $total) {
                $kekurangan = $total - $uang_dibayar;
                echo "<div class='alert alert-danger'>Uang Anda kurang Rp. " . number_format($kekurangan, 2) . "</div>";
            } else {
                $kembalian = $uang_dibayar - $total;
                $_SESSION['kembalian'] = $kembalian;
                $_SESSION['uang_dibayar'] = $uang_dibayar;
                header('Location: receipt.php');
                exit;
            }
        }
        ?>
        <div class="form-group">
            <label for="uang_dibayar" class="form-label">Masukkan Nominal Uang :</label>
            <input type="number" name="uang_dibayar" id="uang_dibayar" placeholder="Masukkan jumlah uang" required>
        </div>
        <div class="form-group">
            <b>Total yang harus dibayarkan : Rp. <?php echo number_format($_SESSION['total'], 2); ?></b>
        </div>
        <div class="form-group">
            <button type="submit" class="btn">Bayar</button>
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Batal</button>
        </div>
    </form>
</div>
</body>
</html>
