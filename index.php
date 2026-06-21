<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit;
}

require 'config/database.php';
include 'includes/header.php';
include 'includes/navbar.php';

// Routing halaman
$page = isset($_GET['page']) ? $_GET['page'] : 'beranda';

echo '<main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">';

switch ($page) {
    case 'beranda':
        include 'pages/beranda.php';
        break;
    case 'data_master':
        include 'pages/data_master.php';
        break;
    case 'hasil_rekomendasi':
        include 'pages/hasil_rekomendasi.php';
        break;
    case 'kesimpulan':
        include 'pages/kesimpulan.php';
        break;
    default:
        include 'pages/beranda.php';
        break;
}

echo '</main>';
include 'includes/footer.php';
?>