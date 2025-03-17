<?php
// deploy.php
$secret = 'trinhdev-hash-token'; // Thêm mã bí mật để bảo vệ webhook
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];

// Xác thực chữ ký
$payload = file_get_contents('php://input');
if ('sha1=' . hash_hmac('sha1', $payload, $secret) === $signature) {
    $output = shell_exec('pwd && cd ../ && git pull origin main');
    $output .= shell_exec('composer install --no-interaction --prefer-dist --optimize-autoloader');
    $output .= shell_exec('cd ../ && php -v && pwd ');
    $output .= shell_exec('php artisan config:cache');
    $output .= shell_exec('php artisan route:cache');
    echo "Deploy completed 123:\n" . $output;
    http_response_code(200);
} else {
    http_response_code(403);
}
