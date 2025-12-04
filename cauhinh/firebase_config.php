<?php
// cauhinh/firebase_config.php

if (!function_exists('loadEnv')) {
    require_once __DIR__ . '/env.php';
}

// Client-side config
$firebase_client_config = [
    'apiKey'            => $_ENV['FIREBASE_API_KEY'] ?? getenv('FIREBASE_API_KEY'),
    'authDomain'        => $_ENV['FIREBASE_AUTH_DOMAIN'] ?? getenv('FIREBASE_AUTH_DOMAIN'),
    'projectId'         => $_ENV['FIREBASE_PROJECT_ID'] ?? getenv('FIREBASE_PROJECT_ID'),
    'storageBucket'     => $_ENV['FIREBASE_STORAGE_BUCKET'] ?? getenv('FIREBASE_STORAGE_BUCKET'),
    'messagingSenderId' => $_ENV['FIREBASE_MESSAGING_SENDER_ID'] ?? getenv('FIREBASE_MESSAGING_SENDER_ID'), // ĐÃ SỬA: Bỏ dấu "_" ở giữa
    'appId'             => $_ENV['FIREBASE_APP_ID'] ?? getenv('FIREBASE_APP_ID'),
];

// Đường dẫn Service Account (Tính từ file này đi ra root)
$firebase_service_account_path = __DIR__ . '/../firebase_service_account.json';
?>