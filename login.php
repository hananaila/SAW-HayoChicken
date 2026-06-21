<?php
session_start();

// Jika sudah login, langsung ke dashboard
if (isset($_SESSION['logged_in'])) {
    header("Location: index.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Hardcode autentikasi sederhana untuk Ibu Okti
    if (($username === 'okti' && $password === 'admin123') || ($username === 'admin' && $password === 'admin')) {
        $_SESSION['logged_in'] = true;
        $_SESSION['nama_user'] = 'Ibu Okti Salminah';
        header("Location: index.php");
        exit;
    } else {
        $error = 'Username atau password salah!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hayo Chicken SPK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fdf8f5;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl border border-red-50 p-8">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-100 text-red-600 mb-4">
                <i class="fa-solid fa-drumstick-bite text-3xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">SPK Hayo Chicken</h1>
            <p class="text-gray-500 text-sm mt-1">Silakan login untuk mengakses dashboard admin.</p>
        </div>

        <?php if ($error): ?>
            <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-600 text-sm flex items-center gap-3">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>
                    <?= $error ?>
                </span>
            </div>
        <?php endif; ?>

        <form method="POST" action="" class="space-y-5">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                        <i class="fa-regular fa-user"></i>
                    </span>
                    <input type="text" name="username" required autocomplete="off" placeholder="Masukkan username..."
                        class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-all text-gray-700">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password" name="password" required placeholder="Masukkan password..."
                        class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-all text-gray-700">
                </div>
            </div>

            <button type="submit"
                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-xl transition-colors shadow-lg shadow-red-600/30">
                Masuk Dashboard <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-100 text-center">
            <p class="text-xs text-gray-400">
                Tip: Gunakan username <span class="font-bold text-gray-500">okti</span> pass: <span
                    class="font-bold text-gray-500">admin123</span>
            </p>
        </div>
    </div>

</body>

</html>