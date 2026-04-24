<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'e_tamu';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "ALTER TABLE admin ADD COLUMN role ENUM('admin', 'petugas') NOT NULL DEFAULT 'admin' AFTER nama_lengkap";

if ($conn->query($sql) === TRUE) {
    echo "Success: Column 'role' added to 'admin' table.";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
