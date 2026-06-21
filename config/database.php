<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "spk_hayo_chicken";

$conn = mysqli_connect($host, $user, $password, $db);
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>