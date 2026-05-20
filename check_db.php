<?php
$mysqli = new mysqli("localhost", "root", "", "db_turnamen_esports");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
$result = $mysqli->query("SELECT id_akun, username, password FROM akun LIMIT 5");
while ($row = $result->fetch_assoc()) {
    echo "ID: {$row['id_akun']}, Username: {$row['username']}, Password: {$row['password']}\n";
}
$mysqli->close();
