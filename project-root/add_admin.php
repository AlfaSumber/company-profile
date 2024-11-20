<?php
include 'config.php';


$username = 'admin';       
$password = 'password123';  

$hashed_password = password_hash($password, PASSWORD_BCRYPT);

$sql = "INSERT INTO admin_users (username, password) VALUES (:username, :password)";
$stmt = $pdo->prepare($sql);

$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', $hashed_password);

if ($stmt->execute()) {
    echo "Admin user berhasil ditambahkan!";
} else {
    echo "Gagal menambahkan admin user.";
}
?>
