<?php
require_once "db_config.php";

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'"
            ];
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

            // 验证字符集
            $stmt = $this->pdo->query("SHOW VARIABLES LIKE 'character_set_client'");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result['Value'] !== 'utf8mb4') {
                error_log("警告: character_set_client 不是 utf8mb4, 当前值: " . $result['Value']);
            }
        } catch (PDOException $e) {
            error_log("数据库连接失败: " . $e->getMessage());
            throw new Exception("数据库连接失败，请联系管理员。");
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}
?>
