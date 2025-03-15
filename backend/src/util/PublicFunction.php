<?php
/**
 * 设置会话 Cookie
 *
 * @return void
 */
function setSessionCookie() {
    setcookie('session_id', session_id(), [
        'expires' => time() + 3600, // 3600秒（1小时）后过期
        'path' => '/',
        'domain' => 'your-allowed-domain.com', // 替换为允许的具体域名
        'secure' => true, // 确保使用HTTPS
        'httponly' => true,
        'samesite' => 'None' // 允许跨域请求携带cookie
    ]);
}

/**
 * 检查用户是否已登录
 *
 * @return bool 如果用户已登录返回 true，否则返回 false
 */
function checkLogin() {
    if (isset($_SESSION['user_id'])) {
        setSessionCookie();
        return true;
    } else {
        http_response_code(401);
        echo json_encode(['message' => 'Unauthorized']);
        return false;
    }
}
?>