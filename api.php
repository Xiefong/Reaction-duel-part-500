<?php
header('Content-Type: application/json');
require 'db.php';
$pdo = getDB();
$data = json_decode(file_get_contents("php://input"), true);
$action = $_GET['action'] ?? '';

if ($action === 'register') {
    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$data['username'], $data['email'], $data['password']]);
        echo json_encode(["success" => true]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Username/Email sudah terdaftar!"]);
    }
} 
elseif ($action === 'login') {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE (username = ? OR email = ?) AND password = ?");
    $stmt->execute([$data['id'], $data['id'], $data['password']]);
    $user = $stmt->fetch();
    if ($user) {
        echo json_encode(["success" => true, "user" => [
            "username" => $user['username'], "level" => $user['level'], 
            "totalXP" => $user['total_xp'], "bestTime" => $user['best_time'], "icon" => $user['icon']
        ]]);
    } else {
        echo json_encode(["success" => false, "message" => "Akun salah!"]);
    }
}
elseif ($action === 'save_session') {
    $stmt = $pdo->prepare("INSERT INTO history (username, score, avg_time, best_time, xp_earned, mode) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$data['username'], $data['score'], $data['avgTime'], $data['bestTime'], $data['xp'], $data['mode']]);
    
    $stmt2 = $pdo->prepare("UPDATE users SET total_xp = total_xp + ?, level = ?, best_time = ? WHERE username = ?");
    $stmt2->execute([$data['xp'], $data['newLevel'], $data['bestTime'], $data['username']]);
    echo json_encode(["success" => true]);
}
elseif ($action === 'get_dashboard') {
    $lb = $pdo->query("SELECT username, total_xp as score, best_time as bestTime FROM users ORDER BY total_xp DESC LIMIT 10")->fetchAll();
    $hist = $pdo->query("SELECT * FROM history ORDER BY created_at DESC LIMIT 20")->fetchAll();
    echo json_encode(["success" => true, "leaderboard" => $lb, "history" => $hist]);
}
?>