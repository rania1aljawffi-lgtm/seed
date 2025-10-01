<?php
// db.php - ملف الاتصال بقاعدة البيانات (PDO)
declare(strict_types=1);
session_start();

$host = '127.0.0.1';
$db   = 'seeds_db'; // غيّر إن أردت
$user = 'root';
$pass = ''; // ضع كلمة المرور إن وُجدت
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // أثناء التطوير اطبع الخطأ؛ في الإنتاج سجّل الخطأ فقط
    die('Database connection failed: ' . $e->getMessage());
}

// helper: current user
function current_user() {
    return isset($_SESSION['user']) ? $_SESSION['user'] : null;
}
?>
