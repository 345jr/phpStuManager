<?php

require_once __DIR__ . '/../service/AuthService.php';

class AuthController {
    private $authService;

    public function __construct($db) {
        $this->authService = new AuthService($db);
    }

    public function login($email, $password, $role) {
        if(isset($_SESSION['user_id'])){
            $this->respond(200, ['message' => 'User already logged in']);
        }
        $user = $this->authService->authenticate($email, $password, $role);
        if ($user) {
            // session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $role;      
            $this->respond(200, [
                'success' => true,
                'student' => [
                    'id' => $user['id'],
                    'email' => $email,
                    'role' => $role
                    
                ],
                'message' => 'Login successful'
            ]);
        } else {
            $this->respond(401, [
                'success' => false,
                'message' => 'Invalid email or password'
            ]);
        }
    }

    public function logout() {
        // session_start();
        session_unset();
        session_destroy();
        $this->respond(200, ['message' => 'Logout successful']);
    }

    // 响应处理方法
    private function respond($status, $data) {
        http_response_code($status);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($data , JSON_UNESCAPED_UNICODE);
    }

}
?>