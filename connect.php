<?php
$mysqli = new mysqli("localhost", "polpos", "polpos", "tongcerdas");

// cek koneksi
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}

// ob_start();ob_flush();

?>