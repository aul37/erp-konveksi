<?php
require 'function_pembelian.php';
require 'cek.php';
require 'header_pembelian.php';

// Periksa apakah parameter pr_id tersedia dalam URL
if (isset($_GET['pr_id'])) {
	// Ambil nilai pr_id dari URL
	$pr_id = $_GET['pr_id'];

	// Query untuk menghapus data berdasarkan pr_id
	$query = "DELETE FROM pr WHERE pr_id = '$pr_id'";

	// Eksekusi query
	$result = mysqli_query($koneksi, $query);

	// Periksa apakah penghapusan berhasil
	if ($result) {
		// Jika berhasil, arahkan kembali ke halaman pr.php
		header('Location: pr_pembelian.php');
		exit(); // Hentikan eksekusi skrip setelah mengarahkan pengguna
	} else {
		// Jika gagal, tampilkan pesan kesalahan
		echo "<b>Failed to delete data!</b>";
	}
} else {
	// Jika pr_id tidak tersedia dalam URL, tampilkan pesan kesalahan
	echo "<b>Data does not exist!</b>";
}
