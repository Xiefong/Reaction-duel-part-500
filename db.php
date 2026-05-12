<?php
function getDB() {
    static $pdo = null;
    if ($pdo !== null) return $pdo;
    
    // Cek semua variasi nama variabel Railway agar tidak ada yang terlewat
    $host = getenv('MYSQLHOST') ?: getenv('MYSQL_HOST');
    $port = getenv('MYSQLPORT') ?: getenv('MYSQL_PORT'); 
    $db   = getenv('MYSQLDATABASE') ?: getenv('MYSQL_DATABASE') ?: 'railway';
    $user = getenv('MYSQLUSER') ?: getenv('MYSQL_USER');
    $pass = getenv('MYSQLPASSWORD') ?: getenv('MYSQL_PASSWORD');

    try {
        // 1. Konek ke MySQL secara umum (TANPA menyebutkan nama database dulu)
        $pdoTemp = new PDO("mysql:host={$host};port={$port};charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);

        // 2. Paksa pembuatan database jika ternyata Railway belum membuatnya
        $pdoTemp->exec("CREATE DATABASE IF NOT EXISTS `$db`");
        $pdoTemp->exec("USE `$db`"); // Masuk ke database tersebut

        // 3. Otomatis buat tabel-tabelnya
        $pdoTemp->exec("CREATE TABLE IF NOT EXISTS users (
            username VARCHAR(50) PRIMARY KEY,
            password VARCHAR(100),
            email VARCHAR(100),
            level INT DEFAULT 1,
            total_xp INT DEFAULT 0,
            best_time INT DEFAULT 0,
            icon VARCHAR(50) DEFAULT 'fa-user'
        )");

        $pdoTemp->exec("CREATE TABLE IF NOT EXISTS history (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50),
            score INT,
            avg_time INT,
            best_time INT,
            xp_earned INT,
            mode VARCHAR(50),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        $pdoTemp->exec("CREATE TABLE IF NOT EXISTS rooms (
            room_id INT AUTO_INCREMENT PRIMARY KEY,
            player1 VARCHAR(50) NOT NULL,
            player2 VARCHAR(50) DEFAULT NULL,
            p1_ready INT DEFAULT 0,
            p2_ready INT DEFAULT 0,
            status VARCHAR(20) DEFAULT 'waiting',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        $pdo = $pdoTemp;
        return $pdo;

    } catch (\PDOException $e) {
        echo json_encode(["success" => false, "message" => "DB Error: " . $e->getMessage()]);
        exit;
    }
}
?>
